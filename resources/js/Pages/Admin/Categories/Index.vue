<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    categories: Array,
});

const toggleStatus = (category) => {
    router.post(route('admin.categories.toggle-status', category.id), {}, {
        preserveScroll: true,
    });
};

const deleteCategory = (category) => {
    if (confirm('¿Estás seguro de eliminar esta categoría?')) {
        router.delete(route('admin.categories.destroy', category.id));
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Categorías" />

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Categorías</h2>
            <Link :href="route('admin.categories.create')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition-colors">
                + Nueva Categoría
            </Link>
        </div>

        <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-900">
                        <tr>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Padre</th>
                            <th class="px-6 py-3 text-center">Productos</th>
                            <th class="px-6 py-3 text-center">Estado</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories" :key="category.id" class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="px-6 py-4 font-medium text-white">{{ category.name }}</td>
                            <td class="px-6 py-4">
                                <span v-if="category.parent" class="px-2 py-1 bg-gray-700 rounded text-xs">
                                    {{ category.parent.name }}
                                </span>
                                <span v-else class="text-gray-600">-</span>
                            </td>
                            <td class="px-6 py-4 text-center">{{ category.products_count }}</td>
                            <td class="px-6 py-4 text-center">
                                <button 
                                    @click="toggleStatus(category)"
                                    class="px-2 py-1 rounded text-xs font-bold transition-colors"
                                    :class="category.is_active ? 'bg-green-900 text-green-300 hover:bg-green-800' : 'bg-red-900 text-red-300 hover:bg-red-800'"
                                >
                                    {{ category.is_active ? 'Activo' : 'Inactivo' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <Link :href="route('admin.categories.edit', category.id)" class="text-blue-400 hover:text-blue-300">Editar</Link>
                                <button @click="deleteCategory(category)" class="text-red-400 hover:text-red-300">Eliminar</button>
                            </td>
                        </tr>
                        <tr v-if="categories.length === 0">
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No hay categorías registradas</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

