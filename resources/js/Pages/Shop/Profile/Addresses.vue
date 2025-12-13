<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import InputError from '@/Components/UI/InputError.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';

const props = defineProps({
    addresses: Array,
});

const showForm = ref(false);

const form = useForm({
    address_line1: '',
    city: '',
    state: '',
    zip_code: '',
    country: 'Perú',
});

const submit = () => {
    form.post(route('profile.addresses.store'), {
        onSuccess: () => {
            form.reset();
            showForm.value = false;
        },
    });
};

const deleteAddress = (id) => {
    if (confirm('¿Estás seguro de eliminar esta dirección?')) {
        router.delete(route('profile.addresses.destroy', id));
    }
};
</script>

<template>
    <ProfileLayout>
        <Head title="Direcciones" />

        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white mb-2">Mis Direcciones</h1>
                <p class="text-gray-400 text-sm">Administra tus direcciones de envío.</p>
            </div>
            <button @click="showForm = !showForm" class="px-4 py-2 bg-brand-600 text-white rounded-lg text-sm font-bold hover:bg-brand-500">
                {{ showForm ? 'Cancelar' : '+ Nueva Dirección' }}
            </button>
        </div>

        <!-- Formulario Nueva Dirección -->
        <div v-if="showForm" class="mb-8 bg-[#151A23] p-6 rounded-xl border border-white/5 animate-in fade-in slide-in-from-top-4">
            <h3 class="text-white font-bold mb-4">Agregar Nueva Dirección</h3>
            <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <InputLabel value="Dirección (Calle, N°, Dpto)" class="text-gray-300" />
                    <TextInput v-model="form.address_line1" type="text" class="mt-1 w-full bg-[#0B0E14]" required />
                    <InputError :message="form.errors.address_line1" />
                </div>
                <div>
                    <InputLabel value="Ciudad" class="text-gray-300" />
                    <TextInput v-model="form.city" type="text" class="mt-1 w-full bg-[#0B0E14]" required />
                    <InputError :message="form.errors.city" />
                </div>
                <div>
                    <InputLabel value="Provincia / Estado" class="text-gray-300" />
                    <TextInput v-model="form.state" type="text" class="mt-1 w-full bg-[#0B0E14]" required />
                    <InputError :message="form.errors.state" />
                </div>
                <div>
                    <InputLabel value="Código Postal" class="text-gray-300" />
                    <TextInput v-model="form.zip_code" type="text" class="mt-1 w-full bg-[#0B0E14]" required />
                    <InputError :message="form.errors.zip_code" />
                </div>
                <div>
                    <InputLabel value="País" class="text-gray-300" />
                    <TextInput v-model="form.country" type="text" class="mt-1 w-full bg-[#0B0E14]" required />
                    <InputError :message="form.errors.country" />
                </div>
                <div class="md:col-span-2 flex justify-end mt-2">
                    <PrimaryButton :disabled="form.processing">Guardar Dirección</PrimaryButton>
                </div>
            </form>
        </div>

        <!-- Lista de Direcciones -->
        <div v-if="addresses.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div v-for="address in addresses" :key="address.id" class="bg-[#151A23] border border-white/5 p-6 rounded-xl relative group hover:border-brand-500/30 transition-colors">
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button @click="deleteAddress(address.id)" class="text-red-400 hover:text-red-300 text-sm">Eliminar</button>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-2xl">📍</span>
                    <div>
                        <p class="text-white font-bold">{{ address.address_line1 }}</p>
                        <p class="text-gray-400 text-sm">{{ address.city }}, {{ address.state }}</p>
                        <p class="text-gray-500 text-xs mt-1">{{ address.zip_code }} - {{ address.country }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div v-else-if="!showForm" class="text-center py-12 border-2 border-dashed border-white/5 rounded-xl">
            <p class="text-gray-500">No tienes direcciones guardadas.</p>
        </div>
    </ProfileLayout>
</template>

