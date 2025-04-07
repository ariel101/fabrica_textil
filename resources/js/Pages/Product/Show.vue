<template>
    <Welcome>
        <section class="p-6 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Imagen del producto -->
                <div class="flex items-center justify-center bg-gray-100">
                    <img :src="'/' + product.image_path" alt="Producto"
                         class="object-contain h-[400px] w-full p-4 transition-transform duration-300 hover:scale-105" />
                </div>

                <!-- Detalles del producto -->
                <div class="p-8 flex flex-col justify-center">
                    <h1 class="text-4xl font-extrabold text-gray-800 mb-4">{{ product.name }}</h1>
                    <p class="text-gray-600 text-lg leading-relaxed">{{ product.description }}</p>

                    <div class="mt-6">
                        <p class="text-2xl text-green-600 font-bold">Precio: {{ product.price }} BOB</p>
                        <p class="text-blue-600 text-lg mt-2">Disponibles: {{ product.stock }}</p>
                    </div>

                    <button
                        class="mt-8 w-full md:w-auto px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition duration-300 ease-in-out shadow-md">
                        <i class="fa-solid fa-cart-shopping mr-2"></i> Añadir al carrito
                    </button>
                </div>
            </div>
        </section>
    </Welcome>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import Welcome from '@/Pages/Welcome.vue'
import '@fortawesome/fontawesome-free/css/all.min.css'

const { product } = usePage().props
</script>
