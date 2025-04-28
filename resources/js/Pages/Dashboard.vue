<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import '@fortawesome/fontawesome-free/css/all.min.css';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout :auth="$page.props.auth" />

</template>
