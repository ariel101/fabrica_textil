<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { Head, useForm, Link } from '@inertiajs/vue3'

defineOptions({ layout: AuthenticatedLayout })

// Props del cliente que viene desde Laravel
const props = defineProps({
    client: Object,
})

const form = useForm({
    name: props.client.name,
    email: props.client.email,
    username: props.client.username,
    cellphone: props.client.cellphone,
    identity_card: props.client.identity_card,
    city: props.client.city,
})

// Envío del formulario
const submit = () => {
    form.put(route('clients.update', props.client.id))
}
</script>

<template>

    <Head title="Editar Cliente" />

    <div class="p-6 bg-white shadow-md rounded-lg max-w-md mx-auto">
        <h1 class="text-2xl font-bold mb-6">Editar Cliente</h1>

        <form @submit.prevent="submit" class="space-y-4">

            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput id="name" v-model="form.name" type="text" required class="w-full" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" v-model="form.email" type="email" required class="w-full" />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div>
                <InputLabel for="username" value="Usuario" />
                <TextInput id="username" v-model="form.username" type="text" required class="w-full" />
                <InputError :message="form.errors.username" class="mt-2" />
            </div>

            <div>
                <InputLabel for="cellphone" value="Celular" />
                <TextInput id="cellphone" v-model="form.cellphone" type="text" required class="w-full" />
                <InputError :message="form.errors.cellphone" class="mt-2" />
            </div>

            <div>
                <InputLabel for="identity_card" value="Cédula de Identidad" />
                <TextInput id="identity_card" v-model="form.identity_card" type="text" required class="w-full" />
                <InputError :message="form.errors.identity_card" class="mt-2" />
            </div>

            <div>
                <InputLabel for="city" value="Ciudad" />
                <select id="city" v-model="form.city" required class="w-full border rounded px-3 py-2">
                    <option value="">Seleccione una ciudad</option>
                    <option value="La Paz">La Paz</option>
                    <option value="El Alto">El Alto</option>
                    <option value="Cochabamba">Cochabamba</option>
                    <option value="Santa Cruz">Santa Cruz</option>
                    <option value="Sucre">Sucre</option>
                    <option value="Oruro">Oruro</option>
                    <option value="Potosi">Potosí</option>
                    <option value="Tarija">Tarija</option>
                    <option value="Beni">Beni</option>
                    <option value="Pando">Pando</option>
                </select>
                <InputError :message="form.errors.city" class="mt-2" />
            </div>

            <div class="pt-4 flex justify-between">
                <PrimaryButton :disabled="form.processing">Actualizar Cliente</PrimaryButton>
                <Link href="/clients" class="text-gray-600 hover:underline">Cancelar</Link>
            </div>

        </form>
    </div>
</template>
