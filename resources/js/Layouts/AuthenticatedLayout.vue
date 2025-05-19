<template>
    <div class="flex h-screen">
        <!-- <h1>USUARIO = {{ $page.props.auth.user.name }}</h1>
        <br>
        <h1>rol = {{ $page.props.auth.user.role }}</h1> -->

        <!-- Sidebar -->
        <Sidebar v-if="$page.props.auth.user.role === 'admin'"/>
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

<script>
import Sidebar from '@/Components/Panel/Sidebar.vue';
import NavBar from '@/Components/Panel/NavBar.vue';
import StatisticGrid from '@/Components/Panel/StatisticGrid.vue';

export default {
    components: {
        Sidebar,
        NavBar,
        StatisticGrid
    },

}

//const isClient = $page.props.auth.user.hasRole('client');


</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
