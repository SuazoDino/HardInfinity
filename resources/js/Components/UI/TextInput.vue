<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    type: {
        type: String,
        default: 'text',
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        :type="type"
        class="border-gray-300 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full transition-colors duration-200"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    />
</template>

