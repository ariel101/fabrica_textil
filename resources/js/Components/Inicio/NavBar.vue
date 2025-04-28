<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    auth: Object,
});
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

        <!-- Buscador -->
        <div class="flex-1 mx-8">
            <input type="text" placeholder="Buscar productos..."
                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-[#FF2D20] focus:ring-[#FF2D20] dark:bg-gray-800 dark:border-gray-700" />
        </div>

        <!-- Carrito + Auth Links -->
        <div class="flex items-center space-x-4">
            <!-- Carrito -->
            <button class="relative">
                <svg class="w-6 h-6 text-black dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h13.4M7 13L5.4 5M16 21a1 1 0 11-2 0 1 1 0 012 0zm-8 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
            </button>

            <!-- Auth Links -->
            <div v-if="!canLogin" class="flex items-center space-x-2">
                <template v-if="auth.user">
                    <!-- Si está logeado -->
                    <div class="relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button type="button"
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                    {{ auth.user.name }}
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
