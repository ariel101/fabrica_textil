<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" v-if="show">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md transform transition-all duration-300">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ title }}</h2>
            <p class="text-gray-600 mb-6">{{ message }}</p>

            <div class="flex justify-end space-x-3">
                <button @click="$emit('cancel')"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded transition">
                    Cancelar
                </button>
                <button @click="$emit('confirm')"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    show: Boolean,
    title: String,
    message: String,
})
</script>
