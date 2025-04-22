<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

// defineProps({
//     canLogin: Boolean,
//     canRegister: Boolean,
//     laravelVersion: String,
//     phpVersion: String,
//     //auth: Object
// });

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
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
            <!-- Carrito (puedes enlazar a tu componente de carrito) -->
            <button class="relative">
                <svg class="w-6 h-6 text-black dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h13.4M7 13L5.4 5M16 21a1 1 0 11-2 0 1 1 0 012 0zm-8 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
            </button>

            <!-- Auth -->
            <div v-if="canLogin" class="flex items-center space-x-2">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                    class="text-sm font-medium hover:text-[#FF2D20]">
                Dashboard
                </Link>

                <template v-else>
                    <Link :href="route('login')" class="text-sm font-medium hover:text-[#FF2D20]">
                    Iniciar sesión
                    </Link>

                    <Link v-if="canRegister" :href="route('register')" class="text-sm font-medium hover:text-[#FF2D20]">
                    Registrarse
                    </Link>
                </template>
            </div>
        </div>
    </nav>
</template>