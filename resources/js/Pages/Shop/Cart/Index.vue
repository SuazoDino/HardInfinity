<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    cart: Object,
    total: Number,
});

const page = usePage();
const user = computed(() => page.props.auth.user);

const cartItems = computed(() => Object.values(props.cart));
const shippingCost = computed(() => props.total > 500 ? 0 : 15);
const finalTotal = computed(() => props.total + shippingCost.value);

const updateQuantity = (id, quantity, stock) => {
    if (quantity < 1 || quantity > stock) return;
    router.put(route('cart.update', id), { quantity }, {
        preserveScroll: true,
    });
};

const removeItem = (id) => {
    router.delete(route('cart.destroy', id), {
        preserveScroll: true,
    });
};

const proceedToCheckout = () => {
    // Intentar ir al checkout. Si no está logueado, Laravel redirigirá al login
    // y luego recordará volver al checkout (comportamiento estándar de 'auth' middleware).
    router.get(route('shop.checkout.index'));
};
</script>

<template>
    <AppLayout>
        <Head title="Carrito de Compras" />

        <div class="container mx-auto px-4 py-12">
            <h1 class="text-3xl font-display font-bold text-white mb-8">Tu Carrito de Compras</h1>

            <div v-if="cartItems.length > 0" class="flex flex-col lg:flex-row gap-8">
                <!-- Lista de Productos -->
                <div class="flex-1 space-y-4">
                    <div v-for="item in cartItems" :key="item.id" 
                        class="bg-dark-card border border-white/5 rounded-xl p-4 flex gap-4 items-center group hover:border-brand-500/30 transition-colors"
                    >
                        <!-- Imagen -->
                        <div class="w-24 h-24 bg-white/5 rounded-lg p-2 flex-shrink-0">
                            <img :src="item.image" :alt="item.name" class="w-full h-full object-contain" />
                        </div>

                        <!-- Detalles -->
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs text-brand-400 font-bold uppercase mb-1">{{ item.brand }}</p>
                                    <h3 class="text-white font-bold truncate pr-4 hover:text-brand-300">
                                        <Link :href="route('shop.products.show', item.slug)">{{ item.name }}</Link>
                                    </h3>
                                    <p class="text-sm text-gray-500">{{ item.category }}</p>
                                </div>
                                <button @click="removeItem(item.id)" class="text-gray-500 hover:text-red-400 transition-colors p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>

                            <div class="flex justify-between items-end mt-4">
                                <div class="flex items-center bg-dark-bg border border-white/10 rounded-lg">
                                    <button @click="updateQuantity(item.id, item.quantity - 1, item.stock)" class="px-3 py-1 text-gray-400 hover:text-white font-bold">-</button>
                                    <span class="text-white font-bold px-2 w-8 text-center">{{ item.quantity }}</span>
                                    <button @click="updateQuantity(item.id, item.quantity + 1, item.stock)" class="px-3 py-1 text-gray-400 hover:text-white font-bold">+</button>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Total Item</p>
                                    <p class="text-lg font-bold text-white">S/ {{ (item.price * item.quantity).toFixed(2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen del Pedido -->
                <div class="w-full lg:w-96 flex-shrink-0">
                    <div class="bg-dark-card border border-white/5 rounded-xl p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-white mb-6">Resumen del Pedido</h2>
                        
                        <div class="space-y-3 text-sm border-b border-white/10 pb-6 mb-6">
                            <div class="flex justify-between text-gray-400">
                                <span>Subtotal</span>
                                <span class="text-white">S/ {{ total.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-400">
                                <span>Envío</span>
                                <span v-if="shippingCost === 0" class="text-green-400 font-bold">GRATIS</span>
                                <span v-else class="text-white">S/ {{ shippingCost.toFixed(2) }}</span>
                            </div>
                            <p v-if="shippingCost > 0" class="text-xs text-gray-500 mt-2">
                                ¡Agrega S/ {{ (500 - total).toFixed(2) }} más para envío gratis!
                            </p>
                        </div>

                        <div class="flex justify-between items-center mb-8">
                            <span class="text-lg font-bold text-white">Total</span>
                            <span class="text-2xl font-bold text-brand-400">S/ {{ finalTotal.toFixed(2) }}</span>
                        </div>

                        <button 
                            @click="proceedToCheckout"
                            class="w-full py-4 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all flex items-center justify-center gap-2"
                        >
                            <span>🔒</span> Proceder al Pago
                        </button>

                        <div class="mt-6 flex justify-center gap-4 text-2xl grayscale opacity-50">
                            <span>💳</span> <span>📱</span> <span>🏦</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty Cart -->
            <div v-else class="text-center py-20 bg-dark-card border border-white/5 rounded-2xl">
                <div class="text-6xl mb-6">🛒</div>
                <h2 class="text-2xl font-bold text-white mb-2">Tu carrito está vacío</h2>
                <p class="text-gray-400 mb-8">Parece que aún no has agregado nada.</p>
                <Link :href="route('shop.products.index')" class="px-8 py-3 bg-brand-600 text-white font-bold rounded-lg hover:bg-brand-500 transition-colors">
                    Ir al Catálogo
                </Link>
            </div>
        </div>
    </AppLayout>
</template>

