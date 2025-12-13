<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    items: Array,
});

const removeForm = useForm({});

const removeItem = (productId) => {
    removeForm.delete(route('wishlist.destroy', productId), {
        preserveScroll: true,
    });
};
</script>

<template>
    <ProfileLayout>
        <Head title="Wishlist" />

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white mb-2">Mi Wishlist</h1>
            <p class="text-gray-400 text-sm">Productos que guardaste para más tarde.</p>
        </div>

        <div v-if="items.length" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <div v-for="item in items" :key="item.id" class="bg-[#151A23] border border-white/5 rounded-xl p-4 flex gap-4">
                <img :src="item.product.primary_image?.image_url || item.product.images?.[0]?.image_url || '/images/default-product.png'"
                    alt="Producto"
                    class="w-20 h-20 object-cover rounded-lg border border-white/5">
                <div class="flex-1 min-w-0">
                    <Link :href="route('shop.products.show', item.product.slug)" class="text-white font-semibold truncate hover:text-brand-400">
                        {{ item.product.name }}
                    </Link>
                    <p class="text-sm text-gray-400 mt-1">{{ item.product.brand?.name }}</p>
                    <p class="text-lg font-bold text-brand-400 mt-2">S/ {{ item.product.price }}</p>
                    <div class="mt-3 flex gap-2">
                        <Link :href="route('shop.products.show', item.product.slug)" class="text-sm text-brand-400 hover:text-white">
                            Ver producto
                        </Link>
                        <button @click="removeItem(item.product.id)" class="text-sm text-red-400 hover:text-red-300" :disabled="removeForm.processing">
                            Quitar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="text-center py-12 bg-[#151A23] border border-white/5 rounded-xl">
            <div class="text-5xl mb-4 opacity-60">🤍</div>
            <h2 class="text-xl font-bold text-white mb-2">Aún no tienes favoritos</h2>
            <p class="text-gray-500 text-sm mb-6">Explora el catálogo y guarda lo que te guste.</p>
            <Link :href="route('shop.products.index')" class="px-6 py-2.5 bg-brand-600 text-white text-sm font-bold rounded-lg hover:bg-brand-500 transition-colors shadow-lg shadow-brand-500/20">
                Ir al catálogo
            </Link>
        </div>
    </ProfileLayout>
</template>

