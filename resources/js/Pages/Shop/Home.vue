<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductCard from '@/Components/Shop/ProductCard.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    featured_products: Array,
    recommended_products: Array,
    main_categories: Array,
    brands: Array,
});
</script>

<template>
    <AppLayout>
        <Head title="Inicio" />

        <!-- Hero Section (Estilo Cyberpunk/Tech) -->
        <section class="relative pt-32 pb-20 overflow-hidden">
            <!-- Fondo con efectos de luz -->
            <div class="absolute inset-0 bg-[#0B0E14]">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-brand-500/20 rounded-full blur-3xl filter opacity-50 animate-pulse-slow"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl filter opacity-50 animate-pulse-slow" style="animation-delay: 2s;"></div>
                <!-- Grid Pattern Overlay -->
                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
            </div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center max-w-4xl mx-auto">
                    <div class="inline-block mb-4 px-4 py-1.5 rounded-full border border-brand-500/30 bg-brand-500/10 backdrop-blur-sm">
                        <span class="text-brand-300 text-sm font-medium tracking-wide">✨ La nueva generación de hardware llegó</span>
                    </div>
                    
                    <h1 class="text-6xl md:text-7xl font-display font-bold text-white mb-6 leading-tight">
                        Construye tu <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-purple-500">Legado Gamer</span>
                    </h1>
                    
                    <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto font-light">
                        Componentes de alto rendimiento para llevar tu experiencia al límite.
                        Calidad garantizada y soporte experto.
                    </p>

                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <Link :href="route('shop.products.index')" class="px-8 py-4 bg-brand-600 text-white rounded-xl font-bold text-lg hover:bg-brand-500 transition-all shadow-lg shadow-brand-500/25 hover:scale-105">
                            Ver Catálogo Completo
                        </Link>
                        <Link :href="route('shop.products.index', { sort: 'price_asc' })" class="px-8 py-4 bg-dark-card text-gray-200 border border-white/10 rounded-xl font-medium text-lg hover:bg-white/5 transition-all hover:border-white/20">
                            Explorar Ofertas
                        </Link>
                    </div>
                </div>

                <!-- Stats / Trust Indicators -->
                <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-white/5 pt-10 max-w-5xl mx-auto">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white mb-1">+5,000</div>
                        <div class="text-sm text-gray-500">Clientes Felices</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white mb-1">24h</div>
                        <div class="text-sm text-gray-500">Envíos Rápidos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white mb-1">100%</div>
                        <div class="text-sm text-gray-500">Garantía Real</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white mb-1">Soporte</div>
                        <div class="text-sm text-gray-500">Especializado</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categorías (Bento Grid Style) -->
        <section class="py-20 bg-[#0B0E14]">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-3xl font-display font-bold text-white mb-2">Categorías Populares</h2>
                        <p class="text-gray-400">Encuentra lo que necesitas para tu build</p>
                    </div>
                    <Link :href="route('shop.products.index')" class="text-brand-400 hover:text-brand-300 font-medium flex items-center gap-1">
                        Ver todas <span class="text-xl">→</span>
                    </Link>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <Link v-for="(category, index) in main_categories" :key="category.id" 
                        :href="route('shop.products.index', { category: category.slug })"
                        class="group relative overflow-hidden rounded-2xl bg-dark-card border border-white/5 hover:border-brand-500/50 transition-all duration-300 aspect-[4/3] flex flex-col items-center justify-center p-6"
                    >
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent to-brand-900/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <!-- Icon Placeholder (Dynamic Color) -->
                        <div class="w-16 h-16 rounded-2xl bg-brand-500/10 flex items-center justify-center mb-4 text-3xl group-hover:scale-110 group-hover:bg-brand-500/20 transition-all duration-300">
                           <!-- Puedes reemplazar estos emojis con íconos SVG reales según el nombre de la categoría -->
                           <span v-if="category.name.includes('Procesador')">🧠</span>
                           <span v-else-if="category.name.includes('Tarjeta')">🎮</span>
                           <span v-else-if="category.name.includes('Motherboard')">🔌</span>
                           <span v-else-if="category.name.includes('Ram')">💾</span>
                           <span v-else>📦</span>
                        </div>
                        
                        <h3 class="text-white font-bold text-lg z-10">{{ category.name }}</h3>
                        <span class="text-gray-500 text-sm z-10">{{ category.products_count }} productos</span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Productos Destacados -->
        <section class="py-20 bg-[#080a0f]">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-display font-bold text-white mb-4">⭐ Productos Destacados</h2>
                    <div class="w-20 h-1 bg-brand-500 mx-auto rounded-full"></div>
                </div>

                <div v-if="featured_products.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <ProductCard v-for="product in featured_products" :key="product.id" :product="product" />
                </div>

                <div v-else class="bg-dark-card border border-white/5 rounded-2xl p-12 text-center max-w-2xl mx-auto">
                    <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                        🔌
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Aún no hay productos destacados</h3>
                    <p class="text-gray-400">Estamos actualizando nuestro inventario con lo último en tecnología.</p>
                </div>
            </div>
        </section>

        <!-- Recomendados para Ti (IA/Personalizado) -->
        <section v-if="recommended_products && recommended_products.length > 0" class="py-20 bg-[#0B0E14] relative overflow-hidden">
            <!-- Efecto de fondo especial para recomendaciones -->
            <div class="absolute inset-0 bg-gradient-to-br from-accent-purple/5 to-transparent"></div>
            <div class="absolute top-10 right-10 w-96 h-96 bg-accent-purple/10 rounded-full blur-3xl filter"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-accent-purple/10 border border-accent-purple/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-accent-purple" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-accent-purple font-semibold text-sm">INTELIGENCIA ARTIFICIAL</span>
                    </div>
                    <h2 class="text-4xl font-display font-bold text-white mb-3">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-purple to-primary-blue">Recomendado para Ti</span>
                    </h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">
                        Basado en tus preferencias y productos que has visto recientemente
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <ProductCard v-for="product in recommended_products" :key="'rec-' + product.id" :product="product" />
                </div>

                <div class="text-center mt-12">
                    <Link :href="route('shop.products.index')" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-dark-card border border-accent-purple/30 text-white rounded-lg hover:bg-accent-purple/10 transition-all">
                        Explorar Más Productos
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Marcas (Infinite Scroll Style Illusion) -->
        <section class="py-16 border-y border-white/5 bg-[#0B0E14]">
            <div class="container mx-auto px-4">
                <p class="text-center text-gray-500 text-sm uppercase tracking-widest mb-8">Trabajamos con las mejores marcas</p>
                <div class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                    <div v-for="brand in brands" :key="brand.id" class="text-xl font-bold text-white hover:text-brand-400 cursor-default">
                        {{ brand.name }}
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
