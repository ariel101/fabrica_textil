<template>
    <nav class="bg-gray-700 text-white w-full p-1 pt-4 fixed top-[60px] z-40 mt-6">
        <ul class="flex justify-center space-x-6">
            <li>
                <button
                    @click="seleccionarCategoria(null)"
                    class="hover:bg-gray-600 px-4 py-2 rounded-md text-sm font-medium transition"
                    :class="{ 'bg-gray-600': selectedCategory === null }"
                >
                    Todos
                </button>
            </li>
            <li v-for="categoria in categorias" :key="categoria.id">
                <button
                    @click="seleccionarCategoria(categoria.id)"
                    class="hover:bg-gray-600 px-4 py-2 rounded-md text-sm font-medium transition"
                    :class="{ 'bg-gray-600': categoria.id === selectedCategory }"
                >
                    {{ categoria.nombre }}
                </button>
            </li>
        </ul>
    </nav>
</template>

<script setup>
const emit = defineEmits(['categoriaSeleccionada'])

const props = defineProps({
    categorias: Array,
    selectedCategory: [Number, null]
})

const seleccionarCategoria = (id) => {
    emit('categoriaSeleccionada', id)
}
</script>
