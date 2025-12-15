<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/UI/InputError.vue';
import InputLabel from '@/Components/UI/InputLabel.vue';
import PrimaryButton from '@/Components/UI/PrimaryButton.vue';
import TextInput from '@/Components/UI/TextInput.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    product: Object,
    categories: Array,
    brands: Array,
});

const form = useForm({
    name: props.product.name,
    sku: props.product.sku,
    brand_id: props.product.brand_id,
    category_id: props.product.category_id,
    price: props.product.price,
    stock: props.product.stock,
    description: props.product.description,
    is_active: props.product.is_active ? true : false,
    is_featured: props.product.is_featured ? true : false,
    new_images: [],
    specifications: props.product.specifications || [],
    images_to_delete: [],
});

// Gestión de nuevas imágenes
const newImagePreviews = ref([]);
const handleImageUpload = (event) => {
    const files = Array.from(event.target.files);
    files.forEach(file => {
        form.new_images.push(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            newImagePreviews.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });
};

const removeNewImage = (index) => {
    form.new_images.splice(index, 1);
    newImagePreviews.value.splice(index, 1);
};

const deleteExistingImage = (imageId) => {
    if (confirm('¿Estás seguro de eliminar esta imagen?')) {
        form.images_to_delete.push(imageId);
    }
};

// Gestión de especificaciones
const addSpecification = () => {
    form.specifications.push({ name: '', value: '' });
};

const removeSpecification = (index) => {
    form.specifications.splice(index, 1);
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: 'PUT'
    })).post(route('admin.products.update', props.product.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="Editar Producto" />

        <div class="py-6 px-4 sm:px-6 lg:px-8 bg-dark-bg min-h-screen">
            <div class="max-w-5xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-3xl font-lexend font-bold text-white">✏️ Editar Producto</h2>
                        <p class="text-gray-400 mt-1">{{ product.name }}</p>
                    </div>
                    <Link :href="route('admin.products.index')" 
                        class="px-4 py-2 bg-dark-card border border-primary-blue/20 text-gray-300 rounded-lg hover:bg-primary-blue/10 hover:text-white transition-all">
                        ← Volver al Listado
                    </Link>
                </div>

                <form @submit.prevent="submit" class="space-y-8">
                    <!-- Información Básica -->
                    <div class="bg-dark-card rounded-xl p-8 border border-primary-blue/20 shadow-lg">
                        <h3 class="text-xl font-lexend font-bold text-primary-blue mb-6">📋 Información Básica</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div class="col-span-2">
                                <InputLabel for="name" value="Nombre del Producto" class="text-gray-300" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- SKU -->
                            <div>
                                <InputLabel for="sku" value="SKU (Código Único)" class="text-gray-300" />
                                <TextInput
                                    id="sku"
                                    type="text"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.sku"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.sku" />
                            </div>

                            <!-- Precio -->
                            <div>
                                <InputLabel for="price" value="Precio (S/)" class="text-gray-300" />
                                <TextInput
                                    id="price"
                                    type="number"
                                    step="0.01"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.price"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.price" />
                            </div>

                            <!-- Categoría -->
                            <div>
                                <InputLabel for="category_id" value="Categoría" class="text-gray-300" />
                                <select
                                    id="category_id"
                                    class="mt-1 block w-full border-primary-blue/30 bg-dark-bg text-white focus:border-primary-blue focus:ring-primary-blue rounded-md shadow-sm"
                                    v-model="form.category_id"
                                    required
                                >
                                    <option value="">Seleccionar Categoría</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.category_id" />
                            </div>

                            <!-- Marca -->
                            <div>
                                <InputLabel for="brand_id" value="Marca" class="text-gray-300" />
                                <select
                                    id="brand_id"
                                    class="mt-1 block w-full border-primary-blue/30 bg-dark-bg text-white focus:border-primary-blue focus:ring-primary-blue rounded-md shadow-sm"
                                    v-model="form.brand_id"
                                    required
                                >
                                    <option value="">Seleccionar Marca</option>
                                    <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                        {{ brand.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.brand_id" />
                            </div>

                            <!-- Stock -->
                            <div>
                                <InputLabel for="stock" value="Stock Actual" class="text-gray-300" />
                                <TextInput
                                    id="stock"
                                    type="number"
                                    class="mt-1 block w-full bg-dark-bg border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                    v-model="form.stock"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.stock" />
                            </div>

                            <!-- Descripción -->
                            <div class="col-span-2">
                                <InputLabel for="description" value="Descripción Detallada" class="text-gray-300" />
                                <textarea
                                    id="description"
                                    class="mt-1 block w-full border-primary-blue/30 bg-dark-bg text-white focus:border-primary-blue focus:ring-primary-blue rounded-md shadow-sm"
                                    v-model="form.description"
                                    rows="5"
                                    required
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>
                        </div>
                    </div>

                    <!-- Imágenes del Producto -->
                    <div class="bg-dark-card rounded-xl p-8 border border-primary-blue/20 shadow-lg">
                        <h3 class="text-xl font-lexend font-bold text-primary-blue mb-6">🖼️ Galería de Imágenes</h3>
                        
                        <!-- Imágenes existentes -->
                        <div v-if="product.images && product.images.length > 0" class="mb-6">
                            <h4 class="text-lg font-semibold text-white mb-4">Imágenes Actuales</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div v-for="image in product.images.filter(img => !form.images_to_delete.includes(img.id))" :key="image.id" class="relative group">
                                    <img :src="image.image_path" class="w-full h-32 object-cover rounded-lg border border-primary-blue/20" />
                                    <button
                                        type="button"
                                        @click="deleteExistingImage(image.id)"
                                        class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <span v-if="image.is_primary" class="absolute bottom-2 left-2 bg-primary-blue text-white text-xs px-2 py-1 rounded">Principal</span>
                                </div>
                            </div>
                        </div>

                        <!-- Subir nuevas imágenes -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-white">Agregar Nuevas Imágenes</h4>
                            <div class="flex items-center justify-center w-full">
                                <label for="new_images" class="flex flex-col items-center justify-center w-full h-48 border-2 border-primary-blue/30 border-dashed rounded-lg cursor-pointer bg-dark-bg hover:bg-dark-bg/50 transition-all">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Click para subir</span> o arrastra y suelta</p>
                                        <p class="text-xs text-gray-500">PNG, JPG, WEBP (MAX. 5MB por imagen)</p>
                                    </div>
                                    <input id="new_images" type="file" class="hidden" @change="handleImageUpload" accept="image/*" multiple />
                                </label>
                            </div>

                            <!-- Vista previa de nuevas imágenes -->
                            <div v-if="newImagePreviews.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                                <div v-for="(preview, index) in newImagePreviews" :key="'new-' + index" class="relative group">
                                    <img :src="preview" class="w-full h-32 object-cover rounded-lg border border-green-500/50" />
                                    <button
                                        type="button"
                                        @click="removeNewImage(index)"
                                        class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <span class="absolute bottom-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded">Nuevo</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Especificaciones Técnicas -->
                    <div class="bg-dark-card rounded-xl p-8 border border-primary-blue/20 shadow-lg">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-lexend font-bold text-primary-blue">⚙️ Especificaciones Técnicas</h3>
                            <button
                                type="button"
                                @click="addSpecification"
                                class="px-4 py-2 bg-primary-blue hover:bg-blue-600 text-white rounded-lg transition-all font-semibold text-sm"
                            >
                                + Agregar Especificación
                            </button>
                        </div>

                        <div v-if="form.specifications.length === 0" class="text-center py-8 text-gray-500">
                            No hay especificaciones agregadas. Haz clic en el botón para agregar.
                        </div>

                        <div v-else class="space-y-4">
                            <div v-for="(spec, index) in form.specifications" :key="index" 
                                class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end bg-dark-bg p-4 rounded-lg border border-primary-blue/10">
                                <div>
                                    <InputLabel :for="'spec_name_' + index" value="Nombre" class="text-gray-300" />
                                    <TextInput
                                        :id="'spec_name_' + index"
                                        type="text"
                                        class="mt-1 block w-full bg-dark-card border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                        v-model="spec.name"
                                        placeholder="Ej: Socket, Núcleos, Frecuencia"
                                    />
                                </div>
                                <div>
                                    <InputLabel :for="'spec_value_' + index" value="Valor" class="text-gray-300" />
                                    <div class="flex gap-2">
                                        <TextInput
                                            :id="'spec_value_' + index"
                                            type="text"
                                            class="mt-1 block w-full bg-dark-card border-primary-blue/30 text-white focus:border-primary-blue focus:ring-primary-blue"
                                            v-model="spec.value"
                                            placeholder="Ej: AM5, 16, 5.7 GHz"
                                        />
                                        <button
                                            type="button"
                                            @click="removeSpecification(index)"
                                            class="mt-1 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Opciones del Producto -->
                    <div class="bg-dark-card rounded-xl p-8 border border-primary-blue/20 shadow-lg">
                        <h3 class="text-xl font-lexend font-bold text-primary-blue mb-6">🎯 Opciones de Publicación</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label class="flex items-center p-6 border-2 border-primary-blue/20 rounded-lg bg-dark-bg hover:border-primary-blue/50 cursor-pointer transition-all group">
                                <input type="checkbox" v-model="form.is_active" class="rounded bg-dark-card border-primary-blue/30 text-primary-blue shadow-sm focus:ring-primary-blue w-5 h-5" />
                                <div class="ml-4">
                                    <span class="block text-lg font-semibold text-white group-hover:text-primary-blue transition-colors">✅ Producto Activo</span>
                                    <span class="text-sm text-gray-400">Visible en la tienda para clientes</span>
                                </div>
                            </label>

                            <label class="flex items-center p-6 border-2 border-accent-purple/20 rounded-lg bg-dark-bg hover:border-accent-purple/50 cursor-pointer transition-all group">
                                <input type="checkbox" v-model="form.is_featured" class="rounded bg-dark-card border-accent-purple/30 text-accent-purple shadow-sm focus:ring-accent-purple w-5 h-5" />
                                <div class="ml-4">
                                    <span class="block text-lg font-semibold text-white group-hover:text-accent-purple transition-colors">⭐ Producto Destacado</span>
                                    <span class="text-sm text-gray-400">Aparecerá en la página principal</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex items-center justify-end gap-4 bg-dark-card rounded-xl p-6 border border-primary-blue/20">
                        <Link :href="route('admin.products.index')" 
                            class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all">
                            Cancelar
                        </Link>
                        <PrimaryButton 
                            class="px-8 py-3 bg-primary-blue hover:bg-blue-600 text-white font-bold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-primary-blue/50" 
                            :class="{ 'opacity-25': form.processing }" 
                            :disabled="form.processing">
                            💾 Actualizar Producto
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

