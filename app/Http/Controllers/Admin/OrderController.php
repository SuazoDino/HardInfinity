<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
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
}
