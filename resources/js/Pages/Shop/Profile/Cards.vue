<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import InputError from '@/Components/UI/InputError.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';

const props = defineProps({
    cards: Array,
});

const showForm = ref(false);

const form = useForm({
    number: '',
    holder_name: '',
    exp_month: '',
    exp_year: '',
    cvv: '',
});

// Detectar marca visualmente
const cardBrand = computed(() => {
    if (!form.number) return null;
    if (form.number.startsWith('4')) return 'Visa';
    if (form.number.startsWith('5')) return 'Mastercard';
    if (form.number.startsWith('3')) return 'Amex';
    return 'Desconocida';
});

const submit = () => {
    form.post(route('profile.cards.store'), {
        onSuccess: () => {
            form.reset();
            showForm.value = false;
        },
    });
};

const deleteCard = (id) => {
    if (confirm('¿Estás seguro de eliminar esta tarjeta?')) {
        router.delete(route('profile.cards.destroy', id));
    }
};

const formatCardNumber = (event) => {
    let value = event.target.value.replace(/\D/g, '');
    if (value.length > 16) value = value.slice(0, 16);
    // Agrupar de 4 en 4 solo visualmente si se quisiera, pero para el input simple basta con limpiar
    // form.number = value; // Esto es simple, mejor dejamos el input normal
};
</script>

<template>
    <ProfileLayout>
        <Head title="Mis Tarjetas" />

        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white mb-2">Mis Tarjetas</h1>
                <p class="text-gray-400 text-sm">Gestiona tus métodos de pago guardados.</p>
            </div>
            <button @click="showForm = !showForm" class="px-4 py-2 bg-brand-600 text-white rounded-lg text-sm font-bold hover:bg-brand-500 transition-colors">
                {{ showForm ? 'Cancelar' : '+ Nueva Tarjeta' }}
            </button>
        </div>

        <!-- Formulario Nueva Tarjeta -->
        <div v-if="showForm" class="mb-8 bg-[#151A23] p-6 rounded-xl border border-white/5 animate-in fade-in slide-in-from-top-4">
            <h3 class="text-white font-bold mb-4">Agregar Nueva Tarjeta</h3>
            <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2 relative">
                    <InputLabel value="Número de Tarjeta" class="text-gray-300" />
                    <TextInput 
                        v-model="form.number" 
                        type="text" 
                        class="mt-1 w-full bg-[#0B0E14] pl-12" 
                        placeholder="0000 0000 0000 0000"
                        maxlength="19"
                        required 
                    />
                    <div class="absolute left-3 top-[34px] text-xl">
                        <span v-if="cardBrand === 'Visa'">🔵</span> <!-- Icono simple -->
                        <span v-else-if="cardBrand === 'Mastercard'">🔴</span>
                        <span v-else>💳</span>
                    </div>
                    <InputError :message="form.errors.number" />
                </div>
                
                <div class="md:col-span-2">
                    <InputLabel value="Nombre del Titular" class="text-gray-300" />
                    <TextInput v-model="form.holder_name" type="text" class="mt-1 w-full bg-[#0B0E14] uppercase" placeholder="COMO APARECE EN LA TARJETA" required />
                    <InputError :message="form.errors.holder_name" />
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <InputLabel value="Exp. Mes" class="text-gray-300" />
                        <TextInput v-model="form.exp_month" type="text" class="mt-1 w-full bg-[#0B0E14]" placeholder="MM" maxlength="2" required />
                        <InputError :message="form.errors.exp_month" />
                    </div>
                    <div class="flex-1">
                        <InputLabel value="Exp. Año" class="text-gray-300" />
                        <TextInput v-model="form.exp_year" type="text" class="mt-1 w-full bg-[#0B0E14]" placeholder="YY" maxlength="2" required />
                        <InputError :message="form.errors.exp_year" />
                    </div>
                </div>

                <div>
                    <InputLabel value="CVV" class="text-gray-300" />
                    <TextInput v-model="form.cvv" type="password" class="mt-1 w-full bg-[#0B0E14]" placeholder="123" maxlength="4" required />
                    <InputError :message="form.errors.cvv" />
                </div>

                <div class="md:col-span-2 flex justify-end mt-2">
                    <PrimaryButton :disabled="form.processing">Guardar Tarjeta</PrimaryButton>
                </div>
            </form>
        </div>

        <!-- Lista de Tarjetas -->
        <div v-if="cards.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="card in cards" :key="card.id" 
                class="relative h-48 rounded-xl p-6 text-white shadow-lg transition-transform hover:-translate-y-1"
                :class="card.brand === 'Visa' ? 'bg-gradient-to-br from-blue-900 to-blue-600' : 'bg-gradient-to-br from-gray-900 to-gray-700'"
            >
                <div class="absolute top-4 right-4 z-10 opacity-0 hover:opacity-100 transition-opacity">
                    <button @click="deleteCard(card.id)" class="text-white/80 hover:text-white bg-black/20 p-1 rounded">✕</button>
                </div>

                <div class="flex justify-between items-start h-full flex-col">
                    <div class="flex justify-between w-full items-center">
                        <span class="font-bold text-lg italic opacity-80">
                             {{ card.brand === 'Visa' ? 'VISA' : 'Mastercard' }}
                        </span>
                        <span class="text-2xl opacity-50">💳</span>
                    </div>

                    <div class="text-2xl tracking-widest font-mono my-4">
                        •••• •••• •••• {{ card.last_four }}
                    </div>

                    <div class="flex justify-between w-full text-xs uppercase tracking-wider opacity-80">
                        <div>
                            <span class="block text-[10px] opacity-60">Titular</span>
                            {{ card.holder_name }}
                        </div>
                        <div>
                            <span class="block text-[10px] opacity-60">Expira</span>
                            {{ card.exp_month }}/{{ card.exp_year }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else-if="!showForm" class="text-center py-12 border-2 border-dashed border-white/5 rounded-xl">
            <p class="text-gray-500">No tienes tarjetas guardadas.</p>
        </div>
    </ProfileLayout>
</template>

