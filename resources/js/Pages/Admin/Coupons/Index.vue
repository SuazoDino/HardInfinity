<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ coupons: Object });

const getTypeLabel = (type) => type === 'percentage' ? '%' : 'S/';
const isExpired = (date) => date && new Date(date) < new Date();
</script>

<template>
    <AdminLayout>
        <Head title="Cupones" />
        <div class="py-6">
            <div class="flex justify-between mb-8">
                <h1 class="text-3xl font-display font-bold text-white">Cupones</h1>
                <Link :href="route('admin.coupons.create')" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-lg">+ Crear</Link>
            </div>
            <div class="bg-[#151A23] border border-white/5 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-dark-bg border-b border-white/10">
                        <tr>
                            <th class="px-6 py-4 text-left text-gray-300">Código</th>
                            <th class="px-6 py-4 text-left text-gray-300">Descuento</th>
                            <th class="px-6 py-4 text-left text-gray-300">Mín.</th>
                            <th class="px-6 py-4 text-left text-gray-300">Usos</th>
                            <th class="px-6 py-4 text-left text-gray-300">Expira</th>
                            <th class="px-6 py-4 text-left text-gray-300">Estado</th>
                            <th class="px-6 py-4 text-right text-gray-300">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="c in coupons.data" :key="c.id" class="border-b border-white/5 hover:bg-white/5">
                            <td class="px-6 py-4"><span class="font-mono font-bold text-brand-400">{{ c.code }}</span></td>
                            <td class="px-6 py-4 text-white">{{ c.value }}{{ getTypeLabel(c.type) }}</td>
                            <td class="px-6 py-4 text-gray-300">S/ {{ c.min_purchase || 0 }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ c.uses_count }} / {{ c.max_uses || '∞' }}</td>
                            <td class="px-6 py-4 text-gray-300">
                                <span v-if="isExpired(c.expires_at)" class="text-red-400">Expirado</span>
                                <span v-else-if="c.expires_at">{{ new Date(c.expires_at).toLocaleDateString() }}</span>
                                <span v-else>-</span>
                            </td>
                            <td class="px-6 py-4">
                                <span v-if="c.is_active" class="px-2 py-1 bg-green-500/10 text-green-400 text-xs rounded">Activo</span>
                                <span v-else class="px-2 py-1 bg-gray-500/10 text-gray-400 text-xs rounded">Inactivo</span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <Link :href="route('admin.coupons.edit', c.id)" class="text-brand-400 hover:text-white">Editar</Link>
                                <Link :href="route('admin.coupons.destroy', c.id)" method="delete" as="button" class="text-red-400 hover:text-red-300">Eliminar</Link>
                            </td>
                        </tr>
                        <tr v-if="coupons.data.length === 0">
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">No hay cupones</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

