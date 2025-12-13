<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Mostrar dashboard del administrador
     */
    public function index()
    {
        // Estadísticas principales
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'low_stock' => Product::where('stock', '<', 10)->where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'paid_orders' => Order::where('status', 'paid')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            
            'total_customers' => User::whereHas('role', function($q) {
                $q->where('name', 'Customer');
            })->count(),
            
            'total_categories' => Category::count(),
            
            'total_revenue' => Order::where('status', 'paid')
                ->orWhere('status', 'shipped')
                ->orWhere('status', 'delivered')
                ->sum('total_amount'),
        ];

        // Últimas órdenes
        $recent_orders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(10)
            ->get();

        // Productos con bajo stock
        $low_stock_products = Product::with(['brand', 'category'])
            ->where('stock', '<', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->take(10)
            ->get();

        // Productos más vendidos (Corrección para PostgreSQL)
        // Usamos withCount para agregar la columna 'order_items_count'
        // y ordenamos por ella. Quitamos HAVING para evitar errores de alias.
        $top_products = Product::withCount('orderItems')
            ->with(['brand', 'category'])
            ->orderBy('order_items_count', 'desc')
            ->take(10)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recent_orders' => $recent_orders,
            'low_stock_products' => $low_stock_products,
            'top_products' => $top_products,
        ]);
    }

    /**
     * Mostrar perfil del administrador
     */
    public function profile()
    {
        return Inertia::render('Admin/Profile', [
            'user' => auth()->user()->load('role'),
        ]);
    }

    /**
     * Actualizar datos del perfil
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Actualizar contraseña
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8', 'different:current_password'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Contraseña actualizada exitosamente.');
    }
}
