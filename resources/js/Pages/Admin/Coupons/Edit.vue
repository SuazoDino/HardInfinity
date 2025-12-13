<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/UI/InputError.vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ coupon: Object });
const form = useForm({
    code: props.coupon.code,
    type: props.coupon.type,
    value: props.coupon.value,
    min_purchase: props.coupon.min_purchase || 0,
    max_uses: props.coupon.max_uses,
    expires_at: props.coupon.expires_at ? props.coupon.expires_at.split('T')[0] : '',
    is_active: props.coupon.is_active,
});
</script>

<template>
    <AdminLayout>
        <Head :title="`Editar: ${coupon.code}`" />
        <div class="max-w-2xl mx-auto py-6">
            <div class="flex justify-between mb-8">
                <h1 class="text-2xl font-bold text-white">Editar: {{ coupon.code }}</h1>
                <Link :href="route('admin.coupons.index')" class="text-gray-400 hover:text-white">← Volver</Link>
            </div>
            <div class="bg-[#151A23] border border-white/5 rounded-xl p-6">
                <form @submit.prevent="form.put(route('admin.coupons.update', coupon.id))" class="space-y-6">
                    <div>
                        <InputLabel value="Código" />
                        <TextInput v-model="form.code" class="mt-1 block w-full bg-dark-bg border-white/10 text-white uppercase" required />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Tipo" />
                            <select v-model="form.type" class="mt-1 block w-full bg-dark-bg border-white/10 text-white rounded-lg">
                                <option value="percentage">%</option>
                                <option value="fixed">S/</option>
                            </select>
                        </div>
                        <div>
                            <InputLabel value="Valor" />
                            <TextInput v-model="form.value" type="number" step="0.01" class="mt-1 block w-full bg-dark-bg border-white/10 text-white" required />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Mín." />
                            <TextInput v-model="form.min_purchase" type="number" step="0.01" class="mt-1 block w-full bg-dark-bg border-white/10 text-white" />
                        </div>
                        <div>
                            <InputLabel value="Usos Máx." />
                            <TextInput v-model="form.max_uses" type="number" class="mt-1 block w-full bg-dark-bg border-white/10 text-white" />
                        </div>
                    </div>
                    <div>
                        <InputLabel value="Expira" />
                        <TextInput v-model="form.expires_at" type="date" class="mt-1 block w-full bg-dark-bg border-white/10 text-white" />
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" v-model="form.is_active" class="rounded border-gray-600 text-brand-600 bg-dark-bg" />
                        <span class="ml-2 text-sm text-gray-300">Activo</span>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-sm text-gray-400">Usos: {{ coupon.uses_count }}</p>
                        <PrimaryButton class="bg-brand-600" :disabled="form.processing">Actualizar</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

