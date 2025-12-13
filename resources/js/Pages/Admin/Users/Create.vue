<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/UI/InputError.vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    roles: Array,
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    role_id: '',
});

const submit = () => {
    form.post(route('admin.users.store'));
};
</script>

<template>
    <AdminLayout>
        <Head title="Nuevo Usuario" />

        <div class="py-6 px-4 sm:px-6 lg:px-8 bg-dark-bg min-h-screen">
            <div class="max-w-3xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-3xl font-lexend font-bold text-white">✨ Nuevo Usuario</h2>
                        <p class="text-gray-400 mt-1">Crea un nuevo usuario y asigna su rol</p>
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
                                    placeholder="Ej: Juan Pérez"
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
                                    placeholder="correo@ejemplo.com"
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
                                    placeholder="+51 999 999 999"
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
                                    <option value="">Seleccionar Rol</option>
                                    <option v-for="role in roles" :key="role.id" :value="role.id">
                                        {{ role.name }} {{ role.name === 'Admin' ? '(Acceso Total al Panel)' : '(Cliente Regular)' }}
                                    </option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">
                                    💡 <strong>Admin:</strong> Acceso completo al panel de administración. 
                                    <strong>Customer:</strong> Usuario cliente normal.
                                </p>
                                <InputError class="mt-2" :message="form.errors.role_id" />
                            </div>
                        </div>
                    </div>

                    <!-- Seguridad -->
                    <div class="bg-dark-card rounded-xl p-8 border border-primary-blue/20 shadow-lg">
                        <h3 class="text-xl font-lexend font-bold text-primary-blue mb-6">🔒 Seguridad</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Contraseña -->
                            <div>
                                <InputLabel for="password" value="Contraseña" class="text-gray-300" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.password"
                                    required
                                    placeholder="Mínimo 8 caracteres"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div>
                                <InputLabel for="password_confirmation" value="Confirmar Contraseña" class="text-gray-300" />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.password_confirmation"
                                    required
                                    placeholder="Repetir contraseña"
                                />
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-yellow-900/20 border border-yellow-500/30 rounded-lg">
                            <p class="text-yellow-400 text-sm flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>
                                    <strong>Importante:</strong> El usuario recibirá estas credenciales para acceder al sistema. Asegúrate de que la contraseña sea segura.
                                </span>
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
                            💾 Crear Usuario
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

