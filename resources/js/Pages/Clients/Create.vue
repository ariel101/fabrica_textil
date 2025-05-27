<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { Head, useForm, Link } from '@inertiajs/vue3'

defineOptions({ layout: AuthenticatedLayout })

const form = useForm({
    name: '',
    email: '',
    username: '',
    password: '',
    password_confirmation: '',
    cellphone: '',
    identity_card: '',
    city: '',
})

const submit = () => {
    form.post(route('clients.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>

    <Head title="Crear Cliente" />

    <div class="p-6 bg-white shadow-md rounded-lg max-w-md mx-auto">
        <h1 class="text-2xl font-bold mb-6">Nuevo Cliente</h1>

        <form @submit.prevent="submit" class="space-y-4">

            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput v-model="form.name" type="text" id="name" required class="w-full" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />
                <TextInput v-model="form.email" type="email" id="email" required class="w-full" />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div>
                <InputLabel for="username" value="Usuario" />
                <TextInput v-model="form.username" type="text" id="username" required class="w-full" />
                <InputError :message="form.errors.username" class="mt-2" />
            </div>

            <div>
                <InputLabel for="password" value="Contraseña" />
                <TextInput v-model="form.password" type="password" id="password" required class="w-full" />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirmar Contraseña" />
                <TextInput v-model="form.password_confirmation" type="password" id="password_confirmation" required
                    class="w-full" />
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div>
                <InputLabel for="cellphone" value="Celular" />
                <TextInput v-model="form.cellphone" type="text" id="cellphone" required class="w-full" />
                <InputError :message="form.errors.cellphone" class="mt-2" />
            </div>

            <div>
                <InputLabel for="identity_card" value="Cédula de Identidad" />
                <TextInput v-model="form.identity_card" type="text" id="identity_card" required class="w-full" />
                <InputError :message="form.errors.identity_card" class="mt-2" />
            </div>

            <div>
                <InputLabel for="city" value="Ciudad" />
                <select v-model="form.city" id="city" required class="w-full border rounded px-3 py-2">
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
                <PrimaryButton :disabled="form.processing">Crear Cliente</PrimaryButton>
                <Link href="/clients" class="text-gray-600 hover:underline">Cancelar</Link>
            </div>

        </form>
    </div>
</template>
