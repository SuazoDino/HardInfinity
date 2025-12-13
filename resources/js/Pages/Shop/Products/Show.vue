<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductCard from '@/Components/Shop/ProductCard.vue';
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    product: Object,
    related_products: Array,
    rating_avg: Number,
    rating_count: Number,
    reviews: Array,
    user_review: Object,
    in_wishlist: Boolean,
});

const activeImage = ref(props.product.images.find(img => img.is_primary)?.image_url || props.product.images[0]?.image_url || '/images/placeholder-product.png');
const quantity = ref(1);
const page = usePage();
const user = computed(() => page.props.auth.user);
const wishlistForm = useForm({ product_id: props.product.id });
const reviewForm = useForm({
    product_id: props.product.id,
    rating: props.user_review?.rating || 5,
    comment: props.user_review?.comment || '',
});

const mainImage = computed(() => {
    return activeImage.value;
});

const increment = () => {
    if (quantity.value < props.product.stock) quantity.value++;
};

const decrement = () => {
    if (quantity.value > 1) quantity.value--;
};

const addToCart = () => {
    router.post(route('cart.store'), {
        product_id: props.product.id,
        quantity: quantity.value
    }, {
        preserveScroll: true,
        onSuccess: () => {
            // Opcional: Mostrar notificación toast
        }
    });
};

const toggleWishlist = () => {
    if (!user.value) {
        router.visit(route('login'));
        return;
    }
    if (props.in_wishlist) {
        wishlistForm.delete(route('wishlist.destroy', props.product.id), { preserveScroll: true });
    } else {
        wishlistForm.post(route('wishlist.store'), { preserveScroll: true });
    }
};

