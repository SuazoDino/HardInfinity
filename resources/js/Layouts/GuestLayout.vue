<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-[#0B0E14] text-gray-100 flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Grid Pattern (Sutil y Tecnológico) -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        
        <!-- Ambient Glows (Más suaves) -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-brand-500/20 rounded-full blur-[128px] pointer-events-none opacity-50"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-[128px] pointer-events-none opacity-50"></div>

        <!-- Logo -->
        <div class="mb-8 relative z-10">
            <Link :href="route('home')" class="group block">
                <h1 class="text-4xl font-display font-bold tracking-tight flex items-center gap-2">
                    <div class="bg-brand-600 p-2 rounded-lg transform group-hover:rotate-12 transition-transform shadow-lg shadow-brand-500/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-white">Hard</span><span class="text-brand-400">Infinity</span>
                </h1>
            </Link>
        </div>

        <!-- Card -->
        <div class="w-full sm:max-w-xl bg-[#151A23] border border-white/5 shadow-2xl rounded-2xl p-8 sm:p-10 relative z-10 backdrop-blur-sm shadow-brand-500/5">
            <slot />
        </div>
    </div>
</template>
