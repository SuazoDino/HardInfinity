<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UserInteraction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Mostrar el carrito de compras
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Calcular totales
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return Inertia::render('Shop/Cart/Index', [
            'cart' => $cart,
            'total' => $total
        ]);
    }

    /**
     * Agregar producto al carrito
     */
    public function store(Request $request)
    {
        $product = Product::with(['images', 'brand', 'category'])->findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        $quantity = $request->quantity ?? 1;

        // Si el producto ya existe, actualizamos cantidad
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // Si no, lo agregamos
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->images->where('is_primary', true)->first()->image_path ?? ($product->images->first()->image_path ?? '/images/placeholder-product.png'),
                'slug' => $product->slug,
                'brand' => $product->brand->name ?? '',
                'category' => $product->category->name ?? '',
                'stock' => $product->stock
            ];
        }

        session()->put('cart', $cart);

        // Registrar interacción (IA/Recomendaciones)
        if (auth()->check()) {
            UserInteraction::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'type' => 'cart_add',
            ]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito exitosamente');
    }

    /**
     * Actualizar cantidad de un item
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Carrito actualizado');
    }

    /**
     * Eliminar item del carrito
     */
    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }
}
