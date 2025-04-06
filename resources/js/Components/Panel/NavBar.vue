<template>
    <div class="bg-white shadow-md py-4 px-6 flex justify-between items-center border-b-3">
      <!-- Título del dashboard -->
      
  
      <!-- Barra de búsqueda -->
      <div class="relative w-58">
        <input type="text" name="buscar" id="buscar"
          class="rounded-full border border-gray-300 p-2 pl-10 w-full focus:outline-none focus:ring-2 focus:ring-blue-200 h-9"
          placeholder="Buscar">
        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
      </div>
  
      <!-- Menú de usuario -->
      <div class="relative">
        <Dropdown align="right" width="48">
          <template #trigger>
            <button type="button"
              class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
              {{ $page.props.auth.user.name }}
              <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </button>
          </template>
  
          <template #content>
            <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
            <DropdownLink :href="route('logout')" method="post" as="button"> Log Out </DropdownLink>
          </template>
        </Dropdown>
      </div>
    </div>
  </template>
  
  <script setup>
  import Dropdown from '@/Components/Dropdown.vue';
  import DropdownLink from '@/Components/DropdownLink.vue';
  import { Link } from '@inertiajs/vue3';
  </script>
  