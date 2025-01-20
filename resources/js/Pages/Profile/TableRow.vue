<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import { ref, computed, watch,reactive } from 'vue' 
    import Welcome from '@/Components/Welcome.vue';
    import { router, usePage,Link ,Head} from '@inertiajs/vue3'
    import { onMounted,onUpdated } from 'vue' 
    import debounce from 'lodash/debounce'
    import { Dropdown,Modal } from 'flowbite'

    const props = defineProps({
        applicant : Object,
       schedules:Object,
        } )
        const dialogVisible = ref(false);
    const openModal = (applicantDetails) => {
        form.uuid = applicantDetails.uuid;
        form.last_name = applicantDetails.last_name;
        form.first_name = applicantDetails.first_name;
        form.middle_name = applicantDetails.middle_name;
        form.dc_campus = applicantDetails.dc_campus;
        form.dc_course = applicantDetails.dc_course;

        dialogVisible.value = true
    }
    let form = {
    id:'',
    uuid:'',
    last_name:'',
          first_name:'',
          middle_name:'',
          suffix:'',
          dc_campus:'',
          dc_course:'',
}; 
let applicationDetails = reactive({
          applicant_id:props.applicant.id,
          exam_schedule_id:props.schedules ? props.schedules[0].id : '',
          
          status:'Pending',

        })
        const submit = async () => {
    try {
        const response = await axios.post('/count-total-applicant-inschedule', { schedule_id: applicationDetails.exam_schedule_id });
        
        const totalCount = response.data.count;
        const available = response.data.available; // Ensure this is part of your response

        if (totalCount <= available) {
            await axios.post('/save-sched', { applicationDetails });
            dialogVisible.value = false;
            router.reload(); // Reload the page after successful submission
        }
    } catch (error) {
        console.error('Error updating timesheet:', error);
    }
};
</script>
<template>
  <el-dialog v-model="dialogVisible" title="Tips" width="500" :show-close="false" class="rounded-lg ">
            <template #header="{ close, titleId, titleClass }">
                <div class="my-header">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between  border-b border-dashed border-b-2  rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Set Exam Schedule
                        </h3>

                        
                        <button @click="close" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                </div>
            </template>
            <div class="relative px-4 pb-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg  dark:bg-gray-700">
                  <p class="text-xl font-semibold mb-2">Examinees Information</p>
        <div class="flex space-x-2 text-black-400 text-sm">
            <!-- Location icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5" >
  <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
</svg>
            <p class="font-black">{{ form.last_name }}, {{form.first_name}} {{form.middle_name}}</p> 
        </div>

        <div class="flex space-x-2 text-black-400 text-sm my-2">
            <!-- Location icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" >
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
</svg>

            <p class="font-medium">{{form.dc_course}}</p> 
        </div>
        <div class="flex space-x-2 text-black-400 text-sm ">
            <!-- Date icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <p class="font-medium">{{ form.dc_campus }}</p> 
        </div>
        <div class="border-b border-dashed border-b-2 my-2"></div>
        <p class="text-xl font-semibold my-2">Schedule</p>


<form class="max-w-full mx-auto">
  <select v-model="applicationDetails.exam_schedule_id" id="countries" class="bg-gray-50 border border-blue-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

    <option v-for="schedule in props.schedules" :key="schedule.id" :value="schedule.id">{{ schedule.exam_date }} - Available({{ schedule.available }}) - {{ schedule.venue }}</option>

  </select>
