<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Listar todas las órdenes
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Filtros
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('order_number', 'ilike', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'ilike', '%' . $request->search . '%')
                        ->orWhere('email', 'ilike', '%' . $request->search . '%');
                  });
        }

        $orders = $query->latest()->paginate(20);

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    /**
     * Mostrar orden específica
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product.brand', 'transactions.paymentMethod']);

        return Inertia::render('Admin/Orders/Show', [
            'order' => $order,
        ]);
    }

    /**
     * Actualizar estado de la orden
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        return back()->with('success', 'Estado de la orden actualizado');
    }

    /**
     * Generar PDF de la orden
     */
    public function downloadPdf(Order $order)
    {
        $order->load(['user', 'items.product.brand', 'transactions.paymentMethod']);

        $pdf = Pdf::loadView('pdf.order', ['order' => $order]);
        
        return $pdf->download('orden-' . $order->order_number . '.pdf');
    }

    /**
     * Estornar orden (devolver stock al inventario)
     */
    public function estornar(Order $order)
    {
        // Validar que la orden esté en estado cancelado o pueda cancelarse
        if (!in_array($order->status, ['pending', 'paid', 'cancelled'])) {
            return back()->with('error', 'No se puede estornar una orden que ya fue enviada o entregada.');
        }

        try {
            DB::beginTransaction();

            // Verificar si ya fue estornada
            $yaEstornada = InventoryMovement::where('order_id', $order->id)
                ->where('type', 'estorno')
                ->exists();

            if ($yaEstornada) {
                return back()->with('error', 'Esta orden ya fue estornada anteriormente.');
            }

            // Devolver stock de cada producto
            foreach ($order->items as $item) {
                InventoryMovement::registrar(
                    $item->product_id,
                    'estorno',
                    $item->quantity,
                    'Estorno - Orden cancelada #' . $order->order_number,
                    $order->id,
                    auth()->id()
                );
            }

            // Cambiar estado de la orden a cancelado
            $order->update(['status' => 'cancelled']);

            DB::commit();

            return back()->with('success', 'Orden estornada exitosamente. El stock ha sido devuelto al inventario.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al estornar la orden: ' . $e->getMessage());
        }
    }
}
