<template>
    <div class="flex h-screen">
      <!-- Sidebar -->
      <Sidebar />
      <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Navbar -->
        <NavBar />
        <StatisticGrid />
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 rounded-md mt-2">
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
  </script>
  
  <style scoped>
  /* Puedes agregar estilos personalizados aquí */
  </style>
  