<template>
    <Welcome>
        <section class="p-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div v-for="product in products" :key="product.id"
                class="border rounded-lg p-4 shadow hover:shadow-md transition">
                <a :href="route('products.show', product.id)">
                    <img :src="'/' + product.image_path" alt="" class="h-40 w-full object-cover mb-2" />
                </a>
                <h3 class="text-lg font-semibold">{{ product.name }}</h3>
                <!-- <p class="text-gray-600">descripcion</p> -->
                <p class="text-green-600 font-bold mt-2">{{ product.price }} BOB</p>
            </div>
        </section>
    </Welcome>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
//import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Pages/Welcome.vue'
import '@fortawesome/fontawesome-free/css/all.min.css'
const { products } = usePage().props
</script>