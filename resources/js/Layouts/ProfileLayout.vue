<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);

const menuItems = [
    { name: '📦 Mis Pedidos', route: 'profile.orders', active: route().current('profile.orders') },
    { name: '❤️ Wishlist', route: 'wishlist.index', active: route().current('wishlist.index') },
    { name: '👤 Mi Cuenta', route: 'profile.edit', active: route().current('profile.edit') },
    { name: '📍 Direcciones', route: 'profile.addresses', active: route().current('profile.addresses') },
    { name: '🔒 Seguridad', route: 'profile.security', active: route().current('profile.security') },
];
</script>

<template>
    <AppLayout>
        <div class="container mx-auto px-4 py-12">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar -->
                <aside class="w-full lg:w-72 flex-shrink-0">
                    <!-- User Info Card -->
                    <div class="bg-[#151A23] border border-white/5 rounded-xl p-6 mb-6 text-center">
                        <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-tr from-brand-500 to-purple-600 p-[2px] mb-4">
                            <div class="w-full h-full rounded-full bg-[#151A23] flex items-center justify-center text-white font-bold text-3xl">
                                {{ user.name.charAt(0) }}
                            </div>
                        </div>
                        <h2 class="text-white font-bold text-lg">{{ user.name }}</h2>
                        <p class="text-gray-500 text-sm">{{ user.email }}</p>
                    </div>

                    <!-- Menu -->
                    <div class="bg-[#151A23] border border-white/5 rounded-xl overflow-hidden">
                        <nav class="flex flex-col">
                            <Link 
                                v-for="item in menuItems" 
                                :key="item.name"
                                :href="route(item.route)"
                                class="px-6 py-4 text-sm font-medium border-l-4 transition-all flex items-center gap-3 hover:bg-white/5"
                                :class="item.active 
                                    ? 'border-brand-500 text-white bg-brand-500/5' 
                                    : 'border-transparent text-gray-400 hover:text-white'"
                            >
                                {{ item.name }}
                            </Link>
                            
                            <div class="border-t border-white/5 my-2"></div>
                            
                            <Link :href="route('logout')" method="post" as="button" class="w-full text-left px-6 py-4 text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 border-l-4 border-transparent transition-all">
                                🚪 Cerrar Sesión
                            </Link>
                        </nav>
                    </div>
                </aside>

                <!-- Content -->
                <main class="flex-1">
                    <slot />
                </main>
            </div>
        </div>
    </AppLayout>
</template>
