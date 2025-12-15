<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Listar todos los productos
     */
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category', 'images']);

        // Filtros
        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%')
                  ->orWhere('sku', 'ilike', '%' . $request->search . '%');
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->status !== null) {
            $query->where('is_active', $request->status);
        }

        $products = $query->latest()->paginate(15);

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
            'filters' => $request->only(['search', 'category_id', 'brand_id', 'status']),
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return Inertia::render('Admin/Products/Create', [
            'categories' => Category::active()->get(),
            'brands' => Brand::all(),
        ]);
    }

    /**
     * Guardar nuevo producto
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB
            'specifications' => 'nullable|array',
            'specifications.*.spec_name' => 'nullable|string|max:255',
            'specifications.*.spec_value' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;

        $product = Product::create($validated);

        // Guardar imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => '/storage/' . $path,
                    'is_primary' => $index === 0, // La primera imagen es la principal
                ]);
            }
        }

        // Guardar especificaciones
        if ($request->has('specifications')) {
            foreach ($request->specifications as $spec) {
                if (!empty($spec['spec_name']) && !empty($spec['spec_value'])) {
                    $product->specifications()->create([
                        'spec_name' => $spec['spec_name'],
                        'spec_value' => $spec['spec_value'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Mostrar producto específico
     */
    public function show(Product $product)
    {
        $product->load(['brand', 'category', 'images', 'specifications']);
        
        return Inertia::render('Admin/Products/Show', [
            'product' => $product,
        ]);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Product $product)
    {
        $product->load(['brand', 'category', 'images', 'specifications']);

        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'categories' => Category::active()->get(),
            'brands' => Brand::all(),
        ]);
    }

    /**
     * Actualizar producto
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'new_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB
            'images_to_delete' => 'nullable|array',
            'images_to_delete.*' => 'nullable|integer|exists:product_images,id',
            'specifications' => 'nullable|array',
            'specifications.*.spec_name' => 'nullable|string|max:255',
            'specifications.*.spec_value' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;

        $product->update($validated);

        // Eliminar imágenes marcadas
        if ($request->has('images_to_delete') && is_array($request->images_to_delete)) {
            foreach ($request->images_to_delete as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    // Eliminar archivo físico
                    $imagePath = str_replace('/storage/', '', $image->image_path);
                    \Storage::disk('public')->delete($imagePath);
                    // Eliminar registro de BD
                    $image->delete();
                }
            }
        }

        // Guardar nuevas imágenes
        if ($request->hasFile('new_images')) {
            $existingImagesCount = $product->images()->count();
            foreach ($request->file('new_images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => '/storage/' . $path,
                    'is_primary' => $existingImagesCount === 0 && $index === 0, // Si no hay imágenes, la primera es principal
                ]);
            }
        }

        // Actualizar especificaciones (eliminar todas y recrear)
        if ($request->has('specifications')) {
            $product->specifications()->delete();
            foreach ($request->specifications as $spec) {
                if (!empty($spec['spec_name']) && !empty($spec['spec_value'])) {
                    $product->specifications()->create([
                        'spec_name' => $spec['spec_name'],
                        'spec_value' => $spec['spec_value'],
                    ]);
                }
            }
        }

        return back()->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Eliminar producto
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente');
    }

    /**
     * Cambiar estado activo/inactivo
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Estado actualizado');
    }

    /**
     * Cambiar estado destacado
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        return back()->with('success', 'Producto destacado actualizado');
    }
}
