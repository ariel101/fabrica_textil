<script setup>
import { Head, Link } from '@inertiajs/vue3';
import NavBar from '@/Components/Inicio/NavBar.vue';
import Footer from '@/Components/Inicio/Footer.vue';
import NavBarCategories from '@/Components/Inicio/NavBarCategories.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    auth: {
        type: Object,
        required: true,
    },
    showFooter: {
        type: Boolean,
        default: true,
    },
    showCategories: {
        type: Boolean,
        default: true,
    },

});


function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>

    <Head title="Inicio" />
    <div class="flex flex-col min-h-screen bg-gray-50 dark:bg-black text-black dark:text-white">

        <NavBar :canLogin="$page.props.canLogin" :canRegister="$page.props.canRegister" :auth="$page.props.auth" />
        <NavBarCategories v-if="showCategories" />

        <!-- HEADER CON SVG (opcional) -->
        <header class="flex justify-center items-center py-10">
            <!-- Aquí va tu logo SVG -->
            <svg class="h-16 w-auto text-[#FF2D20]" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Tu path completo aquí -->
            </svg>
        </header>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-grow px-6">
            <slot />
        </main>

        <!-- FOOTER -->
        <Footer v-if="showFooter" />
    </div>
</template>
