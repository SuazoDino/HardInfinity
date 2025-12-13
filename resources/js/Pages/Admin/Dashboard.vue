<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import StatCard from '@/Components/UI/StatCard.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: Object,
    recent_orders: Array,
    low_stock_products: Array,
    top_products: Array,
});

const getStatusColor = (status) => {
    switch (status) {
        case 'pending': return 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20';
        case 'paid': return 'bg-blue-500/10 text-blue-400 border border-blue-500/20';
        case 'shipped': return 'bg-purple-500/10 text-purple-400 border border-purple-500/20';
        case 'delivered': return 'bg-green-500/10 text-green-400 border border-green-500/20';
        case 'cancelled': return 'bg-red-500/10 text-red-400 border border-red-500/20';
        default: return 'bg-gray-500/10 text-gray-400';
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Dashboard" />

        <div class="py-6 space-y-8">
            <div class="flex justify-between items-end">
                <div>
                    <h2 class="text-3xl font-display font-bold text-white">Centro de Comando</h2>
                    <p class="text-gray-400 text-sm">Resumen de actividad de la tienda.</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-[#151A23] border border-white/10 rounded-lg text-sm text-gray-300 hover:text-white hover:border-brand-500 transition-all">
                        📅 Últimos 30 días
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-[#151A23] border border-white/5 rounded-2xl p-6 relative overflow-hidden group hover:border-brand-500/30 transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity text-6xl">💰</div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Ingresos Totales</p>
                    <p class="text-3xl font-display font-bold text-white mt-2">S/ {{ stats.total_revenue }}</p>
                    <div class="mt-4 flex items-center text-xs text-green-400">
                        <span>📈 +12% vs mes anterior</span>
                    </div>
                </div>

                <div class="bg-[#151A23] border border-white/5 rounded-2xl p-6 relative overflow-hidden group hover:border-brand-500/30 transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity text-6xl">🛒</div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Órdenes Totales</p>
                    <p class="text-3xl font-display font-bold text-white mt-2">{{ stats.total_orders }}</p>
                    <div class="mt-4 flex items-center text-xs text-blue-400">
                        <span>📦 {{ stats.pending_orders }} pendientes de envío</span>
                    </div>
                </div>

                <div class="bg-[#151A23] border border-white/5 rounded-2xl p-6 relative overflow-hidden group hover:border-brand-500/30 transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity text-6xl">👥</div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Clientes</p>
                    <p class="text-3xl font-display font-bold text-white mt-2">{{ stats.total_customers }}</p>
                    <div class="mt-4 flex items-center text-xs text-purple-400">
                        <span>🚀 Crecimiento constante</span>
                    </div>
                </div>

                <div class="bg-[#151A23] border border-white/5 rounded-2xl p-6 relative overflow-hidden group hover:border-brand-500/30 transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity text-6xl">⚠️</div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Alertas Stock</p>
                    <p class="text-3xl font-display font-bold text-white mt-2">{{ stats.low_stock }}</p>
                    <div class="mt-4 flex items-center text-xs text-red-400">
                        <span>🔥 {{ stats.out_of_stock }} productos agotados</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Orders -->
                <div class="lg:col-span-2 bg-[#151A23] border border-white/5 rounded-2xl overflow-hidden">
                    <div class="p-6 border-b border-white/5 flex justify-between items-center">
                        <h3 class="font-bold text-white text-lg">Últimas Órdenes</h3>
                        <Link :href="route('admin.orders.index')" class="text-xs text-brand-400 hover:text-brand-300 font-bold uppercase tracking-wide">Ver todas</Link>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-[#0B0E14]/50">
                                <tr>
                                    <th class="px-6 py-4 font-medium">Orden</th>
                                    <th class="px-6 py-4 font-medium">Cliente</th>
                                    <th class="px-6 py-4 font-medium">Estado</th>
                                    <th class="px-6 py-4 font-medium text-right">Total</th>
                                    <th class="px-6 py-4 font-medium"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <tr v-for="order in recent_orders" :key="order.id" class="hover:bg-white/[0.02] transition-colors">
                                    <td class="px-6 py-4 font-mono text-brand-400 font-bold">{{ order.order_number }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-xs font-bold text-gray-400">
                                                {{ order.user.name.charAt(0) }}
                                            </div>
                                            <span class="text-gray-300 font-medium">{{ order.user.name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span :class="['px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wide', getStatusColor(order.status)]">
                                            {{ order.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-white font-bold text-right">S/ {{ order.total_amount }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <Link :href="route('admin.orders.show', order.id)" class="text-gray-500 hover:text-white">
                                            →
                                        </Link>
                                    </td>
                                </tr>
                                <tr v-if="recent_orders.length === 0">
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <div class="text-4xl mb-2 opacity-30">📭</div>
                                        No hay órdenes recientes
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Top Products / Low Stock -->
                <div class="space-y-8">
                    <!-- Top Products -->
                    <div class="bg-[#151A23] border border-white/5 rounded-2xl overflow-hidden">
                        <div class="p-6 border-b border-white/5">
                            <h3 class="font-bold text-white text-lg">🔥 Más Vendidos</h3>
                        </div>
                        <div class="divide-y divide-white/5">
                            <div v-for="(product, index) in top_products" :key="product.id" class="p-4 flex items-center gap-4 hover:bg-white/[0.02]">
                                <span class="text-xl font-bold text-gray-600 w-6 text-center">#{{ index + 1 }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white text-sm font-medium truncate">{{ product.name }}</p>
                                    <p class="text-xs text-gray-500">{{ product.order_items_count }} ventas</p>
                                </div>
                            </div>
                            <div v-if="top_products.length === 0" class="p-8 text-center text-gray-500 text-sm">
                                Aún no hay datos de ventas.
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Alert -->
                    <div class="bg-[#151A23] border border-white/5 rounded-2xl overflow-hidden">
                        <div class="p-6 border-b border-white/5 flex justify-between items-center">
                            <h3 class="font-bold text-white text-lg flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                Stock Crítico
                            </h3>
                        </div>
                        <div class="divide-y divide-white/5">
                            <div v-for="product in low_stock_products" :key="product.id" class="p-4 flex justify-between items-center hover:bg-white/[0.02]">
                                <div class="flex-1 min-w-0 pr-4">
                                    <p class="text-gray-300 text-sm truncate">{{ product.name }}</p>
                                </div>
                                <span class="px-2 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded text-xs font-bold">
                                    {{ product.stock }} un.
                                </span>
                            </div>
                            <div v-if="low_stock_products.length === 0" class="p-8 text-center text-green-500/50 text-sm">
                                ¡Inventario saludable! ✅
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
