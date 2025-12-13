<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const page = usePage();
const auth = computed(() => page.props.auth);
const cartCount = computed(() => page.props.cart_count);
const mobileMenuOpen = ref(false);
const searchQuery = ref('');

const handleSearch = () => {
    if (searchQuery.value.trim()) {
        router.get(route('shop.products.index'), { search: searchQuery.value });
    }
};
</script>

<template>
    <nav class="fixed w-full z-50 top-0 transition-all duration-300 bg-[#0B0E14]/80 backdrop-blur-xl border-b border-white/5">
        <!-- Promo Bar -->
        <div class="bg-gradient-to-r from-brand-600 to-blue-600 text-[11px] font-bold text-white py-1.5 text-center tracking-wide uppercase">
            🚀 Envío Gratis en Lima Metropolitana desde S/ 500
        </div>

        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <Link :href="route('home')" class="flex items-center space-x-2 group">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-brand-500 rounded-lg blur opacity-25 group-hover:opacity-75 transition duration-200"></div>
                        <div class="relative bg-dark-card p-1.5 rounded-lg border border-white/10">
                            <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    <span class="text-2xl font-display font-bold tracking-tight text-white">
                        Hard<span class="text-brand-400">Infinity</span>
                    </span>
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8">
                    <Link :href="route('shop.products.index')" class="text-sm font-medium text-gray-400 hover:text-white transition-colors py-1 hover:border-b-2 border-brand-500">Productos</Link>
                    <Link :href="route('shop.categories.index')" class="text-sm font-medium text-gray-400 hover:text-white transition-colors py-1 hover:border-b-2 border-brand-500">Categorías</Link>
                    <Link :href="route('shop.products.index', { sort: 'latest' })" class="text-sm font-medium text-gray-400 hover:text-white transition-colors py-1 hover:border-b-2 border-brand-500">Nuevos</Link>
                    <Link :href="route('shop.ofertas')" class="text-sm font-medium text-brand-400 hover:text-brand-300 transition-colors flex items-center gap-1">
                        <span>Ofertas</span>
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                        </span>
                    </Link>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:block flex-1 max-w-md mx-8">
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-brand-500 to-blue-600 rounded-full blur opacity-20 group-focus-within:opacity-50 transition duration-200"></div>
                        <div class="relative flex items-center">
                            <input 
                                v-model="searchQuery"
                                @keydown.enter="handleSearch"
                                type="search" 
                                placeholder="Buscar RTX 4090, Ryzen 7..." 
                                class="w-full px-4 py-2.5 pl-11 bg-dark-card border border-white/10 rounded-full text-white placeholder-gray-500 focus:outline-none focus:ring-0 text-sm transition-all"
                            />
                            <button @click="handleSearch" class="absolute left-4 text-gray-500 hover:text-brand-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-6">
                    <!-- Carrito -->
                    <Link :href="route('cart.index')" class="relative group">
                        <div class="p-2 rounded-full hover:bg-white/5 transition-colors">
                            <svg class="w-6 h-6 text-gray-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span v-if="cartCount > 0" class="absolute top-0 right-0 bg-brand-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center border border-[#0B0E14] animate-bounce">
                                {{ cartCount }}
                            </span>
                             <span v-else class="absolute top-0 right-0 bg-gray-700 text-gray-400 text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center border border-[#0B0E14]">
                                0
                            </span>
                        </div>
                    </Link>

                    <!-- Auth Dropdown (Fixed) -->
                    <div v-if="auth?.user" class="flex items-center gap-4 relative group py-4">
                        <div class="hidden text-right sm:block cursor-pointer">
                            <div class="text-sm font-medium text-white">{{ auth.user.name }}</div>
                            <div class="text-xs text-gray-500">{{ auth.user.role || 'Cliente' }}</div>
                        </div>
                        
                        <button class="flex items-center focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-500 to-purple-600 p-[2px]">
                                <div class="w-full h-full rounded-full bg-dark-bg flex items-center justify-center text-white font-bold">
                                    {{ auth.user.name.charAt(0) }}
                                </div>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 top-[80%] pt-2 w-56 hidden group-hover:block hover:block z-50">
                            <div class="bg-[#151A23] rounded-xl shadow-2xl border border-white/10 py-2 overflow-hidden">
                                <div class="px-4 py-3 border-b border-white/10 mb-2 sm:hidden">
                                    <p class="text-white font-bold truncate">{{ auth.user.name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth.user.email }}</p>
                                </div>

                                <Link v-if="auth.user.role === 'Admin'" :href="route('admin.dashboard')" class="block px-4 py-2.5 text-sm text-brand-400 hover:bg-white/5 font-bold flex items-center gap-2">
                                    ⚡ Panel Admin
                                </Link>
                                
                                <Link :href="route('profile.orders')" class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-white flex items-center gap-2">
                                    📦 Mis Pedidos
                                </Link>
                                
                                <Link :href="route('profile.edit')" class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-white flex items-center gap-2">
                                    👤 Mi Perfil
                                </Link>

                                <div class="border-t border-white/10 my-2"></div>
                                
                                <Link :href="route('logout')" method="post" as="button" class="block w-full text-left px-4 py-2.5 text-sm text-red-400 hover:bg-red-500/10 transition-colors flex items-center gap-2">
                                    🚪 Cerrar Sesión
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div v-else class="flex items-center gap-3">
                        <Link :href="route('login')" class="text-sm font-medium text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-white/5 transition-colors">
                            Entrar
                        </Link>
                        <Link :href="route('register')" class="text-sm font-bold text-white bg-brand-600 hover:bg-brand-500 px-5 py-2.5 rounded-lg transition-all shadow-lg shadow-brand-500/20 hover:shadow-brand-500/40">
                            Registro
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
