<template>
    <Welcome :showFooter="false" :showCategories="false">
        <section class="p-6 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Imagen del producto -->
                <div class="flex items-center justify-center bg-gray-100">
                    <button @click="prevImage"
                        class="absolute left-4 bg-white p-2 rounded-full shadow hover:bg-gray-200">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <img :src="`/${product.images[currentImageIndex]?.path}`" alt="Imagen del producto"
                        class="object-cover w-full h-72 transition-all duration-300 ease-in-out" />

                    <button @click="nextImage"
                        class="absolute right-4 bg-white p-2 rounded-full shadow hover:bg-gray-200">
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

                    <!-- Botón + Cantidad en una fila -->
                    <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between md:gap-6">
                        <!-- Botón añadir -->
                        <button @click="addToCart(product.id)"
                            class="w-full md:w-58 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition duration-300 ease-in-out shadow-md">
                            <i class="fa-solid fa-cart-shopping mr-2"></i> Añadir al carrito
                        </button>

                        <!-- Cantidad personalizada alineada a la derecha -->
                        <div class="mt-4 md:mt-0 flex items-center gap-2">
                            <label for="quantity" class="text-gray-700 font-semibold">Cant:</label>
                            <input id="quantity" type="number" v-model.number="quantity" min="1" :max="product.stock"
                                class="w-28 px-4 py-2 rounded-xl bg-blue-50 border border-blue-200 text-gray-800 text-lg shadow-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" />
                        </div>
                    </div>

                </div>

            </div>
            <!-- Miniaturas -->
            <div class="mt-4 flex flex-wrap justify-center gap-2 px-4">
                <img v-for="(img, index) in product.images" :key="index" :src="`/${img.path}`"
                    @click="currentImageIndex = index"
                    class="w-16 h-16 object-cover border-2 rounded-md cursor-pointer transition duration-200" :class="{
                        'border-blue-500': index === currentImageIndex,
                        'opacity-70 hover:opacity-100': index !== currentImageIndex
                    }" />
            </div>
        </section>
        <!-- Toast de éxito (barra superior con progreso) -->
        <div v-if="showToast"
            class="fixed top-6 left-1/2 transform -translate-x-1/2 w-[90%] md:w-[400px] bg-green-500 text-white font-medium px-6 py-3 rounded-xl shadow-lg z-50 transition-all duration-300">
            <p>Producto añadido al carrito</p>
            <div class="h-1 bg-green-700 mt-2 rounded">
                <div class="h-full bg-white rounded animate-progress-bar"></div>
            </div>
        </div>

    </Welcome>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import Welcome from '@/Pages/Welcome.vue'
import '@fortawesome/fontawesome-free/css/all.min.css'
import { ref, defineEmits } from 'vue'
import axios from 'axios'
import emitter from '@/utils/eventBus.js'

const currentImageIndex = ref(0)

const showToast = ref(false)

const nextImage = () => {
    if (product.images.length === 0) return
    currentImageIndex.value = (currentImageIndex.value + 1) % product.images.length
}

const prevImage = () => {
    if (product.images.length === 0) return
    currentImageIndex.value = (currentImageIndex.value - 1 + product.images.length) % product.images.length
}

const { product } = usePage().props

const quantity = ref(1) // Nueva cantidad seleccionada

const addToCart = (productId) => {
    if (quantity.value < 1 || quantity.value > product.stock) {
        alert(`Por favor, selecciona una cantidad entre 1 y ${product.stock}`)
        return
    }

    const storedCart = JSON.parse(localStorage.getItem('cart')) || []
    const index = storedCart.findIndex(item => item.id === product.id)

    if (index !== -1) {
        const newQty = storedCart[index].quantity + quantity.value
        storedCart[index].quantity = Math.min(newQty, product.stock) // No permitir exceder el stock
    } else {
        storedCart.push({
            id: product.id,
            name: product.name,
            price: parseFloat(product.price),
            quantity: quantity.value,
            image: product.images[0]?.path || '',
        })
    }

    localStorage.setItem('cart', JSON.stringify(storedCart))

    emitter.emit('update-cart', storedCart.reduce((sum, i) => sum + i.quantity, 0))

    console.log("Producto agregado al carrito (localStorage):", storedCart)

    // Mostrar toast
    showToast.value = true
    setTimeout(() => {
        showToast.value = false
    }, 2500)
}




</script>

<style>
@keyframes progressBar {
    from {
        width: 0%;
    }

    to {
        width: 100%;
    }
}

.animate-progress-bar {
    animation: progressBar 2.5s linear forwards;
}
</style>
