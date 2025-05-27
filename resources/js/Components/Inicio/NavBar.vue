<script setup>
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import emitter from '@/utils/eventBus';
import { onMounted } from 'vue';

// Props
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    auth: {
        type: Object,
    },
    laravelVersion: {
        type: String,
        required: false,
    },
    phpVersion: {
        type: String,
        required: false,
    },
    cartCount: {
        type: Number,
        default: 0,
    },
});

// Estado local del carrito
const localCartCount = ref(0);


onMounted(() => {
    const storedCart = localStorage.getItem('cart');
    if (storedCart) {
        const items = JSON.parse(storedCart);
        localCartCount.value = items.reduce((sum, item) => sum + item.quantity, 0);
    } else {
        localCartCount.value = 0;
    }

    // Escuchar eventos del carrito en tiempo real
    emitter.on('update-cart', (newCount) => {
        localCartCount.value = newCount;
    });
});


// Obtener el estado de la página
const search = usePage().props.filters?.search || '';

</script>

<template>
    <nav
        class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 py-4 bg-white shadow dark:bg-gray-900">

        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <a href="/">
                <img src="/images/logo.jpg" alt="Logo" class="h-16 w-auto" />
            </a>
        </div>

        <!-- <H1>ROL = {{$page.props.auth.user.role}}</H1> -->

        <!-- Buscador -->
        <div class="flex-1 mx-8">

            <form method="GET" :action="route('products.indexHome')" class="flex items-center w-full max-w-md mx-8">
                <input type="text" name="search" :value="search" placeholder="Buscar productos..."
                    class="flex-grow rounded-l-md border border-gray-300 px-4 py-2 focus:border-[#FF2D20] focus:ring-[#FF2D20] dark:bg-gray-800 dark:border-gray-700" />
                <button type="submit"
                    class="bg-[#fbfcfb] text-black px-4 py-2 rounded-r-md hover:bg-red-600 transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>

        </div>

        <!-- Carrito + Auth Links -->
        <div class="flex items-center space-x-4">
            <!-- Carrito -->
            <a class="relative group transition duration-200" :href="route('cart.index')">
                <svg class="w-6 h-6 text-black dark:text-white group-hover:text-blue-600 group-hover:scale-110 transition-transform duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h13.4M7 13L5.4 5M16 21a1 1 0 11-2 0 1 1 0 012 0zm-8 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>

                <span
                    class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs group-hover:bg-red-700 transition duration-200">
                    {{ localCartCount || cartCount }}
                </span>
            </a>


            <!-- Auth Links -->
            <div v-if="!canLogin" class="flex items-center space-x-2">
                <template v-if="auth.user">
                    <!-- Si está logeado -->
                    <div class="relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button type="button"
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                    {{ auth.user.username }}
                                    <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">Perfil</DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">Cerrar sesión
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </template>

                <template v-else>
                    <!-- Si no está logeado -->
                    <Link :href="route('login')" class="text-sm font-medium hover:text-[#FF2D20]">
                    Iniciar sesión
                    </Link>

                    <Link v-if="!canRegister" :href="route('register')"
                        class="text-sm font-medium hover:text-[#FF2D20]">
                    Registrarse
                    </Link>
                </template>
            </div>
        </div>
    </nav>
</template>
