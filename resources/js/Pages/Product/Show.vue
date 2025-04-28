<template>
    <Welcome>
        <section class="p-6 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Imagen del producto -->
                <div class="flex items-center justify-center bg-gray-100">
                    <button @click="prevImage"
                        class="absolute left-4 bg-white p-2 rounded-full shadow hover:bg-gray-200"
                        :disabled="currentImageIndex === 0">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <img :src="`/${product.images[currentImageIndex]?.path}`" alt="Imagen del producto"
                        class="object-cover w-full h-72 transition-all duration-300 ease-in-out" />

                    <button @click="nextImage"
                        class="absolute right-4 bg-white p-2 rounded-full shadow hover:bg-gray-200"
                        :disabled="currentImageIndex === product.images.length - 1">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Detalles del producto -->
                <div class="p-8 flex flex-col justify-center">
                    <h1 class="text-4xl font-extrabold text-gray-800 mb-4">{{ product.name }}</h1>
                    <p class="text-gray-600 text-lg leading-relaxed">{{ product.description }}</p>

                    <div class="mt-6">
                        <p class="text-2xl text-green-600 font-bold">Precio: {{ product.price }} BOB</p>
                        <p class="text-blue-600 text-lg mt-2">Disponibles: {{ product.stock }}</p>
                    </div>

                    <button @click="addToCart(product.id)"
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
import { ref, defineEmits } from 'vue'
import axios from 'axios'
import emitter from '@/utils/eventBus.js'

const cartCount = ref(0) // Estado local del carrito
const currentImageIndex = ref(0)

const nextImage = () => {
    if (currentImageIndex.value < product.images.length - 1) {
        currentImageIndex.value++
    }
}

const prevImage = () => {
    if (currentImageIndex.value > 0) {
        currentImageIndex.value--
    }
}
const { product } = usePage().props

const addToCart = async (productId) => {
    try {
        console.log("Enviando al controlador:", { product_id: productId }); // 🔍 Ver datos antes de enviar

        const response = await axios.post('/cart/add', {
            product_id: productId
        });

        cartCount.value += 1; // Incrementar el contador del carrito
        // Emitimos el evento para que Navbar lo reciba
        emitter.emit('update-cart', cartCount.value);

        console.log("Respuesta del servidor:", response.data);
    } catch (error) {
        console.error("Error al agregar al carrito:", error);
    }
};


</script>
