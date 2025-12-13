<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/UI/InputLabel.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import InputError from '@/Components/UI/InputError.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone,
});

const submit = () => {
    form.patch(route('profile.update'));
};
</script>

<template>
    <ProfileLayout>
        <Head title="Mi Perfil" />

        <div class="max-w-2xl">
            <h1 class="text-2xl font-bold text-white mb-2">Información Personal</h1>
            <p class="text-gray-400 text-sm mb-8">Actualiza tu información de contacto.</p>

            <form @submit.prevent="submit" class="space-y-6 bg-[#151A23] p-8 rounded-xl border border-white/5">
                <div>
                    <InputLabel for="name" value="Nombre Completo" class="text-gray-300" />
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full bg-[#0B0E14]"
                        required
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="email" value="Correo Electrónico" class="text-gray-300" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full bg-[#0B0E14]"
                        required
                    />
                    <InputError :message="form.errors.email" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="phone" value="Teléfono" class="text-gray-300" />
                    <TextInput
                        id="phone"
                        v-model="form.phone"
                        type="tel"
                        class="mt-1 block w-full bg-[#0B0E14]"
                    />
                    <InputError :message="form.errors.phone" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing">Guardar Cambios</PrimaryButton>
                    <p v-if="form.recentlySuccessful" class="text-sm text-green-400">Guardado.</p>
                </div>
            </form>
        </div>
    </ProfileLayout>
</template>

