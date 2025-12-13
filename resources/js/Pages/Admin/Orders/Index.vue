<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    orders: Object,
    filters: Object,
});
</script>

<template>
    <AdminLayout>
        <Head title="Órdenes" />

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Órdenes</h2>
        </div>

        <!-- Filtros simples (TODO: Implementar funcionalidad) -->
        <div class="flex space-x-4 mb-6">
            <Link :href="route('admin.orders.index')" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 border border-gray-700 transition-colors" :class="{'bg-blue-600 border-blue-500': !filters.status}">
                Todas
            </Link>
            <Link :href="route('admin.orders.index', { status: 'pending' })" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 border border-gray-700 transition-colors" :class="{'bg-blue-600 border-blue-500': filters.status === 'pending'}">
                Pendientes
            </Link>
            <Link :href="route('admin.orders.index', { status: 'paid' })" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 border border-gray-700 transition-colors" :class="{'bg-blue-600 border-blue-500': filters.status === 'paid'}">
                Pagadas
            </Link>
        </div>

        <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-900">
                        <tr>
                            <th class="px-6 py-3">Orden #</th>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Fecha</th>
                            <th class="px-6 py-3 text-center">Items</th>
                            <th class="px-6 py-3 text-right">Total</th>
                            <th class="px-6 py-3 text-center">Estado</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders.data" :key="order.id" class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="px-6 py-4 font-mono text-white">{{ order.order_number }}</td>
                            <td class="px-6 py-4">
                                <div class="text-white">{{ order.user.name }}</div>
                                <div class="text-xs text-gray-500">{{ order.user.email }}</div>
                            </td>
                            <td class="px-6 py-4">{{ new Date(order.created_at).toLocaleDateString() }}</td>
                            <td class="px-6 py-4 text-center">{{ order.items.length }}</td>
                            <td class="px-6 py-4 text-right font-bold text-green-400">
                                S/ {{ order.total_amount }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 rounded text-xs font-bold uppercase"
                                    :class="{
                                        'bg-yellow-900 text-yellow-300': order.status === 'pending',
                                        'bg-blue-900 text-blue-300': order.status === 'paid',
                                        'bg-green-900 text-green-300': order.status === 'shipped',
                                        'bg-purple-900 text-purple-300': order.status === 'delivered',
                                        'bg-red-900 text-red-300': order.status === 'cancelled',
                                    }">
                                    {{ order.status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <Link :href="route('admin.orders.show', order.id)" class="text-blue-400 hover:text-blue-300">Ver Detalle</Link>
                            </td>
                        </tr>
                        <tr v-if="orders.data.length === 0">
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">No hay órdenes registradas</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div v-if="orders.links.length > 3" class="px-6 py-4 border-t border-gray-700 flex justify-center">
                <div class="flex space-x-1">
                    <Link 
                        v-for="(link, index) in orders.links" 
                        :key="index"
                        :href="link.url || '#'"
                        class="px-3 py-1 rounded text-sm"
                        :class="[
                            link.active ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600',
                            !link.url ? 'opacity-50 cursor-not-allowed' : ''
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

