<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\PaymentMethod;
use App\Models\Transaction;
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

        try {
            DB::beginTransaction();

            // Crear la orden
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'status' => $request->payment_method === 'cash' ? 'pending' : 'paid',
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'discount' => $discount,
                'coupon_code' => $couponCode,
                'tax' => $subtotal * 0.18,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'pending' : 'paid',
                'shipping_address' => $request->address . ', ' . $request->city . '. Tel: ' . $request->phone,
                'notes' => 'Pago con: ' . $request->payment_method . ($couponCode ? ' | Cupón: ' . $couponCode : ''),
            ]);

            // Crear items de la orden
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);
                
                // Opcional: Descontar stock aquí
                // $product = Product::find($item['id']);
                // $product->decrement('stock', $item['quantity']);
            }

            // Registrar transacción simulada
            $pmName = match ($request->payment_method) {
                'card' => 'Tarjeta de Crédito/Débito',
                'yape' => 'Yape',
                'cash' => 'Contra Entrega',
                default => 'Otro',
            };

            $paymentMethod = PaymentMethod::where('name', $pmName)->first();

            Transaction::create([
                'order_id' => $order->id,
                'payment_method_id' => $paymentMethod?->id,
                'transaction_code' => 'SIM-' . strtoupper(substr(uniqid(), -8)),
                'status' => $order->payment_status,
                'amount' => $total,
                'details' => 'Pago simulado vía ' . $pmName,
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

