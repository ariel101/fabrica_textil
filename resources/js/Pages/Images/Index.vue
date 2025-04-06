<template>
    <Welcome>
      <section class="p-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div v-for="image in images" :key="image.id"
          class="border rounded-lg p-4 shadow hover:shadow-md transition"
        >
          <img :src="'/' + image.url" alt="" class="h-40 w-full object-cover mb-2" />
          <h3 class="text-lg font-semibold">nombre</h3>
          <p class="text-gray-600">descripcion</p>
          <p class="text-green-600 font-bold mt-2">precio</p>
        </div>
      </section>
    </Welcome>
  </template>
  
  <script setup>
  import { usePage } from '@inertiajs/vue3'
  //import AppLayout from '@/Layouts/AppLayout.vue'
  import Welcome from '@/Pages/Welcome.vue'

  const { images } = usePage().props
  </script>
  