const submitReview = () => {
    if (!user.value) {
        router.visit(route('login'));
        return;
    }
    if (props.user_review) {
        reviewForm.put(route('reviews.update', props.user_review.id), { preserveScroll: true });
    } else {
        reviewForm.post(route('reviews.store'), { preserveScroll: true });
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="product.name" />

        <div class="container mx-auto px-4 py-12">
            <!-- Breadcrumbs -->
            <nav class="flex text-gray-500 text-sm mb-8">
                <Link :href="route('home')" class="hover:text-brand-400 transition-colors">Inicio</Link>
                <span class="mx-2">/</span>
                <Link :href="route('shop.products.index')" class="hover:text-brand-400 transition-colors">Productos</Link>
                <span class="mx-2">/</span>
                <span class="text-gray-300">{{ product.category?.name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
                <!-- Gallery Section -->
                <div class="space-y-6">
                    <div class="aspect-square bg-dark-card rounded-2xl border border-white/5 overflow-hidden flex items-center justify-center p-8 relative group">
                        <!-- Glow effect -->
                        <div class="absolute inset-0 bg-brand-500/5 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <img 
                            :src="mainImage" 
                            :alt="product.name" 
                            class="max-w-full max-h-full object-contain relative z-10 transition-transform duration-500 group-hover:scale-105 drop-shadow-2xl"
                            @error="$event.target.src='https://via.placeholder.com/500?text=No+Image'"
                        />
                    </div>

                    <!-- Thumbnails -->
                    <div v-if="product.images.length > 1" class="flex gap-4 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-brand-900 scrollbar-track-dark-card">
                        <button 
                            v-for="img in product.images" 
                            :key="img.id"
                            @click="activeImage = img.image_url"
                            class="w-20 h-20 rounded-lg bg-dark-card border border-white/10 flex-shrink-0 p-2 flex items-center justify-center hover:border-brand-500 transition-all"
                            :class="{ 'border-brand-500 ring-2 ring-brand-500/20': activeImage === img.image_url }"
                        >
                            <img :src="img.image_url" class="max-w-full max-h-full object-contain" />
                        </button>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="flex flex-col">
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-brand-400 font-bold tracking-wider text-xs uppercase">{{ product.brand?.name }}</span>
                            <span v-if="product.stock > 0" class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-500/10 text-green-400 border border-green-500/20">
                                Disponible
                            </span>
                            <span v-else class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-500/10 text-red-400 border border-red-500/20">
                                Agotado
                            </span>
                        </div>
                        
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h1 class="text-3xl md:text-4xl font-display font-bold text-white leading-tight mb-3">
                                    {{ product.name }}
                                </h1>
                                <div class="flex items-center gap-4 text-sm text-gray-400">
                                    <span>SKU: {{ product.sku || 'N/A' }}</span>
                                    <span>|</span>
                                    <span class="flex items-center gap-1 text-yellow-400">
                                        ⭐ {{ rating_avg ? rating_avg.toFixed(1) : 'Sin calificar' }} <span v-if="rating_count">({{ rating_count }} reseñas)</span>
                                    </span>
                                </div>
                            </div>
                            <button
                                @click="toggleWishlist"
                                class="w-11 h-11 flex items-center justify-center rounded-full border border-white/10 bg-white/5 hover:bg-brand-500/20 transition-colors"
                                :class="{ 'border-brand-500 bg-brand-500/20 text-brand-300': in_wishlist }"
                            >
                                <span class="text-xl" :class="in_wishlist ? 'text-brand-300' : 'text-gray-300'">❤</span>
                            </button>
                        </div>
                    </div>

                    <div class="border-y border-white/5 py-6 mb-8">
                        <div class="flex items-end gap-4 mb-2">
                            <span class="text-4xl font-bold text-white">S/ {{ product.price }}</span>
                            <!-- <span class="text-xl text-gray-500 line-through decoration-red-500 decoration-2">S/ {{ (product.price * 1.2).toFixed(2) }}</span> -->
                        </div>
                        <p class="text-sm text-brand-300">
                            🔥 ¡Ahorras S/ {{ (product.price * 0.1).toFixed(2) }} pagando con Yape!
                        </p>
                    </div>

                    <div class="prose prose-invert prose-sm text-gray-400 mb-8 max-w-none">
                        <p>{{ product.description }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="mt-auto space-y-4">
                        <div v-if="product.stock > 0" class="flex flex-col sm:flex-row gap-4">
                            <!-- Quantity Selector -->
                            <div class="flex items-center bg-dark-card border border-white/10 rounded-lg h-14 w-full sm:w-auto">
                                <button @click="decrement" class="px-4 text-gray-400 hover:text-white transition-colors text-xl font-bold">-</button>
                                <span class="flex-1 text-center font-bold text-white w-12">{{ quantity }}</span>
                                <button @click="increment" class="px-4 text-gray-400 hover:text-white transition-colors text-xl font-bold">+</button>
                            </div>

                            <!-- Add to Cart -->
                            <button 
                                @click="addToCart"
                                class="flex-1 h-14 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-lg flex items-center justify-center gap-2 transition-all shadow-lg shadow-brand-500/20 hover:shadow-brand-500/40"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                Agregar al Carrito
                            </button>
                        </div>
                         <button 
                            v-else
                            disabled
                            class="w-full h-14 bg-gray-700 text-gray-400 font-bold rounded-lg cursor-not-allowed flex items-center justify-center"
                        >
                            Producto Agotado
                        </button>
                    </div>
                </div>
            </div>

            <!-- Especificaciones y Reviews -->
            <div class="mt-20 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-dark-card rounded-2xl border border-white/5 p-8 lg:col-span-2">
                    <h3 class="text-xl font-bold text-white mb-6">Detalles Técnicos</h3>
                    
                    <div v-if="product.specifications && product.specifications.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                        <div v-for="spec in product.specifications" :key="spec.id" class="flex justify-between border-b border-white/5 py-3">
                            <span class="text-gray-400">{{ spec.name }}</span>
                            <span class="text-white font-medium text-right">{{ spec.value }}</span>
                        </div>
                    </div>
                    <div v-else class="text-gray-500 italic">
                        No hay especificaciones registradas para este producto.
                    </div>
                </div>

                <div class="bg-dark-card rounded-2xl border border-white/5 p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-white">Reseñas</h3>
                        <div class="text-sm text-gray-300 flex items-center gap-2">
                            ⭐ {{ rating_avg ? rating_avg.toFixed(1) : 'N/A' }}
                            <span class="text-gray-500">({{ rating_count }} reseñas)</span>
                        </div>
                    </div>

                    <div v-if="user" class="mb-6 space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-300 text-sm">Tu calificación:</span>
                            <div class="flex items-center gap-1">
                                <button v-for="n in 5" :key="n" @click="reviewForm.rating = n" class="text-xl"
                                    :class="reviewForm.rating >= n ? 'text-yellow-400' : 'text-gray-600'">★</button>
                            </div>
                        </div>
                        <textarea
                            v-model="reviewForm.comment"
                            rows="3"
                            class="w-full bg-dark-bg border border-white/10 rounded-lg text-sm text-white p-3 focus:border-brand-500 focus:ring-brand-500"
                            placeholder="Comparte tu experiencia (opcional)"
                        ></textarea>
                        <div class="flex justify-end">
                            <button
                                @click="submitReview"
                                :disabled="reviewForm.processing"
                                class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white rounded-lg text-sm font-bold transition-colors"
                            >
                                {{ user_review ? 'Actualizar reseña' : 'Publicar reseña' }}
                            </button>
                        </div>
                        <p v-if="reviewForm.errors.comment" class="text-red-400 text-sm">{{ reviewForm.errors.comment }}</p>
                        <p v-if="reviewForm.errors.rating" class="text-red-400 text-sm">{{ reviewForm.errors.rating }}</p>
                    </div>
                    <div v-else class="mb-6 text-sm text-gray-400">
                        <Link :href="route('login')" class="text-brand-400 hover:text-brand-300 font-semibold">Inicia sesión</Link> para dejar tu reseña.
                    </div>

                    <div class="space-y-4 max-h-80 overflow-y-auto pr-2">
                        <div v-for="rev in reviews" :key="rev.id" class="border-b border-white/5 pb-3">
                            <div class="flex items-center gap-2 text-sm">
                                <span class="text-white font-semibold">{{ rev.user?.name || 'Usuario' }}</span>
                                <span class="text-yellow-400">{"★".repeat(rev.rating)}</span>
                            </div>
                            <p class="text-gray-300 text-sm mt-1" v-if="rev.comment">{{ rev.comment }}</p>
                            <p class="text-gray-500 text-xs mt-1">{{ new Date(rev.created_at).toLocaleDateString('es-PE') }}</p>
                        </div>
                        <div v-if="!reviews.length" class="text-gray-500 text-sm">
                            Aún no hay reseñas. Sé el primero en opinar.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div class="mt-20">
                <h2 class="text-2xl font-display font-bold text-white mb-8">También te podría interesar</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <ProductCard v-for="rel in related_products" :key="rel.id" :product="rel" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

