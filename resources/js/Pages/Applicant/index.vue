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
                       <!-- Success -->
    <div class="relative hidden mb-4 max-w-sm rounded-lg border border-gray-100 bg-white px-12 py-6 shadow-md">
      <button class="absolute top-0 right-0 p-4 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <p class="relative mb-1 text-sm font-medium">
        <span class="absolute -left-7 flex h-5 w-5 items-center justify-center rounded-xl bg-green-400 text-white">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-3 w-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
          </svg>
        </span>
        <span class="text-gray-700">Saved successfuly!</span>
      </p>
      <p class="text-sm text-gray-600">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
    </div>
    <!-- /Success -->

    <!-- Fail -->
    <!-- <div class="relative m-2 my-8 max-w-sm rounded-lg border border-gray-100 bg-white px-12 py-6 shadow-md">
      <button class="absolute top-0 right-0 p-4 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <p class="relative mb-1 text-sm font-medium">
        <span class="absolute -left-7 flex h-5 w-5 items-center justify-center rounded-xl bg-red-400 text-white">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-3 w-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </span>
        <span class="text-gray-700">Save Failed!</span>
      </p>
      <p class="text-sm text-gray-600">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
    </div> -->
    <!-- /Fail -->

    <!-- Warn -->
    <!-- <div class="relative m-2 my-8 max-w-sm rounded-lg border border-gray-100 bg-white px-12 py-6 shadow-md">
      <button class="absolute top-0 right-0 p-4 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <p class="relative mb-1 text-sm font-medium">
        <span class="absolute -left-7 flex h-5 w-5 items-center justify-center rounded-xl bg-yellow-400 text-white"> ! </span>
        <span class="text-gray-700">Network Unavailable</span>
      </p>
      <p class="text-sm text-gray-600">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
    </div> -->
    <!-- /Warn -->

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
