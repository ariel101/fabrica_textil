<template>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <Sidebar />
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <NavBar />


            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6 rounded-md mt-2">
                <!-- Mostrar estadísticas solo en el dashboard -->
                <StatisticGrid v-if="route().current('dashboard')" />
                <slot />

            </main>
        </div>
    </div>
</template>

<script setup>
import Sidebar from '@/Components/Panel/Sidebar.vue';
import NavBar from '@/Components/Panel/NavBar.vue';
import StatisticGrid from '@/Components/Panel/StatisticGrid.vue';

</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
