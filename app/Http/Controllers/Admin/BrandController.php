<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BrandController extends Controller
{
    /**
     * Listar todas las marcas
     */
    public function index()
    {
        $brands = Brand::withCount('products')
            ->latest()
            ->get();

        return Inertia::render('Admin/Brands/Index', [
            'brands' => $brands,
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return Inertia::render('Admin/Brands/Create');
    }

    /**
     * Guardar nueva marca
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Brand::create($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca creada exitosamente');
    }

    /**
     * Mostrar marca específica
     */
    public function show(Brand $brand)
    {
        $brand->load(['products']);

        return Inertia::render('Admin/Brands/Show', [
            'brand' => $brand,
        ]);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Brand $brand)
    {
        return Inertia::render('Admin/Brands/Edit', [
            'brand' => $brand,
        ]);
    }

    /**
     * Actualizar marca
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'logo_url' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $brand->update($validated);

        return back()->with('success', 'Marca actualizada exitosamente');
    }

    /**
     * Eliminar marca
     */
    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una marca con productos asociados');
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca eliminada exitosamente');
    }
}
