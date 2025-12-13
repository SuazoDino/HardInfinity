<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/UI/InputLabel.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import InputError from '@/Components/UI/InputError.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('profile.password'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <ProfileLayout>
        <Head title="Seguridad" />

        <div class="max-w-2xl">
            <h1 class="text-2xl font-bold text-white mb-2">Seguridad</h1>
            <p class="text-gray-400 text-sm mb-8">Asegura tu cuenta con una contraseña fuerte.</p>

            <form @submit.prevent="submit" class="space-y-6 bg-[#151A23] p-8 rounded-xl border border-white/5">
                <div>
                    <InputLabel for="current_password" value="Contraseña Actual" class="text-gray-300" />
                    <TextInput
                        id="current_password"
                        v-model="form.current_password"
                        type="password"
                        class="mt-1 block w-full bg-[#0B0E14]"
                        autocomplete="current-password"
                    />
                    <InputError :message="form.errors.current_password" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="password" value="Nueva Contraseña" class="text-gray-300" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full bg-[#0B0E14]"
                        autocomplete="new-password"
                    />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="password_confirmation" value="Confirmar Nueva Contraseña" class="text-gray-300" />
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1 block w-full bg-[#0B0E14]"
                        autocomplete="new-password"
                    />
                    <InputError :message="form.errors.password_confirmation" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing">Actualizar Contraseña</PrimaryButton>
                    <p v-if="form.recentlySuccessful" class="text-sm text-green-400">Actualizado.</p>
                </div>
            </form>
        </div>
    </ProfileLayout>
</template>

