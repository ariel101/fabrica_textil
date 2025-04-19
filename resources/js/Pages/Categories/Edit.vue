<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import Form from './Form.vue'

defineOptions({
    layout: AuthenticatedLayout,
})

defineProps({ category: Object })
</script>

<template>

    <Head title="Categorías" />
    <div>
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Editar categoría</h1>
        <Form :category="category" :action="route('categories.update', category.id)" method="put"
            submit-label="Actualizar" />
    </div>
</template>
