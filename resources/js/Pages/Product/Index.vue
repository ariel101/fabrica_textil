<template>
    <Welcome>
        <!-- <NavBarCategories @categoriaSeleccionada="filtrarPorCategoria" /> -->
         <NavBarCategories
            :categorias="categories"
            :selectedCategory="selectedCategory"
            @categoriaSeleccionada="filtrarPorCategoria"
        />
        <section class="p-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- <div v-if="products.length === 0" class="col-span-full text-center text-gray-500 text-lg mt-10">
                No se encontraron productos para "{{ filters?.search }}"
            </div> -->

            <div v-if="filters?.search" class="col-span-full text-center text-gray-500 text-lg mt-10">
                <span v-if="products.length > 0">
                    Resultados para: "<span class="font-semibold">{{ filters.search }}</span>"
                </span>
                <span v-else>
                    No se encontraron productos para: "<span class="font-semibold">{{ filters.search }}</span>"
                </span>
            </div>

            <div v-for="product in products" :key="product.id"
                class="border rounded-lg p-4 shadow hover:shadow-md transition">
                <a :href="route('products.showHome', product.id)">
                    <img v-if="product.images.length" :src="`/${product.images[0].path}`" alt="Imagen del producto"
                        class="h-40 w-full object-cover mb-2" />
                    <div v-else class="h-40 w-full bg-gray-200 flex items-center justify-center text-gray-400 mb-2">
                        Sin imagen
                    </div>
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
import Welcome from '@/Pages/Welcome.vue'
import '@fortawesome/fontawesome-free/css/all.min.css'
import NavBarCategories from '@/Components/Inicio/NavBarCategories.vue';
import { router } from '@inertiajs/vue3';

//const { products } = usePage().props

defineProps({
    products: Array,
    filters: Object,
    selectedCategory: [Number, null],
    categories: Array,
});

const filtrarPorCategoria = (id) => {
    if (id === null) {
        
        //router.get('/category')
        router.get(route('products.indexHome')); // Muestra todos los productos
        //router.get('products.indexHome'); // Muestra todos los productos
    } else {
        //router.get(route('products.filtrarPorCategoria', id)); // Filtra por categoría específica
        router.get('/category/' + id);
    }
};

</script>
