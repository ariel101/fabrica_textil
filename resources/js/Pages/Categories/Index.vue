<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import ModalConfirm from '@/Components/ModalConfirm.vue'

defineOptions({
    layout: AuthenticatedLayout,
})

defineProps({ categories: Array })

const showModal = ref(false)
const categoriaIdEliminar = ref(null)

const confirmarEliminacion = (id) => {
    categoriaIdEliminar.value = id
    showModal.value = true
}

const eliminar = () => {
    router.delete(route('categories.destroy', categoriaIdEliminar.value), {
        onSuccess: () => {
            showModal.value = false
        }
    })
}
</script>

<template>

    <Head title="Categorías" />

    <div class="p-6 bg-white shadow-md rounded-lg">
        <!-- Encabezado de la página -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Categorías</h1>
            <Link href="/categories/create"
                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition shadow">
            + Nueva categoría
            </Link>
        </div>

        <!--  Tabla de Categorías -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-sm">
                <thead class="bg-gray-100">
                    <tr class="text-gray-600 text-left text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 border-b">Nombre</th>
                        <th class="py-3 px-4 border-b">Descripción</th>
                        <th class="py-3 px-4 border-b text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cat in categories" :key="cat.id" class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 border-b">{{ cat.nombre }}</td>
                        <td class="py-3 px-4 border-b">{{ cat.descripcion }}</td>
                        <td class="py-3 px-4 border-b text-center space-x-2">
                            <Link :href="route('categories.edit', cat.id)"
                                class="bg-yellow-500 text-white px-3 py-1 rounded-md text-sm hover:bg-yellow-600 transition">
                            Editar
                            </Link>
                            <button @click="confirmarEliminacion(cat.id)"
                                class="bg-red-600 text-white px-3 py-1 rounded-md text-sm hover:bg-red-700 transition">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <ModalConfirm :show="showModal" title="Confirmar eliminación"
        message="¿Estás seguro de que deseas eliminar esta categoría?" @confirm="eliminar"
        @cancel="showModal = false" />
</template>
