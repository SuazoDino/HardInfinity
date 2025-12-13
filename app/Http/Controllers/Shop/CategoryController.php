<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Listar todas las categorías visualmente
     */
    public function index()
    {
        $categories = Category::active()
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return Inertia::render('Shop/Categories/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Mostrar productos de una categoría (Redirige al catálogo con filtro)
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->active()
            ->firstOrFail();

        // En lugar de una vista separada, reutilizamos el Catálogo filtrado
        // Esto mantiene la consistencia de la UI y los filtros laterales
        
        // Pasamos los parámetros manualmente al controlador de productos o redirigimos
        // Una redirección es lo más simple y limpio para SEO (URL canónica)
        return to_route('shop.products.index', ['category' => $category->slug]);
    }
}
