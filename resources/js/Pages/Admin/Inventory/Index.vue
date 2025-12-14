<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    movements: Object,
    products: Array,
    filters: Object,
});

const showAjusteModal = ref(false);

const ajusteForm = useForm({
    product_id: '',
    quantity: '',
    reason: '',
});

const submitAjuste = () => {
    ajusteForm.post(route('admin.inventory.ajustar'), {
        onSuccess: () => {
            showAjusteModal.value = false;
            ajusteForm.reset();
        }
    });
};

const getTypeColor = (type) => {
    const colors = {
        'entrada': 'text-green-400 bg-green-500/10',
        'salida': 'text-red-400 bg-red-500/10',
        'estorno': 'text-yellow-400 bg-yellow-500/10',
        'ajuste': 'text-blue-400 bg-blue-500/10',
    };
    return colors[type] || 'text-gray-400 bg-gray-500/10';
};

const getTypeIcon = (type) => {
    const icons = {
        'entrada': '📥',
        'salida': '📤',
        'estorno': '↩️',
        'ajuste': '🔧',
    };
    return icons[type] || '📦';
};
</script>

<template>
    <AdminLayout>
        <Head title="Gestión de Inventario" />

        <div class="py-6">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-display font-bold text-white">Movimientos de Inventario</h1>
                    <p class="text-gray-400 text-sm mt-1">Historial completo de entradas, salidas y estornos</p>
                </div>
                <div class="flex gap-3">
                    <Link :href="route('admin.inventory.stock-bajo')" class="px-4 py-2 bg-red-600/20 text-red-400 border border-red-500/30 font-bold rounded-lg hover:bg-red-600/30 transition-all">
                        ⚠️ Stock Bajo
                    </Link>
                    <button @click="showAjusteModal = true" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-lg transition-all">
                        + Ajustar Stock
                    </button>
                </div>
            </div>

            <!-- Filtros -->
            <div class="bg-dark-card border border-white/5 rounded-xl p-4 mb-6">
                <div class="flex gap-4">
                    <select v-model="filters.product_id" @change="router.get(route('admin.inventory.index'), filters, { preserveState: true })" class="bg-dark-bg border border-gray-700 text-white text-sm rounded-lg p-2.5">
                        <option value="">Todos los productos</option>
                        <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
                    </select>
                    
                    <select v-model="filters.type" @change="router.get(route('admin.inventory.index'), filters, { preserveState: true })" class="bg-dark-bg border border-gray-700 text-white text-sm rounded-lg p-2.5">
                        <option value="">Todos los tipos</option>
                        <option value="entrada">📥 Entradas</option>
                        <option value="salida">📤 Salidas</option>
                        <option value="estorno">↩️ Estornos</option>
                        <option value="ajuste">🔧 Ajustes</option>
                    </select>

                    <button v-if="filters.product_id || filters.type" @click="router.get(route('admin.inventory.index'))" class="px-4 py-2 text-sm text-gray-400 hover:text-white">
                        Limpiar
                    </button>
                </div>
            </div>

            <!-- Tabla -->
            <div class="bg-dark-card border border-white/5 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-dark-bg border-b border-white/10">
                        <tr>
                            <th class="px-6 py-4 text-left text-gray-300">Fecha</th>
                            <th class="px-6 py-4 text-left text-gray-300">Tipo</th>
                            <th class="px-6 py-4 text-left text-gray-300">Producto</th>
                            <th class="px-6 py-4 text-center text-gray-300">Cantidad</th>
                            <th class="px-6 py-4 text-center text-gray-300">Stock Antes</th>
                            <th class="px-6 py-4 text-center text-gray-300">Stock Después</th>
                            <th class="px-6 py-4 text-left text-gray-300">Razón</th>
                            <th class="px-6 py-4 text-left text-gray-300">Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="mov in movements.data" :key="mov.id" class="border-b border-white/5 hover:bg-white/5">
                            <td class="px-6 py-4 text-gray-400">{{ new Date(mov.created_at).toLocaleDateString() }}</td>
                            <td class="px-6 py-4">
                                <span :class="getTypeColor(mov.type)" class="px-2 py-1 text-xs rounded font-bold">
                                    {{ getTypeIcon(mov.type) }} {{ mov.type.toUpperCase() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-white">{{ mov.product.name }}</td>
                            <td class="px-6 py-4 text-center font-mono" :class="mov.type === 'salida' ? 'text-red-400' : 'text-green-400'">
                                {{ mov.type === 'salida' ? '-' : '+' }}{{ mov.quantity }}
                            </td>
                            <td class="px-6 py-4 text-center text-gray-400">{{ mov.stock_before }}</td>
                            <td class="px-6 py-4 text-center text-white font-bold">{{ mov.stock_after }}</td>
                            <td class="px-6 py-4 text-gray-400 text-xs">{{ mov.reason || '-' }}</td>
                            <td class="px-6 py-4 text-gray-400 text-xs">{{ mov.user?.name || 'Sistema' }}</td>
                        </tr>
                        <tr v-if="movements.data.length === 0">
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">No hay movimientos registrados</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div v-if="movements.links.length > 3" class="mt-6 flex justify-center">
                <div class="flex gap-1">
                    <Component 
                        :is="link.url ? Link : 'span'" 
                        v-for="(link, key) in movements.links" 
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
        </div>

        <!-- Modal Ajustar Stock -->
        <div v-if="showAjusteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="showAjusteModal = false">
            <div class="bg-dark-card border border-white/10 rounded-xl p-6 w-full max-w-md">
                <h3 class="text-xl font-bold text-white mb-4">Ajustar Stock</h3>
                <form @submit.prevent="submitAjuste" class="space-y-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Producto</label>
                        <select v-model="ajusteForm.product_id" required class="w-full bg-dark-bg border border-gray-700 text-white rounded-lg p-3">
                            <option value="">Selecciona un producto</option>
                            <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
                        </select>
                        <p v-if="ajusteForm.errors.product_id" class="text-red-400 text-xs mt-1">{{ ajusteForm.errors.product_id }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Cantidad (+ agregar, - quitar)</label>
                        <input v-model="ajusteForm.quantity" type="number" required placeholder="Ej: +10 o -5" class="w-full bg-dark-bg border border-gray-700 text-white rounded-lg p-3" />
                        <p v-if="ajusteForm.errors.quantity" class="text-red-400 text-xs mt-1">{{ ajusteForm.errors.quantity }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Razón</label>
                        <textarea v-model="ajusteForm.reason" required rows="3" placeholder="Ej: Corrección de inventario físico" class="w-full bg-dark-bg border border-gray-700 text-white rounded-lg p-3"></textarea>
                        <p v-if="ajusteForm.errors.reason" class="text-red-400 text-xs mt-1">{{ ajusteForm.errors.reason }}</p>
                    </div>

                    <div class="flex gap-3 justify-end">
                        <button type="button" @click="showAjusteModal = false" class="px-4 py-2 text-gray-400 hover:text-white">Cancelar</button>
                        <button type="submit" :disabled="ajusteForm.processing" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-lg disabled:opacity-50">
                            {{ ajusteForm.processing ? 'Ajustando...' : 'Ajustar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

