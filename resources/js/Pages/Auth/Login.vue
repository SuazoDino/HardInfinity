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
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar Sesión" />

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-white">¡Bienvenido de nuevo!</h2>
            <p class="text-gray-400 text-sm mt-1">Ingresa a tu cuenta para continuar</p>
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-400 text-center">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Correo Electrónico" class="text-gray-300" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full bg-gray-900 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="ejemplo@correo.com"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" class="text-gray-300" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full bg-gray-900 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4 flex justify-between items-center">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" v-model="form.remember" class="rounded bg-gray-900 border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500" />
                    <span class="ml-2 text-sm text-gray-400">Recordarme</span>
                </label>

                <Link
                    :href="route('password.request')"
                    class="text-sm text-primary-blue hover:text-blue-300 underline"
                >
                    ¿Olvidaste tu contraseña?
                </Link>
            </div>

            <div class="flex items-center justify-end mt-6">
                <PrimaryButton class="w-full justify-center py-3 bg-blue-600 hover:bg-blue-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Iniciar Sesión
                </PrimaryButton>
            </div>

            <div class="mt-6 text-center text-sm text-gray-400">
                ¿No tienes una cuenta? 
                <Link :href="route('register')" class="text-blue-400 hover:text-blue-300 font-bold">
                    Regístrate gratis
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
