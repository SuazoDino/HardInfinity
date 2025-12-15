<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    products: Object,
});

const getStockColor = (stock) => {
    if (stock === 0) return 'text-red-500';
    if (stock <= 5) return 'text-red-400';
    if (stock <= 10) return 'text-yellow-400';
    return 'text-gray-400';
};

const getStockBadge = (stock) => {
    if (stock === 0) return { text: '🚫 Agotado', class: 'bg-red-500/20 text-red-400 border-red-500/30' };
    if (stock <= 5) return { text: '⚠️ Crítico', class: 'bg-red-500/20 text-red-400 border-red-500/30' };
    if (stock <= 10) return { text: '⚠️ Bajo', class: 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30' };
    return { text: '✓ Normal', class: 'bg-green-500/20 text-green-400 border-green-500/30' };
};
</script>

<template>
    <AdminLayout>
        <Head title="Stock Bajo - Alertas" />

        <div class="py-6">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-display font-bold text-white flex items-center gap-3">
                        <span class="text-4xl">⚠️</span>
                        Stock Bajo
                    </h1>
                    <p class="text-gray-400 text-sm mt-1">Productos con inventario crítico (≤ 10 unidades)</p>
                </div>
                <div class="flex gap-3">
                    <Link :href="route('admin.inventory.index')" class="px-4 py-2 bg-dark-card border border-white/10 text-gray-300 hover:text-white font-medium rounded-lg transition-all">
                        ← Ver Movimientos
                    </Link>
                    <Link :href="route('admin.products.index')" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-lg transition-all">
                        Gestionar Productos
                    </Link>
                </div>
            </div>

            <!-- Alerta si hay productos agotados -->
            <div v-if="products.data.some(p => p.stock === 0)" class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6 flex items-center gap-3">
                <span class="text-3xl">🚨</span>
                <div>
                    <p class="text-red-400 font-bold">{{ products.data.filter(p => p.stock === 0).length }} productos AGOTADOS</p>
                    <p class="text-red-400/70 text-sm">Requieren atención inmediata</p>
                </div>
            </div>

            <!-- Tabla de Productos -->
            <div class="bg-dark-card border border-white/5 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-dark-bg border-b border-white/10">
                            <tr>
                                <th class="px-6 py-4 text-left text-gray-300">Producto</th>
                                <th class="px-6 py-4 text-left text-gray-300">Categoría</th>
                                <th class="px-6 py-4 text-left text-gray-300">Marca</th>
                                <th class="px-6 py-4 text-center text-gray-300">Stock Actual</th>
                                <th class="px-6 py-4 text-center text-gray-300">Estado</th>
                                <th class="px-6 py-4 text-center text-gray-300">Precio</th>
                                <th class="px-6 py-4 text-right text-gray-300">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in products.data" :key="product.id" class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                <!-- Producto -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-white/5 rounded-lg flex items-center justify-center">
                                            <span class="text-2xl">📦</span>
                                        </div>
                                        <div>
                                            <p class="text-white font-medium">{{ product.name }}</p>
                                            <p class="text-xs text-gray-500">SKU: {{ product.sku }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Categoría -->
                                <td class="px-6 py-4">
                                    <span class="text-gray-400">{{ product.category?.name || 'Sin categoría' }}</span>
                                </td>

                                <!-- Marca -->
                                <td class="px-6 py-4">
                                    <span class="text-gray-400">{{ product.brand?.name || 'Sin marca' }}</span>
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <span :class="getStockColor(product.stock)" class="text-2xl font-bold font-mono">
                                            {{ product.stock }}
                                        </span>
                                        <span class="text-gray-500 text-xs">unidades</span>
                                    </div>
                                </td>

                                <!-- Estado -->
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        <span :class="getStockBadge(product.stock).class" class="px-3 py-1 text-xs font-bold rounded-full border">
                                            {{ getStockBadge(product.stock).text }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Precio -->
                                <td class="px-6 py-4 text-center">
                                    <span class="text-white font-bold">S/ {{ product.price }}</span>
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link 
                                            :href="route('admin.products.edit', product.id)" 
                                            class="px-3 py-1.5 bg-brand-600/20 border border-brand-500/30 text-brand-400 hover:bg-brand-600/30 text-xs font-bold rounded transition-all"
                                        >
                                            ✏️ Editar
                                        </Link>
                                        <Link 
                                            :href="route('admin.inventory.index', { product_id: product.id })" 
                                            class="px-3 py-1.5 bg-purple-600/20 border border-purple-500/30 text-purple-400 hover:bg-purple-600/30 text-xs font-bold rounded transition-all"
                                        >
                                            📊 Historial
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="products.data.length === 0">
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="text-5xl">✅</span>
                                        <p class="text-xl font-bold text-green-400">¡Excelente!</p>
                                        <p class="text-gray-400">Todos los productos tienen stock suficiente</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            <div v-if="products.links.length > 3" class="mt-6 flex justify-center">
                <div class="flex gap-1">
                    <Component 
                        :is="link.url ? Link : 'span'" 
                        v-for="(link, key) in products.links" 
                        :key="key"
                        :href="link.url"
                        v-html="link.label"
                        class="px-4 py-2 text-sm rounded-lg transition-colors"
                        :class="{
                            'bg-brand-600 text-white font-bold': link.active,
                            'bg-dark-card text-gray-400 hover:bg-white/5 hover:text-white': !link.active && link.url,
                            'text-gray-600 cursor-not-allowed': !link.url
                        }"
                    />
                </div>
            </div>

            <!-- Resumen -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-dark-card border border-white/5 rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-3xl">🚫</span>
                        <p class="text-gray-400 text-sm">Agotados</p>
                    </div>
                    <p class="text-3xl font-bold text-red-400">{{ products.data.filter(p => p.stock === 0).length }}</p>
                </div>

                <div class="bg-dark-card border border-white/5 rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-3xl">⚠️</span>
                        <p class="text-gray-400 text-sm">Críticos (≤5)</p>
                    </div>
                    <p class="text-3xl font-bold text-yellow-400">{{ products.data.filter(p => p.stock > 0 && p.stock <= 5).length }}</p>
                </div>

                <div class="bg-dark-card border border-white/5 rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-3xl">📦</span>
                        <p class="text-gray-400 text-sm">Bajos (6-10)</p>
                    </div>
                    <p class="text-3xl font-bold text-orange-400">{{ products.data.filter(p => p.stock > 5 && p.stock <= 10).length }}</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

