<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/UI/InputError.vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';
import TextInput from '@/Components/UI/TextInput.vue';

const props = defineProps({
    user: Object,
});

const profileForm = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone || '',
});

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updateProfile = () => {
    profileForm.put(route('admin.profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // Success handled by flash message
        },
    });
};

const updatePassword = () => {
    passwordForm.put(route('admin.profile.password'), {
        preserveScroll: true,
        onSuccess: () => {
            passwordForm.reset();
        },
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="Mi Perfil" />

        <div class="py-6">
            <h1 class="text-3xl font-display font-bold text-white mb-8">Mi Perfil de Administrador</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Información del Usuario -->
                <div class="lg:col-span-1">
                    <div class="bg-[#151A23] border border-white/5 rounded-xl p-6 text-center">
                        <img :src="`https://ui-avatars.com/api/?name=${user.name}&background=0ea5e9&color=fff&size=120&bold=true`" 
                            alt="Avatar" 
                            class="w-32 h-32 rounded-full mx-auto mb-4 ring-4 ring-brand-500/50">
                        <h2 class="text-xl font-bold text-white mb-1">{{ user.name }}</h2>
                        <p class="text-sm text-gray-400 mb-3">{{ user.email }}</p>
                        <span class="inline-block px-3 py-1 bg-gradient-to-r from-brand-600 to-brand-400 text-white text-xs font-bold rounded-full">
                            {{ user.role.name }}
                        </span>
                        
                        <div class="mt-6 pt-6 border-t border-white/10 text-left space-y-3">
                            <div class="flex items-center gap-2 text-sm">
                                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-300">{{ user.email }}</span>
                            </div>
                            <div v-if="user.phone" class="flex items-center gap-2 text-sm">
                                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="text-gray-300">{{ user.phone }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formularios -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Actualizar Información Personal -->
                    <div class="bg-[#151A23] border border-white/5 rounded-xl p-6">
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Información Personal
                        </h3>

                        <form @submit.prevent="updateProfile" class="space-y-4">
                            <div>
                                <InputLabel for="name" value="Nombre Completo" class="text-gray-300" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full bg-dark-bg border-white/10 text-white focus:border-brand-500 focus:ring-brand-500"
                                    v-model="profileForm.name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="profileForm.errors.name" />
                            </div>

                            <div>
                                <InputLabel for="email" value="Correo Electrónico" class="text-gray-300" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full bg-dark-bg border-white/10 text-white focus:border-brand-500 focus:ring-brand-500"
                                    v-model="profileForm.email"
                                    required
                                />
                                <InputError class="mt-2" :message="profileForm.errors.email" />
                            </div>

                            <div>
                                <InputLabel for="phone" value="Teléfono (Opcional)" class="text-gray-300" />
                                <TextInput
                                    id="phone"
                                    type="tel"
                                    class="mt-1 block w-full bg-dark-bg border-white/10 text-white focus:border-brand-500 focus:ring-brand-500"
                                    v-model="profileForm.phone"
                                />
                                <InputError class="mt-2" :message="profileForm.errors.phone" />
                            </div>

                            <div class="flex items-center justify-end pt-4">
                                <PrimaryButton 
                                    class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-2 px-6 rounded-lg transition-colors"
                                    :class="{ 'opacity-25': profileForm.processing }" 
                                    :disabled="profileForm.processing">
                                    Actualizar Información
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div class="bg-[#151A23] border border-white/5 rounded-xl p-6">
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Cambiar Contraseña
                        </h3>

                        <form @submit.prevent="updatePassword" class="space-y-4">
                            <div>
                                <InputLabel for="current_password" value="Contraseña Actual" class="text-gray-300" />
                                <TextInput
                                    id="current_password"
                                    type="password"
                                    class="mt-1 block w-full bg-dark-bg border-white/10 text-white focus:border-brand-500 focus:ring-brand-500"
                                    v-model="passwordForm.current_password"
                                    required
                                />
                                <InputError class="mt-2" :message="passwordForm.errors.current_password" />
                            </div>

                            <div>
                                <InputLabel for="password" value="Nueva Contraseña" class="text-gray-300" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full bg-dark-bg border-white/10 text-white focus:border-brand-500 focus:ring-brand-500"
                                    v-model="passwordForm.password"
                                    required
                                />
                                <InputError class="mt-2" :message="passwordForm.errors.password" />
                            </div>

                            <div>
                                <InputLabel for="password_confirmation" value="Confirmar Nueva Contraseña" class="text-gray-300" />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full bg-dark-bg border-white/10 text-white focus:border-brand-500 focus:ring-brand-500"
                                    v-model="passwordForm.password_confirmation"
                                    required
                                />
                                <InputError class="mt-2" :message="passwordForm.errors.password_confirmation" />
                            </div>

                            <div class="flex items-center justify-end pt-4">
                                <PrimaryButton 
                                    class="bg-red-600 hover:bg-red-500 text-white font-bold py-2 px-6 rounded-lg transition-colors"
                                    :class="{ 'opacity-25': passwordForm.processing }" 
                                    :disabled="passwordForm.processing">
                                    Cambiar Contraseña
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

