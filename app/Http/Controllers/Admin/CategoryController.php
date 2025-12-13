<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Listar todas las categorías
     */
    public function index()
    {
        $categories = Category::with(['parent', 'children'])
            ->withCount('products')
            ->latest()
            ->get();

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return Inertia::render('Admin/Categories/Create', [
            'categories' => Category::main()->active()->get(),
        ]);
    }

    /**
     * Guardar nueva categoría
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría creada exitosamente');
    }

    /**
     * Mostrar categoría específica
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'products']);

        return Inertia::render('Admin/Categories/Show', [
            'category' => $category,
        ]);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Category $category)
    {
        $category->load(['parent', 'children']);

        return Inertia::render('Admin/Categories/Edit', [
            'category' => $category,
            'categories' => Category::main()->active()->where('id', '!=', $category->id)->get(),
        ]);
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        // Evitar que sea su propio padre
        if (isset($validated['parent_id']) && $validated['parent_id'] == $category->id) {
            $validated['parent_id'] = null;
        }

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return back()->with('success', 'Categoría actualizada exitosamente');
    }

    /**
     * Eliminar categoría
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una categoría con productos asociados');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría eliminada exitosamente');
    }

    /**
     * Cambiar estado activo/inactivo
     */
    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        return back()->with('success', 'Estado actualizado');
    }
}
