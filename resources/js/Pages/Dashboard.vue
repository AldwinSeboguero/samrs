<script setup>
import AppLayout from '@/Layouts/MyLayout2.vue';
import Registration from '@/Pages/Profile/Registration.vue';

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

      <div class="">
        <Registration/>

      </div>
    </AppLayout>
</template>
