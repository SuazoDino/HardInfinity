<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    cart: Object,
    subtotal: Number,
    shipping: Number,
    auth: Object
});

const form = useForm({
    address: '',
    city: '',
    phone: '',
    payment_method: 'card',
    coupon_code: '',
});

const cartItems = computed(() => Object.values(props.cart));

const discount = ref(0);
const couponMessage = ref('');
const couponError = ref('');
const validatingCoupon = ref(false);

const total = computed(() => props.subtotal + props.shipping - discount.value);

const validateCoupon = async () => {
    if (!form.coupon_code) return;
    
    validatingCoupon.value = true;
    couponError.value = '';
    couponMessage.value = '';
    
    try {
        const response = await axios.post(route('coupon.validate'), {
            code: form.coupon_code,
            subtotal: props.subtotal
        });
        
        if (response.data.success) {
            discount.value = response.data.coupon.discount;
            couponMessage.value = response.data.message;
        }
    } catch (error) {
        couponError.value = error.response?.data?.error || 'Cupón inválido';
        discount.value = 0;
    } finally {
        validatingCoupon.value = false;
    }
};

const submit = () => {
    form.post(route('shop.checkout.store'), {
        preserveScroll: true,
        onError: () => {
            // Manejar errores si es necesario
        }
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Finalizar Compra" />

        <div class="container mx-auto px-4 py-12">
            <h1 class="text-3xl font-display font-bold text-white mb-8">Finalizar Compra</h1>

            <form @submit.prevent="submit" class="flex flex-col lg:flex-row gap-8">
                
                <!-- Columna Izquierda: Datos -->
                <div class="flex-1 space-y-8">
                    <!-- 1. Información de Envío -->
                    <div class="bg-dark-card border border-white/5 rounded-xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <span class="bg-brand-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                            Datos de Envío
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-gray-400 text-sm mb-1">Dirección Completa</label>
                                <input 
                                    v-model="form.address"
                                    type="text" 
                                    placeholder="Av. Javier Prado 123, Dpto 401"
                                    class="w-full bg-dark-bg border border-gray-700 rounded-lg text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 p-3"
                                    required
                                />
                                <p v-if="form.errors.address" class="text-red-400 text-xs mt-1">{{ form.errors.address }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-gray-400 text-sm mb-1">Ciudad / Distrito</label>
                                <input 
                                    v-model="form.city"
                                    type="text" 
                                    placeholder="Miraflores, Lima"
                                    class="w-full bg-dark-bg border border-gray-700 rounded-lg text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 p-3"
                                    required
                                />
                                <p v-if="form.errors.city" class="text-red-400 text-xs mt-1">{{ form.errors.city }}</p>
                            </div>

                            <div>
                                <label class="block text-gray-400 text-sm mb-1">Teléfono / Celular</label>
                                <input 
                                    v-model="form.phone"
                                    type="tel" 
                                    placeholder="999 999 999"
                                    class="w-full bg-dark-bg border border-gray-700 rounded-lg text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 p-3"
                                    required
                                />
                                <p v-if="form.errors.phone" class="text-red-400 text-xs mt-1">{{ form.errors.phone }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Método de Pago -->
                    <div class="bg-dark-card border border-white/5 rounded-xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <span class="bg-brand-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                            Método de Pago
                        </h2>

                        <div class="space-y-3">
                            <label class="flex items-center gap-4 p-4 border border-gray-700 rounded-lg cursor-pointer hover:border-brand-500 transition-colors" :class="{'bg-brand-500/10 border-brand-500': form.payment_method === 'card'}">
                                <input type="radio" v-model="form.payment_method" value="card" class="text-brand-600 bg-dark-bg border-gray-600 focus:ring-brand-500" />
                                <span class="text-2xl">💳</span>
                                <div>
                                    <p class="text-white font-bold">Tarjeta (Simulado)</p>
                                    <p class="text-xs text-gray-400">Se marcará como pagado de inmediato</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-4 p-4 border border-gray-700 rounded-lg cursor-pointer hover:border-brand-500 transition-colors" :class="{'bg-purple-500/10 border-purple-500': form.payment_method === 'yape'}">
                                <input type="radio" v-model="form.payment_method" value="yape" class="text-purple-600 bg-dark-bg border-gray-600 focus:ring-purple-500" />
                                <span class="text-2xl">📱</span>
                                <div>
                                    <p class="text-white font-bold">Yape (Simulado)</p>
                                    <p class="text-xs text-gray-400">QR ficticio, se marcará como pagado</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-4 p-4 border border-gray-700 rounded-lg cursor-pointer hover:border-brand-500 transition-colors" :class="{'bg-green-500/10 border-green-500': form.payment_method === 'cash'}">
                                <input type="radio" v-model="form.payment_method" value="cash" class="text-green-600 bg-dark-bg border-gray-600 focus:ring-green-500" />
                                <span class="text-2xl">💵</span>
                                <div>
                                    <p class="text-white font-bold">Pago contra Entrega</p>
                                    <p class="text-xs text-gray-400">Se marcará como pendiente</p>
                                </div>
                            </label>
                        </div>
                        <p v-if="form.errors.payment_method" class="text-red-400 text-xs mt-1">{{ form.errors.payment_method }}</p>
                    </div>
                </div>

                <!-- Columna Derecha: Resumen -->
                <div class="w-full lg:w-96 flex-shrink-0">
                    <div class="bg-dark-card border border-white/5 rounded-xl p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-white mb-6">Resumen del Pedido</h2>
                        
                        <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-700">
                            <div v-for="item in cartItems" :key="item.id" class="flex gap-3">
                                <img :src="item.image" class="w-12 h-12 rounded object-contain bg-white/5" />
                                <div class="flex-1 min-w-0">
                                    <p class="text-white text-sm truncate font-medium">{{ item.name }}</p>
                                    <p class="text-xs text-gray-400">{{ item.quantity }} x S/ {{ item.price }}</p>
                                </div>
                                <p class="text-white text-sm font-bold">S/ {{ (item.price * item.quantity).toFixed(2) }}</p>
                            </div>
                        </div>

                        <!-- Cupón de Descuento -->
                        <div class="mb-6 pb-6 border-b border-white/10">
                            <label class="block text-gray-400 text-sm mb-2">¿Tienes un cupón?</label>
                            <div class="flex gap-2">
                                <input 
                                    v-model="form.coupon_code"
                                    type="text" 
                                    placeholder="CODIGO"
                                    class="flex-1 bg-dark-bg border border-gray-700 rounded-lg text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 p-2 text-sm uppercase"
                                    @keyup.enter="validateCoupon"
                                />
                                <button 
                                    type="button"
                                    @click="validateCoupon"
                                    :disabled="validatingCoupon || !form.coupon_code"
                                    class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-lg disabled:opacity-50"
                                >
                                    {{ validatingCoupon ? '...' : 'Aplicar' }}
                                </button>
                            </div>
                            <p v-if="couponMessage" class="text-green-400 text-xs mt-2">✓ {{ couponMessage }}</p>
                            <p v-if="couponError" class="text-red-400 text-xs mt-2">✗ {{ couponError }}</p>
                        </div>

                        <div class="space-y-2 text-sm border-t border-white/10 pt-4 mb-6">
                            <div class="flex justify-between text-gray-400">
                                <span>Subtotal</span>
                                <span class="text-white">S/ {{ subtotal.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-400">
                                <span>Envío</span>
                                <span v-if="shipping === 0" class="text-green-400 font-bold">GRATIS</span>
                                <span v-else class="text-white">S/ {{ shipping.toFixed(2) }}</span>
                            </div>
                            <div v-if="discount > 0" class="flex justify-between text-green-400">
                                <span>Descuento</span>
                                <span>- S/ {{ discount.toFixed(2) }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-8 border-t border-white/10 pt-4">
                            <span class="text-lg font-bold text-white">Total a Pagar</span>
                            <span class="text-2xl font-bold text-brand-400">S/ {{ total.toFixed(2) }}</span>
                        </div>

                        <button 
                            type="submit"
                            :disabled="form.processing"
                            class="w-full py-4 bg-green-600 hover:bg-green-500 text-white font-bold rounded-xl shadow-lg shadow-green-500/20 transition-all flex items-center justify-center gap-2"
                            :class="{'opacity-50 cursor-not-allowed': form.processing}"
                        >
                            <span v-if="!form.processing">✅ Confirmar Pedido</span>
                            <span v-else>Procesando...</span>
                        </button>
                        
                        <p class="text-xs text-center text-gray-500 mt-4">
                            Al confirmar, aceptas nuestros términos y condiciones.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

