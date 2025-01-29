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
let dialogVisible = props.errorBags.default && props.errorBags.default.msg && props.errorBags.default.msg.length > 0;
let closeDialog = async () => {
  dialogVisible = false;
}
</script>

<template>
    <AppLayout title="Edit Employee">
   
        <Head title="Registration" />
        <el-dialog v-model="dialogVisible" title="Tips" width="400" :show-close="false" class="rounded-lg ">
            <template #header="{ close, titleId, titleClass }">
                <div class="my-header">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between  border-b border-dashed border-b-2  rounded-t dark:border-gray-600">
                
                    <!-- {{ props.errorBags }} -->

                        <button @click="close" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                </div>

                <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">This applicant is already registered in the system.</h3>
                <button data-modal-hide="popup-modal" type="button" @click="close"  class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    I Understand
                </button>
            </div>
            </template>
            
        
          
       


        </el-dialog>

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
