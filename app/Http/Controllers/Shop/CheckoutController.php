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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'transaction_code' => 'nullable|string|max:50', // Validar código yape
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return to_route('shop.cart.index')->with('error', 'El carrito está vacío.');
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
        
        $total = $subtotal + $shipping - $discount;

        // Calcular base imponible e IGV (asumiendo precios incluyen IGV 18%)
        // Base Imponible = Total / 1.18
        // IGV = Total - Base Imponible
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

