<script setup>
import Navbar from '@/Components/Shop/Navbar.vue';
import Footer from '@/Components/Shop/Footer.vue';
import Toast from '@/Components/UI/Toast.vue';
import { usePage } from '@inertiajs/vue3';
import { ref, watch, onMounted, computed } from 'vue';

const page = usePage();
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref('success');

// Computed para detectar cambios en flash messages
const flashSuccess = computed(() => page.props.flash.success);
const flashError = computed(() => page.props.flash.error);

const triggerToast = () => {
    if (flashSuccess.value) {
        toastMessage.value = flashSuccess.value;
        toastType.value = 'success';
        showToast.value = true;
    } else if (flashError.value) {
        toastMessage.value = flashError.value;
        toastType.value = 'error';
        showToast.value = true;
    }
};

watch([flashSuccess, flashError], () => {
    showToast.value = false; // Reset
    setTimeout(() => {
        triggerToast();
    }, 100);
});

onMounted(() => {
    triggerToast();
});
</script>

<template>
    <div class="min-h-screen bg-dark-bg flex flex-col pt-20">
        <Navbar :auth="page.props.auth" />
        
        <Toast 
            :show="showToast" 
            :message="toastMessage" 
            :type="toastType"
            @close="showToast = false" 
        />

        <main class="flex-1">
            <slot />
        </main>

        <Footer />
    </div>
</template>
