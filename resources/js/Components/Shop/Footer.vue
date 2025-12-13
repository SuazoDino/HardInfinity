<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="bg-gray-900 border-t border-gray-800 text-gray-400">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Sobre nosotros -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">
                        <span class="text-blue-500">Hard</span>Infinity
                    </h3>
                    <p class="text-sm">
                        Tu tienda especializada en hardware de alto rendimiento. Los mejores componentes para tu PC Gaming o Workstation.
                    </p>
                </div>

                <!-- Enlaces rápidos -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2 text-sm">
                        <li><Link href="#" class="hover:text-white transition-colors">Productos</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Categorías</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Ofertas</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Nosotros</Link></li>
                    </ul>
                </div>

                <!-- Soporte -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Soporte</h4>
                    <ul class="space-y-2 text-sm">
                        <li><Link href="#" class="hover:text-white transition-colors">Centro de Ayuda</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Garantías</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Envíos</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Contacto</Link></li>
                    </ul>
                </div>

                <!-- Métodos de pago -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Métodos de Pago</h4>
                    <div class="flex flex-wrap gap-3">
                        <div class="px-3 py-2 bg-gray-800 rounded text-xs">💳 Visa</div>
                        <div class="px-3 py-2 bg-gray-800 rounded text-xs">💳 Mastercard</div>
                        <div class="px-3 py-2 bg-gray-800 rounded text-xs">📱 Yape</div>
                        <div class="px-3 py-2 bg-gray-800 rounded text-xs">📱 Plin</div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                <p>&copy; 2025 HardInfinity. Todos los derechos reservados. Hecho en Perú 🇵🇪</p>
            </div>
        </div>
    </footer>
</template>

