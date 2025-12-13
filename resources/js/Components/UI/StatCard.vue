<script setup>
defineProps({
    title: String,
    value: [String, Number],
    icon: String,
    color: {
        type: String,
        default: 'blue'
    }
});

const colorClasses = {
    blue: 'bg-blue-500',
    green: 'bg-green-500',
    red: 'bg-red-500',
    yellow: 'bg-yellow-500',
    purple: 'bg-purple-500',
};
</script>

<template>
    <div class="bg-gray-800 rounded-lg shadow-lg border border-gray-700 p-6 flex items-center">
        <div class="p-3 rounded-full bg-opacity-20 mr-4" :class="[`bg-${color}-500`, `text-${color}-400`]">
            <span class="text-2xl">{{ icon }}</span>
        </div>
        <div>
            <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">{{ title }}</p>
            <p class="text-2xl font-bold text-white">{{ value }}</p>
        </div>
    </div>
</template>

