<script setup>
import { onMounted, ref, watch } from 'vue';

const props = defineProps({
    message: String,
    type: {
        type: String,
        default: 'success'
    },
    show: Boolean
});

const emit = defineEmits(['close']);

onMounted(() => {
    if (props.show) {
        setTimeout(() => {
            emit('close');
        }, 3000);
    }
});

watch(() => props.show, (newVal) => {
    if (newVal) {
        setTimeout(() => {
            emit('close');
        }, 3000);
    }
});
</script>

<template>
    <Transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="show" class="fixed top-24 right-4 z-[60] max-w-sm w-full bg-[#151A23] border border-white/10 shadow-2xl rounded-xl pointer-events-auto overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <!-- Success Icon -->
                        <svg v-if="type === 'success'" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <!-- Error Icon -->
                        <svg v-else class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-bold text-white">{{ type === 'success' ? '¡Éxito!' : 'Error' }}</p>
                        <p class="mt-1 text-sm text-gray-400">{{ message }}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="emit('close')" class="bg-transparent rounded-md inline-flex text-gray-400 hover:text-gray-200 focus:outline-none">
                            <span class="sr-only">Cerrar</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Progress bar -->
            <div class="h-1 w-full bg-gray-700">
                <div class="h-full transition-all duration-[3000ms] ease-linear w-0" 
                     :class="[type === 'success' ? 'bg-green-500' : 'bg-red-500', show ? 'w-full' : 'w-0']">
                </div>
            </div>
        </div>
    </Transition>
</template>

