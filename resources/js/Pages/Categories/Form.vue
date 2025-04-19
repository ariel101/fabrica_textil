<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'


defineOptions({
    layout: AuthenticatedLayout,
})

const props = defineProps({
    category: {
        type: Object,
        default: () => ({
            nombre: '',
            descripcion: '',
        }),
    },
    submitLabel: {
        type: String,
        default: 'Guardar',
    },
    action: {
        type: String,
        required: true,
    },
    method: {
        type: String,
        default: 'post',
    },
})

const form = useForm({
    nombre: props.category.nombre,
    descripcion: props.category.descripcion,
})

const submit = () => {
    if (props.method === 'post') {
        form.post(props.action)
    } else {
        form.put(props.action)
    }
}
</script>

<template>

    <Head title="Categorías" />
    <form @submit.prevent="submit">
        <div class="mb-4">
            <label class="block font-medium">Nombre</label>
            <input v-model="form.nombre" type="text" class="input input-bordered w-full" />
            <div v-if="form.errors.nombre" class="text-red-500 text-sm mt-1">
                {{ form.errors.nombre }}
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Descripción</label>
            <textarea v-model="form.descripcion" class="textarea textarea-bordered w-full"></textarea>
            <div v-if="form.errors.descripcion" class="text-red-500 text-sm mt-1">
                {{ form.errors.descripcion }}
            </div>
        </div>

        <button type="submit" class="btn btn-primary">{{ submitLabel }}</button>
    </form>
</template>
