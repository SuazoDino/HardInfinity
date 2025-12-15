<script setup>
import { Link, router } from '@inertiajs/vue3';

defineProps({
    product: Object,
});

const addToCart = (product) => {
    router.post(route('cart.store'), {
        product_id: product.id,
        quantity: 1
    }, {
        preserveScroll: true,
    });
};

const getImage = (product) => {
    if (product.images && product.images.length > 0) {
        return product.images.find(img => img.is_primary)?.image_path || product.images[0].image_path;
    }
    return 'https://via.placeholder.com/300x300/1a202c/0ea5e9?text=Sin+Imagen';
};
</script>

<template>
    <div class="group bg-dark-card rounded-2xl border border-white/5 overflow-hidden hover:border-brand-500/50 hover:shadow-2xl hover:shadow-brand-500/10 transition-all duration-300 flex flex-col h-full relative">
        
        <!-- Badges -->
        <div class="absolute top-3 left-3 z-10 flex flex-col gap-2">
            <span v-if="product.is_featured" class="px-2 py-1 bg-yellow-500/20 text-yellow-400 text-xs font-bold rounded backdrop-blur-md border border-yellow-500/20">
                ⭐ Destacado
            </span>
            <span v-if="product.stock < 5" class="px-2 py-1 bg-red-500/20 text-red-400 text-xs font-bold rounded backdrop-blur-md border border-red-500/20">
                🔥 Poco Stock
            </span>
        </div>

        <!-- Imagen Container -->
        <Link :href="route('shop.products.show', product.slug)" class="relative aspect-square bg-gradient-to-b from-white/5 to-transparent p-6 flex items-center justify-center group-hover:bg-white/10 transition-colors cursor-pointer">
            <img 
                :src="getImage(product)" 
                :alt="product.name" 
                class="max-h-full max-w-full object-contain drop-shadow-xl group-hover:scale-110 transition-transform duration-500 ease-out"
                @error="$event.target.src='https://via.placeholder.com/300x300?text=No+Image'"
            />
        </Link>

        <!-- Contenido -->
        <div class="p-5 flex-1 flex flex-col">
            <p class="text-xs text-brand-400 font-bold uppercase tracking-wider mb-2">{{ product.brand?.name }}</p>
            
            <Link :href="route('shop.products.show', product.slug)" class="block flex-1">
                <h3 class="text-white font-medium leading-tight mb-2 hover:text-brand-400 transition-colors line-clamp-2">
                    {{ product.name }}
                </h3>
            </Link>

            <div class="mt-4 flex items-end justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Precio Contado</p>
                    <p class="text-xl font-bold text-white">S/ {{ product.price }}</p>
                </div>
                
                <button 
                    @click.prevent="addToCart(product)"
                    class="w-10 h-10 rounded-full bg-white/5 hover:bg-brand-500 text-brand-400 hover:text-white flex items-center justify-center transition-all"
                    title="Agregar al carrito"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </button>
            </div>
        </div>
    </div>
</template>
