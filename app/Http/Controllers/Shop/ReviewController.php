<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Verificar que el usuario haya comprado el producto
        $hasPurchased = OrderItem::where('product_id', $validated['product_id'])
            ->whereHas('order', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Solo puedes calificar productos que hayas comprado.');
        }

        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return back()->with('success', '¡Gracias por tu reseña!');
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return back()->with('success', 'Reseña actualizada.');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Reseña eliminada.');
    }
}

