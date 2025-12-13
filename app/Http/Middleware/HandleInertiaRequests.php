<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // Calcular cantidad total de items en el carrito
        $cart = $request->session()->get('cart', []);
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['quantity'] ?? 1;
        }

        // Contar órdenes pendientes para admins
        $pendingOrdersCount = 0;
        if ($request->user() && $request->user()->role->name === 'Admin') {
            $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'role' => $request->user()->role->name ?? null,
                ] : null,
            ],
            'cart_count' => $cartCount,
            'pending_orders_count' => $pendingOrdersCount,
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
        ];
    }
}
