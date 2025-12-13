<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    brands: Array,
});

const deleteBrand = (brand) => {
    if (confirm('¿Estás seguro de eliminar esta marca?')) {
        router.delete(route('admin.brands.destroy', brand.id));
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Marcas" />

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Marcas</h2>
            <Link :href="route('admin.brands.create')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition-colors">
                + Nueva Marca
            </Link>
        </div>

        <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-900">
                        <tr>
                            <th class="px-6 py-3">Logo</th>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Descripción</th>
                            <th class="px-6 py-3 text-center">Productos</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="brand in brands" :key="brand.id" class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="px-6 py-4">
                                <div v-if="brand.logo_url" class="w-10 h-10 rounded bg-white flex items-center justify-center overflow-hidden">
                                    <img :src="brand.logo_url" :alt="brand.name" class="max-w-full max-h-full" />
                                </div>
                                <div v-else class="w-10 h-10 rounded bg-gray-700 flex items-center justify-center text-gray-500">
                                    📷
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-white">{{ brand.name }}</td>
                            <td class="px-6 py-4 truncate max-w-xs">{{ brand.description || '-' }}</td>
                            <td class="px-6 py-4 text-center">{{ brand.products_count }}</td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <Link :href="route('admin.brands.edit', brand.id)" class="text-blue-400 hover:text-blue-300">Editar</Link>
                                <button @click="deleteBrand(brand)" class="text-red-400 hover:text-red-300">Eliminar</button>
                            </td>
                        </tr>
                        <tr v-if="brands.length === 0">
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No hay marcas registradas</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

