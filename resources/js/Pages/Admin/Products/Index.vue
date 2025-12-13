<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    products: Object, // Paginado
    filters: Object,
});

const toggleStatus = (product) => {
    router.post(route('admin.products.toggle-status', product.id), {}, {
        preserveScroll: true,
    });
};

const toggleFeatured = (product) => {
    router.post(route('admin.products.toggle-featured', product.id), {}, {
        preserveScroll: true,
    });
};

const deleteProduct = (product) => {
    if (confirm('¿Estás seguro de eliminar este producto?')) {
        router.delete(route('admin.products.destroy', product.id));
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Productos" />

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Productos</h2>
            <Link :href="route('admin.products.create')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition-colors">
                + Nuevo Producto
            </Link>
        </div>

        <!-- TODO: Agregar filtros de búsqueda aquí -->

        <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-900">
                        <tr>
                            <th class="px-6 py-3">Producto</th>
                            <th class="px-6 py-3">Categoría / Marca</th>
                            <th class="px-6 py-3">Precio</th>
                            <th class="px-6 py-3 text-center">Stock</th>
                            <th class="px-6 py-3 text-center">Estado</th>
                            <th class="px-6 py-3 text-center">Destacado</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products.data" :key="product.id" class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ product.name }}</div>
                                <div class="text-xs text-gray-500">SKU: {{ product.sku }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-white">{{ category_name = product.category?.name || '-' }}</div>
                                <div class="text-xs text-gray-500">{{ product.brand?.name || '-' }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-green-400">
                                S/ {{ product.price }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 rounded text-xs font-bold"
                                    :class="product.stock > 10 ? 'bg-green-900 text-green-300' : (product.stock > 0 ? 'bg-yellow-900 text-yellow-300' : 'bg-red-900 text-red-300')">
                                    {{ product.stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button 
                                    @click="toggleStatus(product)"
                                    class="px-2 py-1 rounded text-xs font-bold transition-colors"
                                    :class="product.is_active ? 'bg-blue-900 text-blue-300 hover:bg-blue-800' : 'bg-gray-700 text-gray-400 hover:bg-gray-600'"
                                >
                                    {{ product.is_active ? 'Activo' : 'Inactivo' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button 
                                    @click="toggleFeatured(product)"
                                    class="text-xl hover:scale-110 transition-transform"
                                    :title="product.is_featured ? 'Quitar destacado' : 'Destacar'"
                                >
                                    {{ product.is_featured ? '⭐' : '☆' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <Link :href="route('admin.products.edit', product.id)" class="text-blue-400 hover:text-blue-300">Editar</Link>
                                <button @click="deleteProduct(product)" class="text-red-400 hover:text-red-300">Eliminar</button>
                            </td>
                        </tr>
                        <tr v-if="products.data.length === 0">
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">No hay productos registrados</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación básica -->
            <div v-if="products.links.length > 3" class="px-6 py-4 border-t border-gray-700 flex justify-center">
                <div class="flex space-x-1">
                    <Link 
                        v-for="(link, index) in products.links" 
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

