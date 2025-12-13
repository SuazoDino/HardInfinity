<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/UI/InputError.vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Restablecer Contraseña" />

        <div class="mb-6 text-center">
            <h2 class="text-3xl font-lexend font-bold text-white mb-2">Restablecer Contraseña</h2>
            <p class="text-gray-400 text-sm">
                Ingresa tu nueva contraseña para recuperar el acceso a tu cuenta.
            </p>
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
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Nueva Contraseña" class="text-primary-blue" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Mínimo 8 caracteres"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar Contraseña" class="text-primary-blue" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Repetir contraseña"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <PrimaryButton 
                    class="bg-primary-blue hover:bg-blue-600 text-white font-bold py-2 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-primary-blue/50" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing">
                    Restablecer Contraseña
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

