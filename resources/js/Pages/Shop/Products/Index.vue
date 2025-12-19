<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductCard from '@/Components/Shop/ProductCard.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    products: Object,
    categories: Array,
    brands: Array,
    filters: Object,
    pageTitle: {
        type: String,
        default: 'Catálogo de Productos'
    },
    pageDescription: {
        type: String,
        default: null
    }
});

// Estado de los filtros
const form = ref({
    search: props.filters.search || '',
    category: props.filters.category || '',
    brand: props.filters.brand || '',
    sort: props.filters.sort || 'latest',
    min_price: props.filters.min_price || '',
    max_price: props.filters.max_price || '',
});

// Debounce para búsqueda y filtros
let timeout = null;

const applyFilters = () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(route('shop.products.index'), form.value, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, 300);
};

const clearFilters = () => {
    form.value = {
        search: '',
        category: '',
        brand: '',
        sort: 'latest',
        min_price: '',
        max_price: '',
    };
    applyFilters();
};

// Observar cambios para aplicar filtros automáticamente
watch(form.value, () => applyFilters(), { deep: true });
</script>

<template>
    <AppLayout>
        <Head title="Catálogo de Productos" />

        <!-- Header Compacto -->
        <div class="bg-dark-card border-b border-white/5 py-8">
            <div class="container mx-auto px-4">
                <h1 class="text-3xl font-display font-bold text-white mb-2">{{ pageTitle }}</h1>
                <p v-if="pageDescription" class="text-gray-400 text-sm">{{ pageDescription }}</p>
                <p v-else class="text-gray-400 text-sm">Explora nuestra selección de hardware premium</p>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Sidebar Filtros (Desktop) -->
                <aside class="w-full lg:w-64 flex-shrink-0 space-y-8">
                    <!-- Buscador Móvil (visible solo en móvil si se desea, pero ya está en navbar) -->
                    
                    <!-- Filtros Activos -->
                    <div v-if="form.category || form.brand || form.min_price" class="bg-dark-card p-4 rounded-xl border border-white/5">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold text-gray-400 uppercase">Filtros Activos</span>
                            <button @click="clearFilters" class="text-xs text-brand-400 hover:text-white transition-colors">Limpiar</button>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span v-if="form.category" class="px-2 py-1 bg-brand-500/20 text-brand-300 text-xs rounded border border-brand-500/30">
                                Cat: {{ categories.find(c => c.slug === form.category)?.name }}
                            </span>
                             <span v-if="form.brand" class="px-2 py-1 bg-brand-500/20 text-brand-300 text-xs rounded border border-brand-500/30">
                                Marca: {{ brands.find(b => b.slug === form.brand)?.name }}
                            </span>
                        </div>
                    </div>

                    <!-- Categorías -->
                    <div>
                        <h3 class="font-semibold text-gray-300 mb-4 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="w-1 h-4 bg-brand-500 rounded-full"></span>
                            Categorías
                        </h3>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="category"
                                    value=""
                                    v-model="form.category"
                                    class="w-4 h-4 text-brand-600 bg-dark-bg border-gray-600 focus:ring-brand-500 focus:ring-offset-dark-card"
                                />
                                <span class="text-gray-400 group-hover:text-white transition-colors text-sm font-medium">Todas</span>
                            </label>
                            <label v-for="category in categories" :key="category.id" class="flex items-center gap-3 cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="category"
                                    :value="category.slug"
                                    v-model="form.category"
                                    class="w-4 h-4 text-brand-600 bg-dark-bg border-gray-600 focus:ring-brand-500 focus:ring-offset-dark-card"
                                />
                                <span class="text-gray-400 group-hover:text-white transition-colors text-sm">{{ category.name }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Marcas -->
                    <div>
                        <h3 class="font-semibold text-gray-300 mb-4 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="w-1 h-4 bg-purple-500 rounded-full"></span>
                            Marcas
                        </h3>
                        <div class="space-y-2 max-h-60 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700 pr-2">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="brand"
                                    value=""
                                    v-model="form.brand"
                                    class="w-4 h-4 text-brand-600 bg-dark-bg border-gray-600 focus:ring-brand-500 focus:ring-offset-dark-card"
                                />
                                <span class="text-gray-400 group-hover:text-white transition-colors text-sm font-medium">Todas</span>
                            </label>
                            <label v-for="brand in brands" :key="brand.id" class="flex items-center gap-3 cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="brand"
                                    :value="brand.slug"
                                    v-model="form.brand"
                                    class="w-4 h-4 text-brand-600 bg-dark-bg border-gray-600 focus:ring-brand-500 focus:ring-offset-dark-card"
                                />
                                <span class="text-gray-400 group-hover:text-white transition-colors text-sm">{{ brand.name }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Precio -->
                    <div>
                        <h3 class="font-semibold text-gray-300 mb-4 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="w-1 h-4 bg-green-500 rounded-full"></span>
                            Precio
                        </h3>
                        <div class="flex items-center gap-2">
                            <input 
                                type="number" 
                                v-model="form.min_price" 
                                placeholder="Min" 
                                class="w-full bg-dark-bg border border-gray-700 rounded-lg text-white text-sm px-3 py-2 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none"
                            />
                            <span class="text-gray-500">-</span>
                            <input 
                                type="number" 
                                v-model="form.max_price" 
                                placeholder="Max" 
                                class="w-full bg-dark-bg border border-gray-700 rounded-lg text-white text-sm px-3 py-2 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none"
                            />
                        </div>
                    </div>
                </aside>

                <!-- Grid de Productos -->
                <div class="flex-1">
                    <!-- Top Bar: Ordenamiento y Contadores -->
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                        <p class="text-gray-400 text-sm">
                            Mostrando <span class="text-white font-bold">{{ products.data.length }}</span> de <span class="text-white font-bold">{{ products.total }}</span> resultados
                        </p>
                        
                        <div class="flex items-center gap-3">
                            <label class="text-sm text-gray-500">Ordenar por:</label>
                            <select 
                                v-model="form.sort" 
                                class="bg-dark-card border border-gray-700 text-white text-sm rounded-lg focus:ring-brand-500 focus:border-brand-500 block p-2.5"
                            >
                                <option value="latest">Más recientes</option>
                                <option value="price_asc">Precio: Bajo a Alto</option>
                                <option value="price_desc">Precio: Alto a Bajo</option>
                                <option value="name">Nombre (A-Z)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Grid -->
                    <div v-if="products.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <ProductCard v-for="product in products.data" :key="product.id" :product="product" />
                    </div>

                    <!-- Estado Vacío -->
                    <div v-else class="text-center py-20 bg-dark-card border border-white/5 rounded-2xl">
                        <div class="text-5xl mb-4">🔍</div>
                        <h3 class="text-xl font-bold text-white mb-2">No encontramos resultados</h3>
                        <p class="text-gray-400">Intenta ajustar los filtros o buscar con otro término.</p>
                        <button @click="clearFilters" class="mt-4 text-brand-400 hover:text-white font-medium underline decoration-brand-500/50 hover:decoration-brand-500">
                            Limpiar todos los filtros
                        </button>
                    </div>

                    <!-- Paginación -->
                    <div v-if="products.links.length > 3" class="mt-12 flex justify-center">
                        <div class="flex gap-1">
                            <Component 
                                :is="link.url ? Link : 'span'" 
                                v-for="(link, key) in products.links" 
                                :key="key"
                                :href="link.url"
                                v-html="link.label"
                                class="px-4 py-2 text-sm rounded-lg transition-colors flex items-center justify-center"
                                :class="{
                                    'bg-brand-600 text-white font-bold shadow-lg shadow-brand-500/20': link.active,
                                    'bg-dark-card text-gray-400 hover:bg-white/5 hover:text-white cursor-pointer': !link.active && link.url,
                                    'text-gray-600 cursor-not-allowed': !link.url
                                }"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

