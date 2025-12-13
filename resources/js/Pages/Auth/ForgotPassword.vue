<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/UI/InputError.vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Recuperar Contraseña" />

        <div class="mb-6 text-center">
            <h2 class="text-3xl font-lexend font-bold text-white mb-2">¿Olvidaste tu contraseña?</h2>
            <p class="text-gray-400 text-sm">
                No hay problema. Solo indícanos tu dirección de correo electrónico y te enviaremos un enlace para restablecerla.
            </p>
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-400 bg-green-900/20 border border-green-500/30 rounded-lg p-3">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" class="text-primary-blue" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="correo@ejemplo.com"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-blue"
                >
                    ← Volver al login
                </Link>

                <PrimaryButton 
                    class="bg-primary-blue hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-primary-blue/50" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing">
                    Enviar Enlace
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

