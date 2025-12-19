<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    order: Object,
});

const form = useForm({
    status: props.order.status,
});

const updateStatus = (newStatus) => {
    if (confirm(`¿Estás seguro de cambiar el estado a "${newStatus}"?`)) {
        form.status = newStatus;
        form.put(route('admin.orders.update-status', props.order.id), {
            preserveScroll: true,
        });
    }
};

const getStatusColor = (status) => {
    switch (status) {
        case 'pending': return 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20';
        case 'paid': return 'bg-blue-500/10 text-blue-400 border-blue-500/20';
        case 'shipped': return 'bg-purple-500/10 text-purple-400 border-purple-500/20';
        case 'delivered': return 'bg-green-500/10 text-green-400 border-green-500/20';
        case 'cancelled': return 'bg-red-500/10 text-red-400 border-red-500/20';
        default: return 'bg-gray-500/10 text-gray-400 border-gray-500/20';
    }
};

const getStatusLabel = (status) => {
    const labels = {
        pending: 'Pendiente',
        paid: 'Pagado',
        shipped: 'Enviado',
        delivered: 'Entregado',
        cancelled: 'Cancelado',
    };
    return labels[status] || status;
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('es-PE', {
        year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
    });
};
</script>

<template>
    <AdminLayout>
        <Head :title="`Orden #${order.order_number}`" />

        <div class="py-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-3xl font-display font-bold text-white">Orden #{{ order.order_number }}</h1>
                        <span :class="['px-3 py-1 rounded-full text-xs font-bold border', getStatusColor(order.status)]">
                            {{ getStatusLabel(order.status) }}
                        </span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Realizado el {{ formatDate(order.created_at) }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <a :href="route('admin.orders.download-pdf', order.id)" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        PDF
                    </a>
                    
                    <button 
                        v-if="order.status === 'pending'"
                        @click="updateStatus('paid')"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-lg transition-colors flex items-center gap-2"
                    >
                        <span>💰</span> Marcar Pagado
                    </button>
                    
                    <button 
                        v-if="order.status === 'paid'"
                        @click="updateStatus('shipped')"
                        class="px-4 py-2 bg-purple-600 hover:bg-purple-500 text-white text-sm font-bold rounded-lg transition-colors flex items-center gap-2"
                    >
                        <span>🚚</span> Marcar Enviado
                    </button>

                    <button 
                        v-if="order.status === 'shipped'"
                        @click="updateStatus('delivered')"
                        class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white text-sm font-bold rounded-lg transition-colors flex items-center gap-2"
                    >
                        <span>✅</span> Marcar Entregado
                    </button>

                    <button 
                        v-if="!['cancelled', 'delivered'].includes(order.status)"
                        @click="updateStatus('cancelled')"
                        class="px-4 py-2 bg-dark-card border border-red-500/30 text-red-400 hover:bg-red-500/10 text-sm font-bold rounded-lg transition-colors"
                    >
                        Cancelar Orden
                    </button>

                    <Link 
                        v-if="['pending', 'paid', 'cancelled'].includes(order.status)"
                        :href="route('admin.orders.estornar', order.id)"
                        method="post"
                        as="button"
                        class="px-4 py-2 bg-yellow-600/20 border border-yellow-500/30 text-yellow-400 hover:bg-yellow-600/30 text-sm font-bold rounded-lg transition-colors flex items-center gap-2"
                    >
                        <span>↩️</span> Estornar Stock
                    </Link>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Order Details -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Items -->
                    <div class="bg-[#151A23] border border-white/5 rounded-xl overflow-hidden">
                        <div class="p-6 border-b border-white/5">
                            <h3 class="font-bold text-white">Items del Pedido</h3>
                        </div>
                        <div class="divide-y divide-white/5">
                            <div v-for="item in order.items" :key="item.id" class="p-6 flex gap-4 items-center">
                                <div class="w-16 h-16 bg-white/5 rounded-lg flex items-center justify-center text-2xl">
                                    📦
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-white font-bold mb-1">{{ item.product?.name || 'Producto no disponible' }}</h4>
                                    <p class="text-sm text-gray-500">
                                        {{ item.product?.brand?.name }} | SKU: {{ item.product?.sku }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-white font-bold">S/ {{ item.total_price }}</p>
                                    <p class="text-xs text-gray-500">{{ item.quantity }} x S/ {{ item.unit_price }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-black/20 border-t border-white/5">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-400">Subtotal</span>
                                <span class="text-white font-medium">S/ {{ order.subtotal }}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-4">
                                <span class="text-gray-400">Envío</span>
                                <span class="text-white font-medium">S/ {{ order.shipping_cost }}</span>
                            </div>
                            <div class="flex justify-between text-xl pt-4 border-t border-white/10 mb-3">
                                <span class="text-white font-bold">Total</span>
                                <span class="text-brand-400 font-bold">S/ {{ order.total_amount }}</span>
                            </div>
                            <!-- Desglose IGV (informativo) -->
                            <div class="flex justify-between text-xs text-gray-500 italic pt-3 border-t border-white/5">
                                <span>IGV incluido (18%)</span>
                                <span>S/ {{ order.tax }}</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Base Imponible</span>
                                <span>S/ {{ (order.subtotal - order.tax).toFixed(2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="bg-[#151A23] border border-white/5 rounded-xl p-6">
                        <h3 class="font-bold text-white mb-4">Información de Pago</h3>
                        <div class="flex items-center gap-4">
                            <div class="bg-white/5 p-3 rounded-lg">
                                <span class="text-2xl">💳</span>
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ order.notes || 'Método no especificado' }}</p>
                                <p class="text-sm text-gray-500">Transacción #{{ order.transaction_id || 'Pendiente' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Customer Info -->
                <div class="space-y-8">
                    <!-- Customer -->
                    <div class="bg-[#151A23] border border-white/5 rounded-xl p-6">
                        <h3 class="font-bold text-white mb-4">Cliente</h3>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-brand-500 to-purple-600 p-[2px]">
                                <div class="w-full h-full rounded-full bg-[#151A23] flex items-center justify-center text-white font-bold">
                                    {{ order.user?.name.charAt(0) }}
                                </div>
                            </div>
                            <div>
                                <p class="text-white font-bold">{{ order.user?.name }}</p>
                                <p class="text-sm text-gray-500">{{ order.user?.email }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex gap-3 text-sm">
                                <span class="text-gray-500 w-6">📱</span>
                                <span class="text-gray-300">{{ order.user?.phone || 'No registrado' }}</span>
                            </div>
                            <div class="flex gap-3 text-sm">
                                <span class="text-gray-500 w-6">📅</span>
                                <span class="text-gray-300">Cliente desde {{ formatDate(order.user?.created_at) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-[#151A23] border border-white/5 rounded-xl p-6">
                        <h3 class="font-bold text-white mb-4">Dirección de Envío</h3>
                        <div class="flex gap-3">
                            <span class="text-gray-500 mt-1">📍</span>
                            <p class="text-gray-300 text-sm leading-relaxed">
                                {{ order.shipping_address }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
