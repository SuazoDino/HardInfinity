<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    /**
     * Historial de movimientos de inventario
     */
    public function index(Request $request)
    {
        $query = InventoryMovement::with(['product', 'order', 'user'])
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $movements = $query->paginate(20);
        $products = Product::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Admin/Inventory/Index', [
            'movements' => $movements,
            'products' => $products,
            'filters' => [
                'product_id' => $request->product_id,
                'type' => $request->type,
            ]
        ]);
    }

    /**
     * Ajuste manual de inventario
     */
    public function ajustar(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|not_in:0',
            'reason' => 'required|string|max:255',
        ]);

        try {
            $type = $request->quantity > 0 ? 'entrada' : 'ajuste';
            
            InventoryMovement::registrar(
                $request->product_id,
                $type,
                abs($request->quantity),
                $request->reason,
                null,
                auth()->id()
            );

            return back()->with('success', 'Inventario ajustado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al ajustar inventario: ' . $e->getMessage());
        }
    }

    /**
     * Productos con stock bajo
     */
    public function stockBajo()
    {
        $products = Product::where('stock', '<=', 10)
            ->where('is_active', true)
            ->with(['brand', 'category'])
            ->orderBy('stock', 'asc')
            ->paginate(20);

        return Inertia::render('Admin/Inventory/StockBajo', [
            'products' => $products
        ]);
    }
}
