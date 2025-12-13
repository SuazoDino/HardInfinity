<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    order_number: String,
});
</script>

<template>
    <AppLayout>
        <Head title="¡Pedido Confirmado!" />

        <div class="container mx-auto px-4 py-20 text-center">
            <div class="max-w-xl mx-auto bg-dark-card border border-white/5 rounded-2xl p-10 shadow-2xl relative overflow-hidden">
                <!-- Confetti effect visualization (static) -->
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-brand-500 via-purple-500 to-brand-500"></div>

                <div class="w-24 h-24 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-6 text-5xl">
                    🎉
                </div>

                <h1 class="text-3xl font-display font-bold text-white mb-2">¡Gracias por tu Compra!</h1>
                <p class="text-gray-400 mb-8">Tu pedido ha sido procesado exitosamente.</p>

                <div class="bg-dark-bg border border-white/10 rounded-lg p-4 mb-8">
                    <p class="text-sm text-gray-500 mb-1">Número de Orden</p>
                    <p class="text-2xl font-mono font-bold text-brand-400 tracking-wider">{{ order_number }}</p>
                </div>

                <p class="text-sm text-gray-400 mb-8">
                    Hemos enviado un correo con los detalles. Puedes ver el estado de tu pedido en tu perfil.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Link :href="route('home')" class="px-6 py-3 bg-brand-600 text-white font-bold rounded-lg hover:bg-brand-500 transition-colors">
                        Volver a la Tienda
                    </Link>
                    <!-- <Link :href="route('profile.orders')" class="px-6 py-3 bg-gray-700 text-white font-medium rounded-lg hover:bg-gray-600 transition-colors">
                        Ver mis Pedidos
                    </Link> -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>

