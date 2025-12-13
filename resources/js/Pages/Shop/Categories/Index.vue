<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    categories: Array,
});

// Función simple para asignar emojis/iconos basados en el nombre (temporal hasta tener iconos reales en BD)
const getIcon = (name) => {
    const n = name.toLowerCase();
    if (n.includes('procesador')) return '🧠';
    if (n.includes('video') || n.includes('grafica')) return '🎮';
    if (n.includes('ram')) return '💾';
    if (n.includes('disco') || n.includes('almacenamiento')) return '💿';
    if (n.includes('monitor')) return '🖥️';
    if (n.includes('teclado') || n.includes('mouse')) return '⌨️';
    if (n.includes('audio') || n.includes('auricular')) return '🎧';
    if (n.includes('silla')) return '💺';
    if (n.includes('case') || n.includes('gabinete')) return '🧊';
    if (n.includes('fuente')) return '⚡';
    return '📦';
};
</script>

<template>
    <AppLayout>
        <Head title="Todas las Categorías" />

        <div class="relative pt-20 pb-12 bg-dark-bg overflow-hidden">
            <div class="absolute inset-0 bg-brand-900/10"></div>
            <div class="container mx-auto px-4 relative z-10 text-center">
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-4">Explora por Departamentos</h1>
                <p class="text-gray-400 max-w-2xl mx-auto">Encuentra exactamente lo que necesitas navegando por nuestras categorías especializadas.</p>
            </div>
        </div>

        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <Link 
                    v-for="category in categories" 
                    :key="category.id" 
                    :href="route('shop.products.index', { category: category.slug })"
                    class="group relative overflow-hidden rounded-2xl bg-dark-card border border-white/5 hover:border-brand-500 hover:shadow-2xl hover:shadow-brand-500/10 transition-all duration-300 aspect-square flex flex-col items-center justify-center p-8 text-center"
                >
                    <!-- Background Gradient Hover -->
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-500/0 to-brand-500/5 group-hover:to-brand-500/10 transition-all"></div>
                    
                    <!-- Icon -->
                    <div class="w-24 h-24 rounded-full bg-white/5 flex items-center justify-center text-5xl mb-6 group-hover:scale-110 group-hover:bg-brand-500/20 group-hover:text-white transition-all duration-300">
                        {{ getIcon(category.name) }}
                    </div>
                    
                    <!-- Content -->
                    <h3 class="text-xl font-bold text-white mb-2 group-hover:text-brand-400 transition-colors">{{ category.name }}</h3>
                    <p class="text-sm text-gray-500 group-hover:text-gray-300 transition-colors">
                        {{ category.products_count }} productos disponibles
                    </p>

                    <!-- Arrow -->
                    <div class="mt-6 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 text-brand-400 font-bold flex items-center gap-2">
                        Ver Productos <span class="text-lg">→</span>
                    </div>
                </Link>
            </div>

            <!-- Empty State -->
            <div v-if="categories.length === 0" class="text-center py-20">
                <div class="text-6xl mb-4">📂</div>
                <h3 class="text-xl font-bold text-white">No hay categorías disponibles</h3>
                <p class="text-gray-500 mt-2">El administrador aún no ha creado categorías.</p>
            </div>
        </div>
    </AppLayout>
</template>

