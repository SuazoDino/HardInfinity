<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\UserInteraction;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Mostrar catálogo de productos
     */
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category', 'images'])
            ->active()
            ->inStock();

        // Filtros
        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->brand) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }

        // Ordenamiento
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);

        return Inertia::render('Shop/Products/Index', [
            'products' => $products,
            'categories' => Category::active()->get(),
            'brands' => Brand::all(),
            'filters' => $request->only(['category', 'brand', 'min_price', 'max_price', 'search', 'sort']),
        ]);
    }

    /**
     * Mostrar detalle de producto
     */
    public function show($slug)
    {
        $product = Product::with(['brand', 'category', 'images', 'specifications'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Incrementar vistas
        $product->incrementViews();

        // Registrar interacción del usuario (IA/Recomendaciones)
        if (auth()->check()) {
            UserInteraction::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'type' => 'view',
            ]);
        }

        // Productos relacionados
        $related_products = Product::with(['brand', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->take(4)
            ->get();

        // Reseñas
        $rating_avg = round($product->reviews()->avg('rating') ?? 0, 1);
        $rating_count = $product->reviews()->count();
        $reviews = Review::with('user')
            ->where('product_id', $product->id)
            ->latest()
            ->take(15)
            ->get();

        $user_review = null;
        $in_wishlist = false;

        if (auth()->check()) {
            $user_review = Review::where('product_id', $product->id)
                ->where('user_id', auth()->id())
                ->first();

            $in_wishlist = Wishlist::where('product_id', $product->id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        return Inertia::render('Shop/Products/Show', [
            'product' => $product,
            'related_products' => $related_products,
            'rating_avg' => $rating_avg,
            'rating_count' => $rating_count,
            'reviews' => $reviews,
            'user_review' => $user_review,
            'in_wishlist' => $in_wishlist,
        ]);
    }

    /**
     * Mostrar productos en oferta (destacados)
     */
    public function ofertas(Request $request)
    {
        $query = Product::with(['brand', 'category', 'images'])
            ->active()
            ->inStock()
            ->featured(); // Solo productos destacados

        // Mantener los mismos filtros que el catálogo
        if ($request->brand) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }

        // Ordenar
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('Shop/Products/Index', [
            'products' => $products,
            'categories' => Category::active()->main()->get(),
            'brands' => Brand::all(),
            'filters' => [
                'search' => $request->search,
                'category' => $request->category,
                'brand' => $request->brand,
                'min_price' => $request->min_price,
                'max_price' => $request->max_price,
                'sort' => $sortBy,
            ],
            'pageTitle' => '🔥 Ofertas Especiales',
            'pageDescription' => 'Productos destacados seleccionados por nuestro equipo',
        ]);
    }
}
