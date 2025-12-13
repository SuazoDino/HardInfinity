<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\UserInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Mostrar la página principal de la tienda
     */
    public function index()
    {
        // Productos destacados
        $featured_products = Product::with(['brand', 'category', 'images'])
            ->active()
            ->featured()
            ->inStock()
            ->take(8)
            ->get();

        // Si no hay destacados, mostrar los más recientes
        if ($featured_products->isEmpty()) {
            $featured_products = Product::with(['brand', 'category', 'images'])
                ->active()
                ->inStock()
                ->latest()
                ->take(8)
                ->get();
        }

        // Productos recomendados (IA/Machine Learning básico)
        $recommended_products = $this->getRecommendedProducts();

        // Categorías principales
        $main_categories = Category::main()
            ->active()
            ->withCount('products')
            ->take(6)
            ->get();

        // Marcas principales
        $brands = Brand::withCount('products')
            ->take(12)
            ->get();

        return Inertia::render('Shop/Home', [
            'featured_products' => $featured_products,
            'recommended_products' => $recommended_products,
            'main_categories' => $main_categories,
            'brands' => $brands,
        ]);
    }

    /**
     * Obtener productos recomendados basados en IA/ML
     * Utiliza las interacciones del usuario para recomendar productos similares
     */
    private function getRecommendedProducts()
    {
        if (!auth()->check()) {
            // Si no está autenticado, mostrar productos más vendidos o recientes
            return Product::with(['brand', 'category', 'images'])
                ->active()
                ->inStock()
                ->latest()
                ->take(8)
                ->get();
        }

        // Obtener las categorías de productos que el usuario ha visto o agregado al carrito
        $userCategoryIds = UserInteraction::where('user_id', auth()->id())
            ->join('products', 'user_interactions.product_id', '=', 'products.id')
            ->select('products.category_id')
            ->distinct()
            ->pluck('category_id')
            ->toArray();

        if (empty($userCategoryIds)) {
            // Si no tiene historial, mostrar productos populares
            return Product::with(['brand', 'category', 'images'])
                ->active()
                ->inStock()
                ->withCount('orderItems')
                ->orderBy('order_items_count', 'desc')
                ->take(8)
                ->get();
        }

        // Obtener IDs de productos que ya ha visto para no recomendarlos de nuevo
        $viewedProductIds = UserInteraction::where('user_id', auth()->id())
            ->where('type', 'view')
            ->where('created_at', '>=', now()->subDays(30)) // Solo los últimos 30 días
            ->pluck('product_id')
            ->toArray();

        // Recomendar productos de las mismas categorías que no ha visto
        return Product::with(['brand', 'category', 'images'])
            ->active()
            ->inStock()
            ->whereIn('category_id', $userCategoryIds)
            ->whereNotIn('id', $viewedProductIds)
            ->inRandomOrder() // Aleatoriedad para variedad
            ->take(8)
            ->get();
    }
}
