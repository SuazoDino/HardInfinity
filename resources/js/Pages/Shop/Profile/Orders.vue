<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    orders: Object,
});

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
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <ProfileLayout>
        <Head title="Mis Pedidos" />

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white mb-2">Mis Pedidos</h1>
            <p class="text-gray-400 text-sm">Gestiona y rastrea tus compras recientes.</p>
        </div>

        <div v-if="orders.data.length > 0" class="space-y-4">
            <div v-for="order in orders.data" :key="order.id" 
                class="bg-[#151A23] border border-white/5 rounded-xl overflow-hidden hover:border-brand-500/30 transition-all"
            >
                <!-- Header Orden -->
                <div class="p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/5">
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-6 text-sm">
                        <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wider">N° Pedido</span>
                            <span class="text-brand-400 font-mono font-bold">{{ order.order_number }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wider">Fecha</span>
                            <span class="text-white">{{ formatDate(order.created_at) }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wider">Total</span>
                            <span class="text-white font-bold">S/ {{ order.total_amount }}</span>
                        </div>
                    </div>
                    
                    <span :class="['px-3 py-1 rounded-full text-xs font-bold border', getStatusColor(order.status)]">
                        {{ getStatusLabel(order.status) }}
                    </span>
                </div>

                <!-- Items Preview -->
                <div class="p-5 bg-black/20">
                    <div class="space-y-3">
                        <div v-for="item in order.items" :key="item.id" class="flex gap-4 items-center">
                            <div class="w-10 h-10 bg-white/5 rounded flex items-center justify-center flex-shrink-0 text-lg">
                                📦
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-gray-300 text-sm truncate">{{ item.product?.name || 'Producto eliminado' }}</h4>
                                <p class="text-xs text-gray-500">Cant: {{ item.quantity }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-white/5 flex justify-between items-center">
                        <a :href="route('profile.orders.download-pdf', order.id)" 
                            class="text-sm text-primary-blue hover:text-white transition-colors font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Descargar PDF
                        </a>
                        <button class="text-sm text-gray-400 hover:text-white transition-colors font-medium">
                            Ver Detalles →
                        </button>
                    </div>
                </div>
            </div>

            <!-- Paginación -->
            <div v-if="orders.links.length > 3" class="flex justify-center mt-8">
                 <!-- Componente de paginación simple -->
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-16 bg-[#151A23] border border-white/5 rounded-xl">
            <div class="text-5xl mb-4 opacity-50">🛍️</div>
            <h2 class="text-xl font-bold text-white mb-2">Aún no tienes pedidos</h2>
            <p class="text-gray-500 text-sm mb-6">¡Explora nuestro catálogo y encuentra tu próximo upgrade!</p>
            <Link :href="route('shop.products.index')" class="px-6 py-2.5 bg-brand-600 text-white text-sm font-bold rounded-lg hover:bg-brand-500 transition-colors shadow-lg shadow-brand-500/20">
                Ir a la Tienda
            </Link>
        </div>
    </ProfileLayout>
</template>
