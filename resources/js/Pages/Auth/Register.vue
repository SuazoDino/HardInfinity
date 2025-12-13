<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/UI/InputError.vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    terms: false,
    newsletter: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Registrarse" />

        <div class="mb-8 text-center">
            <h2 class="text-3xl font-display font-bold text-white">Crear Cuenta</h2>
            <p class="text-gray-400 mt-2">Únete a la comunidad <span class="text-brand-400 font-bold">HardInfinity</span></p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Fila 1: Nombre y Teléfono -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <InputLabel for="name" value="Nombre Completo" class="text-gray-300 mb-1.5" />
                    <TextInput
                        id="name"
                        type="text"
                        class="block w-full bg-[#1A1F2B] border-gray-700 text-white focus:border-brand-500 focus:ring-brand-500/50 rounded-lg py-2.5 placeholder-gray-600 transition-all"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Ej: Juan Pérez"
                    />
                    <InputError class="mt-1" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="phone" value="Teléfono (Opcional)" class="text-gray-300 mb-1.5" />
                    <TextInput
                        id="phone"
                        type="tel"
                        class="block w-full bg-[#1A1F2B] border-gray-700 text-white focus:border-brand-500 focus:ring-brand-500/50 rounded-lg py-2.5 placeholder-gray-600 transition-all"
                        v-model="form.phone"
                        autocomplete="tel"
                        placeholder="999 999 999"
                    />
                    <InputError class="mt-1" :message="form.errors.phone" />
                </div>
            </div>

            <!-- Fila 2: Email (Ancho completo) -->
            <div>
                <InputLabel for="email" value="Correo Electrónico" class="text-gray-300 mb-1.5" />
                <TextInput
                    id="email"
                    type="email"
                    class="block w-full bg-[#1A1F2B] border-gray-700 text-white focus:border-brand-500 focus:ring-brand-500/50 rounded-lg py-2.5 placeholder-gray-600 transition-all"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="nombre@ejemplo.com"
                />
                <InputError class="mt-1" :message="form.errors.email" />
            </div>

            <!-- Fila 3: Contraseñas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <InputLabel for="password" value="Contraseña" class="text-gray-300 mb-1.5" />
                    <TextInput
                        id="password"
                        type="password"
                        class="block w-full bg-[#1A1F2B] border-gray-700 text-white focus:border-brand-500 focus:ring-brand-500/50 rounded-lg py-2.5 placeholder-gray-600 transition-all"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    <InputError class="mt-1" :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel for="password_confirmation" value="Confirmar Contraseña" class="text-gray-300 mb-1.5" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="block w-full bg-[#1A1F2B] border-gray-700 text-white focus:border-brand-500 focus:ring-brand-500/50 rounded-lg py-2.5 placeholder-gray-600 transition-all"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    <InputError class="mt-1" :message="form.errors.password_confirmation" />
                </div>
            </div>

            <!-- Separador sutil -->
            <div class="border-t border-gray-700/50 my-6"></div>

            <!-- Checkboxes con mejor estilo -->
            <div class="space-y-4">
                <label class="flex items-start gap-3 cursor-pointer group">
                    <div class="relative flex items-center">
                        <input 
                            type="checkbox" 
                            v-model="form.terms"
                            class="w-5 h-5 rounded bg-[#1A1F2B] border-gray-600 text-brand-600 focus:ring-brand-500 focus:ring-offset-0 transition-all"
                        />
                    </div>
                    <span class="text-sm text-gray-400 group-hover:text-gray-300 transition-colors">
                        He leído y acepto los <a href="#" class="text-brand-400 hover:text-brand-300 hover:underline">Términos y Condiciones</a> y la <a href="#" class="text-brand-400 hover:text-brand-300 hover:underline">Política de Privacidad</a> <span class="text-red-400">*</span>
                    </span>
                </label>
                <InputError :message="form.errors.terms" />

                <label class="flex items-start gap-3 cursor-pointer group">
                    <div class="relative flex items-center">
                        <input 
                            type="checkbox" 
                            v-model="form.newsletter"
                            class="w-5 h-5 rounded bg-[#1A1F2B] border-gray-600 text-brand-600 focus:ring-brand-500 focus:ring-offset-0 transition-all"
                        />
                    </div>
                    <span class="text-sm text-gray-400 group-hover:text-gray-300 transition-colors leading-tight">
                        Quiero recibir ofertas exclusivas, novedades y promociones por correo.
                    </span>
                </label>
            </div>

            <!-- Botón Submit -->
            <div class="pt-4">
                <PrimaryButton class="w-full justify-center py-3.5 bg-brand-600 hover:bg-brand-500 text-white text-base font-bold shadow-lg shadow-brand-500/20 transition-all transform hover:-translate-y-0.5" :class="{ 'opacity-75 cursor-not-allowed': form.processing }" :disabled="form.processing">
                    Crear Cuenta
                </PrimaryButton>
            </div>

            <p class="text-center text-sm text-gray-500 mt-6">
                ¿Ya tienes una cuenta?
                <Link :href="route('login')" class="text-brand-400 hover:text-brand-300 font-bold hover:underline transition-colors">
                    Inicia Sesión
                </Link>
            </p>
        </form>
    </GuestLayout>
</template>
