<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::where('user_id', auth()->id())
            ->with(['product.images', 'product.brand'])
            ->latest()
            ->get();

        return Inertia::render('Shop/Profile/Wishlist', [
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return back()->with('success', 'Este producto ya está en tu lista de deseos.');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return back()->with('success', 'Producto agregado a tu lista de deseos.');
    }

    public function destroy($productId)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->delete();

        return back()->with('success', 'Producto eliminado de tu lista de deseos.');
    }
}

