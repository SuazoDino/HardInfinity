<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Generar PDF de reporte de ventas
     */
    public function ventasPdf(Request $request)
    {
        $desde = $request->desde ? Carbon::parse($request->desde) : Carbon::now()->startOfMonth();
        $hasta = $request->hasta ? Carbon::parse($request->hasta) : Carbon::now()->endOfMonth();

        // Estadísticas del período
        $ordenes = Order::whereBetween('created_at', [$desde, $hasta])->get();
        
        $stats = [
            'periodo' => $desde->format('d/m/Y') . ' - ' . $hasta->format('d/m/Y'),
            'total_ordenes' => $ordenes->count(),
            'total_ingresos' => $ordenes->where('status', '!=', 'cancelled')->sum('total_amount'),
            'total_productos_vendidos' => $ordenes->where('status', '!=', 'cancelled')
                ->flatMap(fn($o) => $o->items)->sum('quantity'),
            'ticket_promedio' => $ordenes->where('status', '!=', 'cancelled')->avg('total_amount'),
        ];

        // Productos más vendidos
        $topProductos = Product::withCount(['orderItems' => function($q) use ($desde, $hasta) {
            $q->whereHas('order', function($query) use ($desde, $hasta) {
                $query->whereBetween('created_at', [$desde, $hasta])
                      ->where('status', '!=', 'cancelled');
            });
        }])
        ->with('brand')
        ->having('order_items_count', '>', 0)
        ->orderBy('order_items_count', 'desc')
        ->take(10)
        ->get();

        // Ventas por día
        $ventasPorDia = $ordenes->where('status', '!=', 'cancelled')
            ->groupBy(fn($order) => $order->created_at->format('Y-m-d'))
            ->map(fn($group) => [
                'fecha' => Carbon::parse($group->first()->created_at)->format('d/m/Y'),
                'total' => $group->sum('total_amount'),
                'ordenes' => $group->count(),
            ])
            ->values();

        $pdf = Pdf::loadView('pdf.reporte-ventas', [
            'stats' => $stats,
            'topProductos' => $topProductos,
            'ventasPorDia' => $ventasPorDia,
            'generado' => now()->format('d/m/Y H:i:s'),
        ]);

        return $pdf->download('reporte-ventas-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Generar PDF de reporte de inventario
     */
    public function inventarioPdf()
    {
        $productos = Product::with(['brand', 'category'])
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->get();

        $stats = [
            'total_productos' => $productos->count(),
            'stock_total' => $productos->sum('stock'),
            'valor_inventario' => $productos->sum(fn($p) => $p->stock * $p->price),
            'productos_bajo_stock' => $productos->where('stock', '<', 10)->count(),
            'productos_sin_stock' => $productos->where('stock', 0)->count(),
        ];

        $pdf = Pdf::loadView('pdf.reporte-inventario', [
            'productos' => $productos,
            'stats' => $stats,
            'generado' => now()->format('d/m/Y H:i:s'),
        ]);

        return $pdf->download('reporte-inventario-' . now()->format('Y-m-d') . '.pdf');
    }
}

