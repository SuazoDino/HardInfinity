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
    logo_url: props.brand.logo_url,
});

const submit = () => {
    form.put(route('admin.brands.update', props.brand.id));
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

                    <!-- URL Logo -->
                    <div class="mb-4">
                        <InputLabel for="logo_url" value="URL del Logo (Opcional)" />
                        <TextInput
                            id="logo_url"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.logo_url"
                            placeholder="/images/brands/mi-marca.png"
                        />
                        <InputError class="mt-2" :message="form.errors.logo_url" />
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