</form>


                    <!-- Modal body -->
                    <form @submit.prevent="submit">
                       
                      <button type="submit" class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                    
                    </form>
                </div>
            </div>

        </el-dialog>
      <div  class="flex w-full mb-3 max-w-screen-xl border border-gray-100 transform cursor-pointer flex-col justify-between rounded-md bg-white bg-opacity-75 p-6 text-slate-800 transition duration-500 ease-in-out hover:-translate-y-1 hover:shadow-lg dark:bg-slate-700 dark:bg-opacity-25 dark:text-slate-300 lg:flex-row lg:p-3">
        <div class="flex w-full flex-row md:min-w-64 md:w-6">
            <!-- <div class="relative flex flex-col">
            <div class="flex h-12 w-12 flex-shrink-0 flex-col justify-center rounded-full bg-slate-200 bg-opacity-50 dark:bg-slate-600">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&w=128&h=128&q=60&facepad=1.5" 
                    class="z-10 h-12 w-12 rounded-full object-cover shadow hover:shadow-xl" 
                    alt="Rocky Balboa" />
                <span class="absolute right-0 top-0 z-20 flex h-3 w-3">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex h-3 w-3 rounded-full bg-green-500"></span>
                </span>
            </div>
            </div> -->
            <div class=" self-center overflow-x-hidden">
                <div class="w-full truncate text-xl font-extrabold leading-5 tracking-tight">{{ props.applicant.last_name }} {{ props.applicant.first_name }} {{ props.applicant.middle_name }}</div>
                <div class="text-xs text-slate-500">ID:{{ props.applicant.uuid }}</div>
            </div>
        </div>

        <div class="z-50 hidden w-1/6 self-center lg:block">
            <div class="flex flex-row justify-center">
            <div x-data="{ tooltip: false }" class="relative z-0 -mr-4 inline-flex transition duration-300 ease-in-out hover:-mr-1" x-cloak>
                <img @mouseover="tooltip = true" @mouseleave="tooltip = false" class="z-10 h-9 w-9 rounded-full border-2 border-white object-cover shadow hover:shadow-xl dark:border-slate-800" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&w=128&h=128&q=60&facepad=1.5" alt="Marilyn Monroe" />
                <span class="absolute bottom-0 right-0 z-20 h-3 w-3 rounded-full border-2 border-slate-200 bg-green-400 dark:border-slate-800"></span>
                <div class="relative z-50 overflow-visible pt-2" x-cloak x-show="tooltip" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="transform opacity-0 translate-y-full" x-transition:enter-end="transform opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 translate-y-0" x-transition:leave-end="transform opacity-0 translate-y-full">
                <div class="absolute -right-1 z-50 mt-1 w-40 -translate-x-10 -translate-y-5 transform overflow-x-hidden rounded-lg bg-blue-200 p-2 text-center leading-tight text-white shadow-md dark:bg-slate-900">
                    <div class="text-slate-700 dark:text-slate-200 text-center text-base font-extrabold">Marilyn Monroe</div>
                    <div class="text-slate-500 text-xs uppercase">Primary</div>
                </div>
                <svg class="absolute right-2 z-50 h-6 w-6 -translate-x-4 translate-y-0 transform fill-current stroke-current text-blue-200 dark:text-slate-900" width="8" height="8">
                    <rect x="9" y="-8" width="8" height="8" transform="rotate(45)"></rect>
                </svg>
                </div>
            </div>
            <div x-data="{ tooltip: false }" class="relative z-0 -mr-4 inline-flex transition duration-300 ease-in-out" x-cloak>
                <img @mouseover="tooltip = true" @mouseleave="tooltip = false" class="z-10 h-9 w-9 rounded-full border-2 border-white object-cover shadow hover:shadow-xl dark:border-slate-800" src="https://images.unsplash.com/photo-1554151228-14d9def656e4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&w=128&h=128&q=60&facepad=1.5" alt="Salesperson" />
                <span class="absolute bottom-0 right-0 z-20 h-3 w-3 rounded-full border-2 border-slate-200 bg-green-400 dark:border-slate-800"></span>
                <div class="relative z-50 overflow-visible pt-2" x-cloak x-show="tooltip" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="transform opacity-0 translate-y-full" x-transition:enter-end="transform opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 translate-y-0" x-transition:leave-end="transform opacity-0 translate-y-full">
                <div class="absolute -right-1 z-50 mt-1 w-40 -translate-x-10 -translate-y-5 transform overflow-x-hidden rounded-lg bg-blue-200 p-2 text-center leading-tight text-white shadow-md dark:bg-slate-900">
                    <div class="text-slate-700 dark:text-slate-200 text-center text-base font-extrabold">Jimmy Stewart</div>
                    <div class="text-slate-500 text-xs uppercase">Secondary</div>
                </div>
                <svg class="absolute right-2 z-50 h-6 w-6 -translate-x-4 translate-y-0 transform fill-current stroke-current text-blue-200 dark:text-slate-900" width="8" height="8">
                    <rect x="9" y="-8" width="8" height="8" transform="rotate(45)"></rect>
                </svg>
                </div>
            </div>
            </div>
        </div>

        <div class="w-full self-center pt-4 lg:w-1/2 lg:pt-0">
            <div class="ml-1">
            <div class="text-lg font-extrabold leading-5 tracking-tight">
                <span class="align-middle text-green-800">{{ props.applicant.dc_course }}</span>
                <span class="text-[8px]  ml-2 rounded bg-orange-600 px-2 py-1 align-middle font-bold uppercase text-white">Waiting</span>
            </div>
            <div class="text-sm text-slate-500">{{ props.applicant.dc_campus }}</div>
            </div>
        </div>
        <div class="w-full self-center pt-4 lg:w-1/5 lg:pt-0">
            <div class="">
              <div class="flex items-center text-lg font-extrabold leading-5 tracking-tight">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>

                <p class="text-sm leading-none text-gray-600 ml-2">{{props.applicant.created_at}}</p>
            </div>
            <div class="text-sm text-slate-500 pl-7">{{props.applicant.created_at_human}}</div>
            </div>
        </div>


        <div class="w-full self-center px-1 pt-4 pb-2 lg:w-1/3 lg:px-0 lg:pt-0 lg:pb-0 center">
            <!-- <div class="text-base font-bold leading-4 tracking-tight">This is great for short status messages</div>
            <div class="status-bars w-full pt-2">
            <div class="flex flex-row lg:pr-6">
                <div class="max-w-6 h-1 w-1/5 rounded bg-green-500"></div>
                <div class="max-w-6 ml-1 h-1 w-1/5 rounded bg-amber-500"></div>
                <div class="max-w-6 ml-1 h-1 w-1/5 rounded bg-slate-400 bg-opacity-25 dark:bg-slate-600"></div>
                <div class="max-w-6 ml-1 h-1 w-1/5 rounded bg-slate-400 bg-opacity-25 dark:bg-slate-600"></div>
                <div class="max-w-6 ml-1 h-1 w-1/5 rounded bg-slate-400 bg-opacity-25 dark:bg-slate-600"></div>
            </div>
            </div> -->
            <button class="focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-gray-600 py-2 px-2 bg-gray-100 rounded hover:bg-gray-200 focus:outline-none mr-2 "><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
  <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
  <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
</svg>

            </button>
            
            <button @click="openModal(props.applicant)" type="button" class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-3.5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-1 mb-2">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-1">
  <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
  <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
</svg>

Set Schedule
</button>
           
            <button class="focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-white py-2 px-2 ml-1 bg-red-800 rounded hover:bg-red-700 focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
  <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
</svg>

            </button>
     
       
        </div>
    </div>
</template>



