<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\UserAddress;
use Barryvdh\DomPDF\Facade\Pdf;

class ProfileController extends Controller
{
    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Shop/Profile/Orders', [
            'orders' => $orders
        ]);
    }

    public function edit()
    {
        return Inertia::render('Shop/Profile/Edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $request->user()->update($validated);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function security()
    {
        return Inertia::render('Shop/Profile/Security');
    }

    public function password(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    public function addresses()
    {
        $addresses = UserAddress::where('user_id', auth()->id())->get();

        return Inertia::render('Shop/Profile/Addresses', [
            'addresses' => $addresses
        ]);
    }

    public function addressStore(Request $request)
    {
        $validated = $request->validate([
            'address_line1' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
        ]);

        $request->user()->addresses()->create($validated);

        return back()->with('success', 'Dirección agregada correctamente.');
    }

    public function addressDestroy($id)
    {
        $address = UserAddress::where('user_id', auth()->id())->findOrFail($id);
        $address->delete();

        return back()->with('success', 'Dirección eliminada.');
    }

    /**
     * Descargar PDF de una orden del usuario
     */
    public function downloadOrderPdf(Order $order)
    {
        // Verificar que la orden pertenece al usuario autenticado
        if ($order->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver esta orden.');
        }

        $order->load(['user', 'items.product.brand', 'transactions.paymentMethod']);

        $pdf = Pdf::loadView('pdf.order', ['order' => $order]);
        
        return $pdf->download('mi-orden-' . $order->order_number . '.pdf');
    }
}
