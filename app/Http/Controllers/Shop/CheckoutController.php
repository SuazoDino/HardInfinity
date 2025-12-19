<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\UserCard; // Agregar modelo
use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    /**
     * Mostrar formulario de checkout
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return to_route('shop.cart.index');
        }

        // Calcular totales
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return Inertia::render('Shop/Checkout/Index', [
            'cart' => $cart,
            'subtotal' => $total,
            'shipping' => $total > 500 ? 0 : 15, // Envío gratis > 500
        ]);
    }

    /**
     * Procesar la orden
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:card,yape,cash',
            'transaction_code' => 'required_if:payment_method,yape|nullable|string|max:50',
            // Validación OBLIGATORIA para tarjeta si se selecciona 'card'
            'card_number' => 'required_if:payment_method,card|nullable|string|min:13|max:19',
            'card_holder' => 'required_if:payment_method,card|nullable|string|max:255',
            'card_exp' => 'required_if:payment_method,card|nullable|string|max:5',
            'card_cvv' => 'required_if:payment_method,card|nullable|string|min:3|max:4',
            'save_card' => 'boolean',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return to_route('shop.cart.index')->with('error', 'El carrito está vacío.');
        }

        // SEGURIDAD: Guardar tarjeta si se solicitó
        // IMPORTANTE: SOLO guardamos los últimos 4 dígitos (NUNCA el número completo ni CVV)
        if ($request->payment_method === 'card' && $request->save_card && $request->card_number) {
            $firstDigit = substr($request->card_number, 0, 1);
            $brand = match($firstDigit) {
                '4' => 'Visa',
                '5' => 'Mastercard',
                '3' => 'Amex',
                default => 'Desconocida'
            };
            
            $exp = explode('/', $request->card_exp);
            $expMonth = $exp[0] ?? '00';
            $expYear = $exp[1] ?? '00';

            // Solo se guardan datos NO sensibles (últimos 4 dígitos)
            UserCard::create([
                'user_id' => auth()->id(),
                'brand' => $brand,
                'last_four' => substr($request->card_number, -4), // Solo últimos 4 dígitos
                'holder_name' => $request->card_holder ?? 'NO NAME',
                'exp_month' => $expMonth,
                'exp_year' => $expYear,
            ]);
            // NOTA: El número completo y CVV NUNCA se guardan en la base de datos
        }

        // Calcular totales finales
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $shipping = $subtotal > 500 ? 0 : 15;
        
        // Aplicar cupón si existe
        $discount = 0;
        $couponCode = null;
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();
            if ($coupon && $coupon->isValid($subtotal)) {
                $discount = $coupon->calculateDiscount($subtotal);
                $couponCode = $coupon->code;
                $coupon->incrementUse();
            }
        }
        
        // Total = Subtotal + Envío - Descuento
        $total = $subtotal + $shipping - $discount;

        // Calcular base imponible e IGV (precios YA incluyen IGV 18%)
        // Base Imponible = Subtotal / 1.18
        // IGV = Subtotal - Base Imponible
        $base_imponible = $subtotal / 1.18;
        $igv = $subtotal - $base_imponible;

        try {
            DB::beginTransaction();

            // Crear la orden
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'status' => $request->payment_method === 'cash' ? 'pending' : 'paid',
                'subtotal' => $subtotal, // Guardamos el subtotal bruto (con impuestos)
                'shipping_cost' => $shipping,
                'discount' => $discount,
                'coupon_code' => $couponCode,
                'tax' => $igv, // Guardamos el monto del impuesto calculado
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'pending' : 'paid',
                'shipping_address' => $request->address . ', ' . $request->city . '. Tel: ' . $request->phone,
                'notes' => 'Pago con: ' . $request->payment_method . ($couponCode ? ' | Cupón: ' . $couponCode : ''),
            ]);

            // Crear items de la orden y descontar stock
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
                
                // Descontar stock y registrar movimiento de inventario
                InventoryMovement::registrar(
                    $item['id'], 
                    'salida', 
                    $item['quantity'], 
                    'Venta - Orden #' . $order->order_number,
                    $order->id,
                    auth()->id()
                );
            }

            // Registrar transacción simulada
            $pmName = match ($request->payment_method) {
                'card' => 'Tarjeta de Crédito/Débito',
                'yape' => 'Yape',
                'cash' => 'Contra Entrega',
                default => 'Otro',
            };

            $paymentMethod = PaymentMethod::where('name', $pmName)->first();

            $transactionStatus = match ($order->payment_status) {
                'paid' => 'success',
                'pending' => 'pending',
                'failed' => 'failed',
                default => 'pending',
            };
            
            // Detalles de la transacción
            $details = 'Pago simulado vía ' . $pmName;
            if ($request->payment_method === 'yape' && $request->transaction_code) {
                $details .= '. Cod. Op: ' . $request->transaction_code;
            }

            Transaction::create([
                'order_id' => $order->id,
                'payment_method_id' => $paymentMethod?->id,
                'transaction_code' => 'SIM-' . strtoupper(substr(uniqid(), -8)),
                'status' => $transactionStatus,
                'amount' => $total,
                'details' => $details,
            ]);

            DB::commit();

            // Cargar relaciones para el correo
            $order->load(['user', 'items.product']);

            // Enviar correo de confirmación
            try {
                Mail::to(auth()->user()->email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                // Si falla el envío del correo, no afectamos la orden
                \Log::error('Error al enviar correo de confirmación: ' . $e->getMessage());
            }

            // Limpiar carrito
            session()->forget('cart');

            return to_route('shop.checkout.success', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al procesar tu pedido: ' . $e->getMessage());
        }
    }

    /**
     * Página de éxito
     */
    public function success($order_number)
    {
        return Inertia::render('Shop/Checkout/Success', [
            'order_number' => $order_number
        ]);
    }
}

