<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import ModalConfirm from '@/Components/ModalConfirm.vue'

defineOptions({
    layout: AuthenticatedLayout,
})

defineProps({ clients: Object })

const showModal = ref(false)
const clientIdToDelete = ref(null)

const confirmDelete = (id) => {
    clientIdToDelete.value = id
    showModal.value = true
}

const deleteClient = () => {
    router.delete(route('clients.destroy', clientIdToDelete.value), {
        onSuccess: () => {
            showModal.value = false
        }
    })
}
</script>

<template>

    <Head title="Clientes" />

    <div class="p-6 bg-white shadow-md rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Clientes</h1>
            <Link href="/clients/create"
                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition shadow">
            + Nuevo cliente
            </Link>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-sm">
                <thead class="bg-gray-100">
                    <tr class="text-gray-600 text-left text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 border-b">Nombre</th>
                        <th class="py-3 px-4 border-b">Email</th>
                        <th class="py-3 px-4 border-b">Usuario</th>
                        <th class="py-3 px-4 border-b text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="client in clients.data" :key="client.id" class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 border-b">{{ client.name }}</td>
                        <td class="py-3 px-4 border-b">{{ client.email }}</td>
                        <td class="py-3 px-4 border-b">{{ client.username }}</td>
                        <td class="py-3 px-4 border-b text-center space-x-2">
                            <Link :href="route('clients.edit', client.id)"
                                class="bg-yellow-500 text-white px-3 py-1 rounded-md text-sm hover:bg-yellow-600 transition">
                            Editar
                            </Link>
                            <button @click="confirmDelete(client.id)"
                                class="bg-red-600 text-white px-3 py-1 rounded-md text-sm hover:bg-red-700 transition">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Paginación si quieres -->
            <div class="mt-4">
                <button v-if="clients.prev_page_url" @click="router.visit(clients.prev_page_url)"
                    class="mr-2 px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">
                    Anterior
                </button>
                <button v-if="clients.next_page_url" @click="router.visit(clients.next_page_url)"
                    class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">
                    Siguiente
                </button>
            </div>
        </div>
    </div>

    <ModalConfirm :show="showModal" title="Confirmar eliminación"
        message="¿Estás seguro de que deseas eliminar este cliente?" @confirm="deleteClient"
        @cancel="showModal = false" />
</template>
