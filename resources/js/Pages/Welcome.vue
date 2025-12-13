<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <div class="container mx-auto px-4 py-16">
            <!-- Header -->
            <div class="text-center mb-16">
                <h1 class="text-6xl font-bold text-white mb-4">
                    <span class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
                        Hard
                    </span>
                    <span class="text-white">Infinity</span>
                </h1>
                <p class="text-xl text-gray-300 mb-8">
                    Tu tienda especializada en hardware de alto rendimiento
                </p>
                
                <div class="flex justify-center space-x-4">
                    <a href="/login" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-500 transition-colors">
                        Iniciar Sesión
                    </a>
                    <a href="/register" class="px-6 py-3 bg-gray-700 text-white font-semibold rounded-lg hover:bg-gray-600 transition-colors border border-gray-600">
                        Registrarse
                    </a>
                </div>
            </div>

            <!-- Status Cards -->
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <!-- Laravel Status -->
                <div class="bg-gray-800 rounded-xl p-6 shadow-2xl border border-gray-700 hover:border-blue-500 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-white font-semibold text-lg">Laravel</h3>
                        <span class="px-3 py-1 bg-green-500 text-white text-xs rounded-full">✓ Activo</span>
                    </div>
                    <p class="text-gray-400 text-sm">Framework backend funcionando correctamente</p>
                </div>

                <!-- Vue Status -->
                <div class="bg-gray-800 rounded-xl p-6 shadow-2xl border border-gray-700 hover:border-green-500 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-white font-semibold text-lg">Vue 3</h3>
                        <span class="px-3 py-1 bg-green-500 text-white text-xs rounded-full">✓ Activo</span>
                    </div>
                    <p class="text-gray-400 text-sm">Framework frontend reactivo funcionando</p>
                </div>

                <!-- Inertia Status -->
                <div class="bg-gray-800 rounded-xl p-6 shadow-2xl border border-gray-700 hover:border-purple-500 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-white font-semibold text-lg">Inertia.js</h3>
                        <span class="px-3 py-1 bg-green-500 text-white text-xs rounded-full">✓ Activo</span>
                    </div>
                    <p class="text-gray-400 text-sm">SPA sin API REST funcionando perfectamente</p>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gray-800/50 backdrop-blur rounded-lg p-6 border border-gray-700">
                    <div class="text-blue-400 text-3xl mb-3">🚀</div>
                    <h4 class="text-white font-semibold mb-2">Configuración Base</h4>
                    <p class="text-gray-400 text-sm">Laravel + Vue + Inertia</p>
                </div>

                <div class="bg-gray-800/50 backdrop-blur rounded-lg p-6 border border-gray-700">
                    <div class="text-green-400 text-3xl mb-3">🎨</div>
                    <h4 class="text-white font-semibold mb-2">TailwindCSS</h4>
                    <p class="text-gray-400 text-sm">Diseño moderno y responsivo</p>
                </div>

                <div class="bg-gray-800/50 backdrop-blur rounded-lg p-6 border border-gray-700">
                    <div class="text-purple-400 text-3xl mb-3">🗄️</div>
                    <h4 class="text-white font-semibold mb-2">PostgreSQL</h4>
                    <p class="text-gray-400 text-sm">Base de datos configurada</p>
                </div>

                <div class="bg-gray-800/50 backdrop-blur rounded-lg p-6 border border-gray-700">
                    <div class="text-yellow-400 text-3xl mb-3">⚡</div>
                    <h4 class="text-white font-semibold mb-2">Vite</h4>
                    <p class="text-gray-400 text-sm">Build tool ultrarrápido</p>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="mt-16 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl p-8 text-center">
                <h3 class="text-2xl font-bold text-white mb-4">
                    ¡Sistema Listo! 🎉
                </h3>
                <p class="text-blue-100 mb-6">
                    Fase 1 completada. Siguiente paso: Crear las migraciones de base de datos
                </p>
                <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur px-4 py-2 rounded-lg">
                    <span class="text-white font-mono text-sm">{{ laravelVersion }}</span>
                    <span class="text-blue-200">+</span>
                    <span class="text-white font-mono text-sm">Vue 3</span>
                    <span class="text-blue-200">+</span>
                    <span class="text-white font-mono text-sm">PostgreSQL</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

defineProps({
    laravelVersion: String,
});
</script>

