<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/UI/InputError.vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    categories: Array, // Categorías padre disponibles
});

const form = useForm({
    name: '',
    description: '',
    parent_id: '',
    is_active: true,
});

const submit = () => {
    form.post(route('admin.categories.store'));
};
</script>

<template>
    <AdminLayout>
        <Head title="Nueva Categoría" />

        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white">Nueva Categoría</h2>
                <Link :href="route('admin.categories.index')" class="text-gray-400 hover:text-white">
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

                    <!-- Categoría Padre -->
                    <div class="mb-4">
                        <InputLabel for="parent_id" value="Categoría Padre (Opcional)" />
                        <select
                            id="parent_id"
                            class="mt-1 block w-full border-gray-300 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            v-model="form.parent_id"
                        >
                            <option value="">Ninguna (Categoría Principal)</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.parent_id" />
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

                    <!-- Estado -->
                    <div class="mb-6 block">
                        <label class="flex items-center">
                            <input type="checkbox" v-model="form.is_active" class="rounded bg-gray-900 border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500" />
                            <span class="ms-2 text-sm text-gray-300">Categoría Activa</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Guardar Categoría
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

