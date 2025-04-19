<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

defineOptions({
    layout: AuthenticatedLayout,
})

import Form from './Form.vue'
</script>

<template>

    <Head title="Categorías" />
    <div>
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Crear nueva categoría</h1>
        <Form :action="route('categories.store')" submit-label="Crear" />
    </div>
</template>
