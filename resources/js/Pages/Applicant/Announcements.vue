<script setup>
import AppLayout from '@/Layouts/MyLayout2.vue';
import Welcome from '@/Components/Welcome.vue';
import RegistrationFOrm from '@/Pages/Profile/Registration.vue'
    import { router, usePage,Link ,Head} from '@inertiajs/vue3'
// const props = defineProps({
//         Campuses : Object,
//         Courses : Object,
//         Schools : Object,
//         TrackStrand : Object,
//         Strands : Object,
//         CivilStatus : Object,
//         Gender : Object,
//         filters : Object,
//         } )
const { props } = usePage();
</script>

<template>
    <AppLayout title="Edit Employee">
   
        <Head title="Registration" />

        <div class="m-2">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
               
                <div class="w-full  p-4 bg-white border-dotted border-2 border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
   
                    <!-- <Welcome /> -->
                     
                     <RegistrationFOrm
                     :Campuses="Campuses"
                    :Courses="Courses"
                    :Schools="Schools"
                    :TrackStrand="TrackStrand"
                    :Strands="Strands"
                    :CivilStatus="CivilStatus"
                    :Gender="Gender"
                    :filters="filters"
                     />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
