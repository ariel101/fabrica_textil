<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    username: user.username,
    email: user.email,
    cellphone: user.cellphone,
    identity_card: user.identity_card,
    city: user.city,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Informacion de perfil
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <!-- Nombre -->
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Nombre de usuario -->
            <div>
                <InputLabel for="username" value="Username" />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.username"
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <!-- email -->
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Verificación de email -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <!-- Celular -->
            <div>
                <InputLabel for="cellphone" value="Cellphone" />

                <TextInput
                    id="cellphone"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.cellphone"
                    autocomplete="tel"
                />

                <InputError class="mt-2" :message="form.errors.cellphone" />
            </div>

            <!-- Carnet de identidad-->
            <div>
                <InputLabel for="identity_card" value="Identity Card" />

                <TextInput
                    id="identity_card"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.identity_card"
                />

                <InputError class="mt-2" :message="form.errors.identity_card" />
            </div>

            <!-- Ciudad -->
            <div>
                <InputLabel for="city" value="Ciudad" />
                <select id="city" v-model="form.city" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disabled value="">Seleccione una ciudad</option>
                    <option>La Paz</option>
                    <option>El Alto</option>
                    <option>Cochabamba</option>
                    <option>Santa Cruz</option>
                    <option>Sucre</option>
                    <option>Oruro</option>
                    <option>Potosi</option>
                    <option>Tarija</option>
                    <option>Beni</option>
                    <option>Pando</option>
                </select>
                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
