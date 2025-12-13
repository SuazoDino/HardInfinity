<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    active: Boolean,
    href: String,
});
</script>

<template>
    <Link
        :href="href"
        class="flex items-center px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-colors duration-200 border-l-4"
        :class="active ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent'"
    >
        <slot />
    </Link>
</template>

