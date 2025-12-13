<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/UI/InputError.vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    roles: Array,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone || '',
    password: '',
    password_confirmation: '',
    role_id: props.user.role_id,
});

const submit = () => {
    form.put(route('admin.users.update', props.user.id));
};
</script>

<template>
    <AdminLayout>
        <Head title="Editar Usuario" />

        <div class="py-6 px-4 sm:px-6 lg:px-8 bg-dark-bg min-h-screen">
            <div class="max-w-3xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-3xl font-lexend font-bold text-white">✏️ Editar Usuario</h2>
                        <p class="text-gray-400 mt-1">{{ user.name }}</p>
                    </div>
                    <Link :href="route('admin.users.index')" 
                        class="px-4 py-2 bg-dark-card border border-primary-blue/20 text-gray-300 rounded-lg hover:bg-primary-blue/10 hover:text-white transition-all">
                        ← Volver
                    </Link>
                </div>

                <form @submit.prevent="submit" class="space-y-8">
                    <!-- Información Personal -->
                    <div class="bg-dark-card rounded-xl p-8 border border-primary-blue/20 shadow-lg">
                        <h3 class="text-xl font-lexend font-bold text-primary-blue mb-6">📋 Información Personal</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div class="col-span-2">
                                <InputLabel for="name" value="Nombre Completo" class="text-gray-300" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- Email -->
                            <div>
                                <InputLabel for="email" value="Email" class="text-gray-300" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.email"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <InputLabel for="phone" value="Teléfono (Opcional)" class="text-gray-300" />
                                <TextInput
                                    id="phone"
                                    type="text"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.phone"
                                />
                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>

                            <!-- Rol -->
                            <div class="col-span-2">
                                <InputLabel for="role_id" value="Rol del Usuario" class="text-gray-300" />
                                <select
                                    id="role_id"
                                    class="mt-1 block w-full border-primary-blue/30 bg-dark-bg text-white focus:border-primary-blue focus:ring-primary-blue rounded-md shadow-sm"
                                    v-model="form.role_id"
                                    required
                                >
                                    <option v-for="role in roles" :key="role.id" :value="role.id">
                                        {{ role.name }} {{ role.name === 'Admin' ? '(Acceso Total al Panel)' : '(Cliente Regular)' }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.role_id" />
                            </div>
                        </div>
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div class="bg-dark-card rounded-xl p-8 border border-primary-blue/20 shadow-lg">
                        <h3 class="text-xl font-lexend font-bold text-primary-blue mb-6">🔒 Cambiar Contraseña</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nueva Contraseña -->
                            <div>
                                <InputLabel for="password" value="Nueva Contraseña (Opcional)" class="text-gray-300" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.password"
                                    placeholder="Dejar vacío para no cambiar"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div>
                                <InputLabel for="password_confirmation" value="Confirmar Nueva Contraseña" class="text-gray-300" />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.password_confirmation"
                                    placeholder="Repetir contraseña"
                                />
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-blue-900/20 border border-blue-500/30 rounded-lg">
                            <p class="text-blue-400 text-sm">
                                💡 Deja los campos vacíos si no deseas cambiar la contraseña del usuario.
                            </p>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex items-center justify-end gap-4 bg-dark-card rounded-xl p-6 border border-primary-blue/20">
                        <Link :href="route('admin.users.index')" 
                            class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all">
                            Cancelar
                        </Link>
                        <PrimaryButton 
                            class="px-8 py-3 bg-primary-blue hover:bg-blue-600 text-white font-bold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-primary-blue/50" 
                            :class="{ 'opacity-25': form.processing }" 
                            :disabled="form.processing">
                            💾 Actualizar Usuario
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

