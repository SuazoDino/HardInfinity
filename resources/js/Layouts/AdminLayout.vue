<script setup>
import { ref, computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/UI/NavLink.vue';

const showingNavigationDropdown = ref(false);
const showingUserDropdown = ref(false);

const page = usePage();
const user = computed(() => page.props.auth.user);
const pendingOrdersCount = computed(() => page.props.pending_orders_count || 0);

const logout = () => {
    router.post(route('logout'));
};

const menuItems = [
    {
        section: 'Principal',
        items: [
            { name: 'Dashboard', icon: '📊', route: 'admin.dashboard', current: 'admin.dashboard' }
        ]
    },
    {
        section: 'Catálogo',
        items: [
            { name: 'Productos', icon: '📦', route: 'admin.products.index', current: 'admin.products.*' },
            { name: 'Categorías', icon: '📂', route: 'admin.categories.index', current: 'admin.categories.*' },
            { name: 'Marcas', icon: '🏷️', route: 'admin.brands.index', current: 'admin.brands.*' }
        ]
    },
    {
        section: 'Ventas',
        items: [
            { name: 'Órdenes', icon: '🛒', route: 'admin.orders.index', current: 'admin.orders.*' },
            { name: 'Cupones', icon: '🎟️', route: 'admin.coupons.index', current: 'admin.coupons.*' }
        ]
    },
    {
        section: 'Sistema',
        items: [
            { name: 'Usuarios', icon: '👥', route: 'admin.users.index', current: 'admin.users.*' }
        ]
    }
];
</script>

<template>
    <div class="min-h-screen bg-dark-bg">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-dark-card border-r border-white/5 transition-transform duration-300 transform md:translate-x-0 shadow-2xl flex flex-col" :class="showingNavigationDropdown ? 'translate-x-0' : '-translate-x-full'">
            <!-- Logo Premium -->
            <div class="flex items-center justify-center h-20 border-b border-white/5 bg-dark-card shrink-0">
                <Link :href="route('admin.dashboard')" class="flex items-center space-x-2 group">
                    <!-- Icono con Gradiente Original -->
                    <div class="relative">
                        <div class="absolute -inset-1 bg-brand-500 rounded-lg blur opacity-20 group-hover:opacity-40 transition duration-200"></div>
                        <div class="relative bg-dark-card p-1.5 rounded-lg border border-white/5">
                            <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    <!-- Texto Logo -->
                    <span class="text-2xl font-display font-bold tracking-tight text-white">
                        Hard<span class="text-brand-400">Infinity</span>
                    </span>
                </Link>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 px-3 overflow-y-auto flex-1 scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-transparent">
                <!-- ... items del menú ... -->
                <div v-for="(menu, index) in menuItems" :key="index" class="mb-6">
                    <div class="px-3 mb-2 text-xs font-bold text-gray-600 uppercase tracking-wider flex items-center gap-2">
                        <div class="w-1 h-3 bg-brand-500/50 rounded-full"></div>
                        {{ menu.section }}
                    </div>
                    <NavLink 
                        v-for="item in menu.items" 
                        :key="item.route" 
                        :href="route(item.route)" 
                        :active="route().current(item.current)"
                        class="flex items-center gap-3 px-4 py-3 mb-1 text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all duration-200 group border border-transparent"
                        active-class="!bg-brand-500/10 !text-brand-400 border-l-2 !border-l-brand-500 !rounded-l-none"
                    >
                        <span class="text-xl group-hover:scale-110 transition-transform opacity-80 group-hover:opacity-100">{{ item.icon }}</span>
                        <span class="font-medium">{{ item.name }}</span>
                    </NavLink>
                </div>
            </nav>

            <!-- Footer Sidebar -->
            <div class="p-4 bg-dark-card border-t border-white/5 shrink-0">
                <Link :href="route('home')" class="flex items-center justify-center gap-2 px-4 py-2 bg-dark-bg/50 border border-white/5 text-gray-400 hover:text-white hover:border-white/20 rounded-lg transition-all text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Ver Tienda Pública
                </Link>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="md:ml-72 flex flex-col min-h-screen bg-dark-bg">
            <!-- Topbar -->
            <header class="bg-dark-card border-b border-white/5 h-20 flex items-center justify-between px-8 shadow-sm sticky top-0 z-40">
                <!-- ... topbar content ... -->
                <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="md:hidden text-gray-400 hover:text-brand-400 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="hidden md:block">
                    <h2 class="text-xl font-display font-bold text-white">Panel de Administración</h2>
                </div>

                <div class="flex items-center ml-auto gap-6">
                    <!-- Notificaciones -->
                    <Link :href="route('admin.orders.index')" class="relative p-2 text-gray-400 hover:text-brand-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span v-if="pendingOrdersCount > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ pendingOrdersCount > 9 ? '9+' : pendingOrdersCount }}
                        </span>
                    </Link>

                    <!-- User Dropdown -->
                    <div class="relative">
                        <button @click="showingUserDropdown = !showingUserDropdown" class="flex items-center gap-3 pl-3 pr-1 py-1 hover:bg-white/5 rounded-full transition-colors border border-transparent hover:border-white/10">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-medium text-white leading-tight">{{ user.name }}</p>
                                <p class="text-[10px] font-bold text-brand-400 uppercase tracking-wider">Administrador</p>
                            </div>
                            <img :src="`https://ui-avatars.com/api/?name=${user.name}&background=0ea5e9&color=fff&size=40&bold=true`" alt="Avatar" class="w-10 h-10 rounded-full ring-2 ring-brand-500/50">
                        </button>
                        <!-- ... dropdown ... -->
                         <Transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="transform opacity-0 scale-95 translate-y-2"
                            enter-to-class="transform opacity-100 scale-100 translate-y-0"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100 translate-y-0"
                            leave-to-class="transform opacity-0 scale-95 translate-y-2"
                        >
                            <div v-show="showingUserDropdown" class="absolute right-0 mt-2 w-60 rounded-xl shadow-2xl bg-dark-card border border-white/10 py-2 z-50">
                                <!-- ... items ... -->
                                <div class="px-4 py-3 border-b border-white/10 sm:hidden">
                                    <p class="text-sm font-semibold text-white">{{ user.name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ user.email }}</p>
                                </div>

                                <Link :href="route('admin.profile')" class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition-colors flex items-center gap-2" @click="showingUserDropdown = false">
                                    <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Mi Perfil
                                </Link>
                                
                                <Link :href="route('admin.users.index')" class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition-colors flex items-center gap-2" @click="showingUserDropdown = false">
                                    <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    Usuarios
                                </Link>

                                <div class="border-t border-white/10 my-2"></div>
                                
                                <button @click="logout" class="block w-full text-left px-4 py-2.5 text-sm text-red-400 hover:bg-red-500/10 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                    Cerrar Sesión
                                </button>
                            </div>
                        </Transition>
                    </div>
                </div>
            </header>

            <!-- Page Content (Separado Visualmente) -->
            <main class="flex-1 overflow-y-auto p-8">
                <!-- Contenedor con separación visual -->
                <div class="bg-transparent rounded-2xl min-h-full">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Scrollbar personalizado */
.scrollbar-thin::-webkit-scrollbar {
    width: 6px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: rgba(14, 165, 233, 0.2);
    border-radius: 3px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(14, 165, 233, 0.4);
}
</style>

