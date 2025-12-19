<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/UI/InputError.vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    brand: Object,
});

const form = useForm({
    name: props.brand.name,
    description: props.brand.description,
    logo: null,
    _method: 'PUT',
});

const submit = () => {
    form.post(route('admin.brands.update', props.brand.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="Editar Marca" />

        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white">Editar Marca</h2>
                <Link :href="route('admin.brands.index')" class="text-gray-400 hover:text-white">
                    &larr; Volver
                </Link>
            </div>

            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <form @submit.prevent="submit">
                    <!-- Nombre -->
                    <div class="mb-4">
                        <InputLabel for="name" value="Nombre" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Logo Actual -->
                    <div class="mb-4" v-if="brand.logo_url">
                        <InputLabel value="Logo Actual" />
                        <img :src="brand.logo_url" alt="Logo" class="mt-2 h-16 object-contain bg-white p-2 rounded">
                    </div>

                    <!-- Subir Nuevo Logo -->
                    <div class="mb-4">
                        <InputLabel for="logo" value="Subir Logo (Opcional - JPG, PNG, SVG)" />
                        <input
                            id="logo"
                            type="file"
                            class="mt-1 block w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-brand-500 file:text-white hover:file:bg-brand-600 cursor-pointer"
                            @input="form.logo = $event.target.files[0]"
                            accept="image/jpeg,image/png,image/webp,image/svg+xml"
                        />
                        <p class="text-xs text-gray-500 mt-1">Máximo 2MB. Formatos: JPG, PNG, WEBP, SVG</p>
                        <InputError class="mt-2" :message="form.errors.logo" />
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <InputLabel for="description" value="Descripción" />
                        <textarea
                            id="description"
                            class="mt-1 block w-full border-gray-300 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            v-model="form.description"
                            rows="3"
                        ></textarea>
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <div class="flex items-center justify-end">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Actualizar Marca
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

