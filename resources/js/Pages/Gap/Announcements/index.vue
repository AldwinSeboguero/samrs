<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import RegistrationFOrm from '@/Pages/Profile/Registration.vue'
import { router, usePage,Link ,Head} from '@inertiajs/vue3'

const { props } = usePage();
</script>

<template>
    <AppLayout title="Applicants">

    </AppLayout>
   
</template>
