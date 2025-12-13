<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Controladores de Autenticación
use App\Http\Controllers\Auth\AuthController;

// Controladores de Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ShipmentController;

// Controladores de Shop
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\Shop\CategoryController as ShopCategoryController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\ProfileController;
use App\Http\Controllers\Shop\ReviewController;
use App\Http\Controllers\Shop\WishlistController;
use App\Http\Controllers\Shop\CouponController as ShopCouponController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas - Tienda
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('productos')->name('shop.products.')->group(function () {
    Route::get('/', [ShopProductController::class, 'index'])->name('index');
    Route::get('/{slug}', [ShopProductController::class, 'show'])->name('show');
});

Route::get('/ofertas', [ShopProductController::class, 'ofertas'])->name('shop.ofertas');

Route::get('/categorias', [ShopCategoryController::class, 'index'])->name('shop.categories.index');
Route::get('/categoria/{slug}', [ShopCategoryController::class, 'show'])->name('shop.category');

Route::prefix('carrito')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/agregar', [CartController::class, 'store'])->name('store');
    Route::put('/actualizar/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/eliminar/{id}', [CartController::class, 'destroy'])->name('destroy');
});

// Validar cupón
Route::post('/coupon/validate', [ShopCouponController::class, 'validateCoupon'])->name('coupon.validate');

// Rutas de Checkout
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('shop.checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('shop.checkout.store');
    Route::get('/checkout/exito/{order}', [CheckoutController::class, 'success'])->name('shop.checkout.success');
    
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Perfil de Usuario
    Route::get('/mi-cuenta/pedidos', [ProfileController::class, 'orders'])->name('profile.orders');
    
    Route::get('/mi-cuenta/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mi-cuenta/perfil', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/mi-cuenta/seguridad', [ProfileController::class, 'security'])->name('profile.security');
    Route::put('/mi-cuenta/password', [ProfileController::class, 'password'])->name('profile.password');
    
    Route::get('/mi-cuenta/direcciones', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::post('/mi-cuenta/direcciones', [ProfileController::class, 'addressStore'])->name('profile.addresses.store');
    Route::delete('/mi-cuenta/direcciones/{id}', [ProfileController::class, 'addressDestroy'])->name('profile.addresses.destroy');
});

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Recuperación de contraseña
    Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'requestForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\PasswordResetController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas del Panel de Administración
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Perfil de Admin
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [DashboardController::class, 'updatePassword'])->name('profile.password');
    
    // Gestión de Productos
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    
    // Gestión de Categorías
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    
    // Gestión de Marcas
    Route::resource('brands', BrandController::class);
    
    // Gestión de Órdenes
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders/{order}/pdf', [OrderController::class, 'downloadPdf'])->name('orders.download-pdf');
    
    // Gestión de Usuarios
    Route::resource('users', UserController::class);
    
    // Gestión de Cupones
    Route::resource('coupons', CouponController::class);
    
    // Gestión de Envíos
    Route::post('orders/{order}/shipment', [ShipmentController::class, 'store'])->name('orders.shipment.store');
});
