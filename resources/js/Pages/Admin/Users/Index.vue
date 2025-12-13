<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    users: Object,
    roles: Array,
    filters: Object,
});

const searchInput = ref(props.filters.search || '');

const search = () => {
    router.get(route('admin.users.index'), { search: searchInput.value }, {
        preserveState: true,
        replace: true,
    });
};

const deleteUser = (user) => {
    if (confirm(`¿Estás seguro de eliminar al usuario "${user.name}"?`)) {
        router.delete(route('admin.users.destroy', user.id));
    }
};

const getRoleBadgeClass = (roleName) => {
    return roleName === 'Admin'
        ? 'bg-gradient-to-r from-accent-purple to-primary-blue'
        : 'bg-gray-700';
};
</script>

<template>
    <AdminLayout>
        <Head title="Gestión de Usuarios" />

        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-lexend font-bold text-white">👥 Gestión de Usuarios</h2>
                    <p class="text-gray-400 mt-1">Administra los usuarios del sistema y sus roles</p>
                </div>
                <Link :href="route('admin.users.create')" 
                    class="px-6 py-3 bg-gradient-to-r from-primary-blue to-accent-purple hover:from-blue-600 hover:to-purple-600 text-white font-bold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-primary-blue/50 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nuevo Usuario
                </Link>
            </div>

            <!-- Filtros -->
            <div class="bg-dark-card rounded-lg p-6 border border-primary-blue/20 mb-8 shadow-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Buscar</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                v-model="searchInput"
                                @keyup.enter="search"
                                placeholder="Buscar por nombre o email..." 
                                class="w-full bg-dark-bg border border-primary-blue/30 text-white rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-blue"
                            />
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-end gap-2">
                        <button @click="search" class="px-6 py-2 bg-primary-blue hover:bg-blue-600 text-white rounded-lg transition-all font-semibold">
                            Buscar
                        </button>
                        <Link :href="route('admin.users.index')" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all font-semibold">
                            Limpiar
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="bg-dark-card rounded-lg border border-primary-blue/20 overflow-hidden shadow-lg">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-dark-bg border-b border-primary-blue/20">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Teléfono</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Rol</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-primary-blue/10">
                            <tr v-for="user in users.data" :key="user.id" class="hover:bg-primary-blue/5 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img :src="`https://ui-avatars.com/api/?name=${user.name}&background=0ea5e9&color=fff&size=40`" alt="Avatar" class="w-10 h-10 rounded-full mr-3 ring-2 ring-primary-blue/50">
                                        <div>
                                            <div class="text-sm font-semibold text-white">{{ user.name }}</div>
                                            <div class="text-xs text-gray-400">ID: {{ user.id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">{{ user.email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">{{ user.phone || 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="['px-3 py-1 rounded-full text-xs font-bold text-white', getRoleBadgeClass(user.role.name)]">
                                        {{ user.role.name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    {{ new Date(user.created_at).toLocaleDateString('es-ES') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <Link :href="route('admin.users.edit', user.id)" 
                                            class="p-2 bg-primary-blue/20 hover:bg-primary-blue/40 text-primary-blue rounded-lg transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </Link>
                                        <button @click="deleteUser(user)" 
                                            class="p-2 bg-red-900/20 hover:bg-red-900/40 text-red-400 rounded-lg transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="users.data.length === 0">
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    No se encontraron usuarios
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div v-if="users.links.length > 3" class="bg-dark-bg px-6 py-4 border-t border-primary-blue/20 flex items-center justify-between">
                    <div class="text-sm text-gray-400">
                        Mostrando {{ users.from }} a {{ users.to }} de {{ users.total }} usuarios
                    </div>
                    <div class="flex gap-1">
                        <Link 
                            v-for="(link, index) in users.links" 
                            :key="index"
                            :href="link.url"
                            v-html="link.label"
                            :class="[
                                'px-3 py-2 rounded-md text-sm font-medium transition-all',
                                link.active 
                                    ? 'bg-primary-blue text-white' 
                                    : 'bg-dark-card text-gray-400 hover:bg-primary-blue/20 hover:text-white',
                                !link.url && 'opacity-50 cursor-not-allowed'
                            ]"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

