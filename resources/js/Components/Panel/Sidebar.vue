<template>
    <!-- Sidebar -->
    <div :class="[
        'px-5 w-64 mr-2 text-slate-900 text-left flex flex-col h-full bg-gray-200 transition-all duration-300 fixed lg:relative z-40',
        sidebarOpen || windowWidth >= 1024 ? 'left-0' : '-left-64',
    ]">
        <!-- Header del sidebar -->
        <div class="p-6 text-lg text-green-800 font-semibold text-center border-b border-gray-700">
            MULTITEX S.R.L.
        </div>

        <!-- Opciones de navegación -->
        <nav class="flex-1 p-4">
            <InertiaLink :href="route('dashboard')" :class="linkClass('/dashboard')">
                <i class="fas fa-home mr-2"></i>Dashboard
            </InertiaLink>

            <InertiaLink :href="route('clients.index')" :class="linkClass('/clients')">
                <i class="fas fa-users mr-2"></i>Clientes
            </InertiaLink>

            <InertiaLink href="#" :class="linkClass('/pedidos')">
                <i class="fas fa-box mr-2"></i>Pedidos
            </InertiaLink>

            <InertiaLink :href="route('products.index')" :class="linkClass('/products')">
                <i class="fas fa-shopping-cart mr-2"></i>Productos
            </InertiaLink>

            <InertiaLink :href="route('categories.index')" :class="linkClass('/categories')">
                <i class="fas fa-tags mr-2"></i>Categorías
            </InertiaLink>

            <InertiaLink href="#" :class="linkClass('/reportes')">
                <i class="fas fa-file-alt mr-2"></i>Reportes
            </InertiaLink>

        </nav>

        <!-- Usuario y Logout -->
        <!-- <div class="p-4 border-t border-gray-700">
        <div class="flex items-center">
          <img src="" alt="">
          <span class="ml-4">jose maria</span>
          <inertia-link href="/logout" class="ml-auto">
            <i class="fas fa-sign-out-alt text-black"></i>cerrar sesion
          </inertia-link>
        </div>
      </div> -->
    </div>

    <!-- Botón de menú para pantallas pequeñas -->
    <button @click="toggleSidebar" class="lg:hidden fixed top-4 left-4 text-gray-500 z-50">
        <i class="fas fa-bars text-2xl"></i>
    </button>
</template>

<script setup>
import { Link as InertiaLink, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'

const sidebarOpen = ref(false)
const windowWidth = ref(window.innerWidth)

function toggleSidebar() {
    sidebarOpen.value = !sidebarOpen.value
}

function updateWindowWidth() {
    windowWidth.value = window.innerWidth
}

onMounted(() => {
    window.addEventListener('resize', updateWindowWidth)
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', updateWindowWidth)
})

const currentRoute = computed(() => usePage().url)

const linkClass = (path) => {
    return [
        'block py-2 px-4 rounded-full mb-4 transition-all',
        currentRoute.value.startsWith(path)
            ? 'bg-green-600 text-white font-semibold shadow'
            : 'hover:bg-gray-700 hover:text-white'
    ]
}

</script>

<style scoped></style>
