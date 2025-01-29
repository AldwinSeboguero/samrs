<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import { router, usePage, Link, Head, usePoll } from '@inertiajs/vue3'
import { ref, computed, watch, reactive, onMounted } from 'vue'
import Applicants from '@/Pages/Profile/TableRow.vue'
import Toast from '@/Pages/Profile/Toast.vue';
import debounce from 'lodash/debounce'
import { initFlowbite } from 'flowbite'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();

})
usePoll(2000, {
    onStart() {
               axios.get('/getRequestStat')
    .then(response => {
        console.log('Polling request started', response);
        
        // Update props with the response data
        props.total_request = response.data.total_request;
        props.total_request_approved = response.data.total_request_approved;
        props.total_request_disapproved = response.data.total_request_disapproved;
        props.total_request_pending = response.data.total_request_pending;
    })
    .catch(error => {
        console.error('Error fetching request stats:', error);
    });


    },
    onFinish() {
        console.log('Polling request finished')
    }
})
const { props } = usePage();
let search = ref(props.filters.search);
let schedule = ref(props.filters.schedule);

let status = ref(props.filters.status || 'Pending');


watch(search, debounce(function (value) {

    router.get('/application/requests', { search: value, status: props.filters.status,schedule: props.filters.schedule }, {

        replace: true
    });
}, 500));
watch(status, function (value) {
    router.get('/application/requests', { status: value,schedule: props.filters.schedule, search: props.filters.search }, {

        replace: true
    });

});

watch(schedule, function (value) {
    router.get('/application/requests', {schedule: value, status: props.filters.status, search: props.filters.search }, {

        replace: true
    });

});


let applicant1 = computed(() => props.applicants);
let scheduless = computed(() => props.schedules);
const dialogVisible = ref(false);
const disapprovedModalVisible = ref(false);

const openModal = (applicantDetails) => {
    form.id = applicantDetails.id
    form.uuid = applicantDetails.uuid;
    form.last_name = applicantDetails.last_name;
    form.first_name = applicantDetails.first_name;
    form.middle_name = applicantDetails.middle_name;
    form.dc_campus = applicantDetails.dc_campus;
    form.dc_course = applicantDetails.dc_course;

    dialogVisible.value = true;
    applicantId.value = applicantDetails.id;

}
const Opendisapproved = (applicantDetails) => {
    form.id = applicantDetails.id
    form.uuid = applicantDetails.uuid;
    form.last_name = applicantDetails.last_name;
    form.first_name = applicantDetails.first_name;
    form.middle_name = applicantDetails.middle_name;
    form.dc_campus = applicantDetails.dc_campus;
    form.dc_course = applicantDetails.dc_course;

    disapprovedModalVisible.value = true;
    applicantId.value = applicantDetails.id;

}
let form = {
    id: '',
    uuid: '',
    last_name: '',
    first_name: '',
    middle_name: '',
    suffix: '',
    dc_campus: '',
    dc_course: '',
};
const applicantId = ref('');

let applicationDetails = reactive({
    applicant_id: applicantId,
    exam_schedule_id: (props.schedules && Array.isArray(props.schedules) && props.schedules.length > 0) 
    ? props.schedules[0].id 
    : '',

    status: 'Pending',

})

const submit = async () => {
    try {
        const response = await axios.post('/count-total-applicant-inschedule', { schedule_id: applicationDetails.exam_schedule_id });

        const totalCount = response.data.count;
        const available = response.data.available; // Ensure this is part of your response

        if (totalCount <= available) {
            await axios.post('/save-sched', { applicationDetails: applicationDetails, applicantId: applicantId.value });
            dialogVisible.value = false;
            // Reload the page after successful submission
        }
    } catch (error) {
        console.error('Error updating timesheet:', error);
    }
    router.visit(window.location.href, { status: props.filters.status, search: props.filters.search }, {
        only: ['applicants', 'schedules', 'filters'],
    }) // Reload the page after successful submission
    // toastMessage.value = 'response.props.message'; 

};

const disapproved = async (applicantDetails) => {
    try {
        
            await axios.post('/disapproved-applicant', { applicationDetails: applicationDetails, applicantId: applicantId.value });
    disapprovedModalVisible.value = false;
        
    } catch (error) {
        console.error('Error updating timesheet:', error);
    }
    router.visit(window.location.href, { status: props.filters.status, search: props.filters.search }, {
        only: ['applicants', 'schedules', 'filters'],
    }) // Reload the page after successful submission
    // toastMessage.value = 'response.props.message'; 

};

const vieDetails = async (applicant) => {
    try {
        const response = await router.get('/gap/applicant/details', { applicantId: applicant.id });

    } catch (error) {
        console.error('Error updating timesheet:', error);
    }
 

};
const toastMessage = ref('');
</script>
<style>
.checkbox:checked+.check-icon {
    display: flex;
}
</style>
<template>
    <AppLayout>

        <Head title="Applicants" />
<!-- component -->
  <div class="px-4 pb-4 w-full">
    <div class="grid grid-cols-12 gap-4">
      <div class="col-span-12 sm:col-span-6 md:col-span-3">
        <div class="flex flex-row bg-white shadow-sm rounded p-4">
          <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-blue-100 text-blue-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
          </div>
          <div class="flex flex-col flex-grow ml-4">
            <div class="text-sm text-gray-500">Total Requests</div>
            <div class="font-bold text-lg">{{props.total_request}}</div>
          </div>
        </div>
      </div>
      <div class="col-span-12 sm:col-span-6 md:col-span-3">
        <div class="flex flex-row bg-white shadow-sm rounded p-4">
          <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-green-100 text-green-500">
                       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
          <div class="flex flex-col flex-grow ml-4">
            <div class="text-sm text-gray-500">Pending Requests</div>
            <div class="font-bold text-lg">{{props.total_request_pending}}</div>
          </div>
        </div>
      </div>
      <div class="col-span-12 sm:col-span-6 md:col-span-3">
        <div class="flex flex-row bg-white shadow-sm rounded p-4">
          <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-orange-100 text-orange-500">
                       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
             </div>
          <div class="flex flex-col flex-grow ml-4">
            <div class="text-sm text-gray-500">Approved Requests</div>
            <div class="font-bold text-lg">{{props.total_request_approved}}</div>
          </div>
        </div>
      </div>
      <div class="col-span-12 sm:col-span-6 md:col-span-3">
        <div class="flex flex-row bg-white shadow-sm rounded p-4">
          <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-red-100 text-red-500">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
  </div>
          <div class="flex flex-col flex-grow ml-4">
            <div class="text-sm text-gray-500">Disapproved Request</div>
            <div class="font-bold text-lg">{{props.total_request_disapproved}}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
        <el-dialog v-model="dialogVisible" title="Tips" width="500" :show-close="false" class="rounded-lg ">
            <template #header="{ close, titleId, titleClass }">
                <div class="my-header">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between  border-b border-dashed border-b-2  rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Set Exam Schedule
                        </h3>


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
            </template>
            
            <div class="relative px-4 pb-4 w-full max-w-2xl max-h-full">
                
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg  dark:bg-gray-700">
                    <!-- component -->

  
                    <p class="text-xl font-semibold mb-2">Examinees Information</p>
                    <div class="flex space-x-2 text-black-400 text-sm">
                        <!-- Location icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="font-black">{{ form.last_name }}, {{ form.first_name }} {{ form.middle_name }}</p>
                    </div>

                    <div class="flex space-x-2 text-black-400 text-sm my-2">
                        <!-- Location icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>

                        <p class="font-medium">{{ form.dc_course }}</p>
                    </div>
                    <div class="flex space-x-2 text-black-400 text-sm ">
                        <!-- Date icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="font-medium">{{ form.dc_campus }}</p>
                    </div>
                    <div class="border-b border-dashed border-b-2 my-2"></div>
                    <p class="text-xl font-semibold my-2">Schedule</p>


                    <form class="max-w-full mx-auto">
                        <select v-model="applicationDetails.exam_schedule_id" id="countries"
                            class="bg-gray-50 border border-blue-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                            <option v-for="schedule in props.schedules" :key="schedule.id" :value="schedule.id">{{
                                schedule.exam_date }} - Available({{ schedule.available }}) - {{ schedule.venue }}
                            </option>

                        </select>
                    </form>


                    <!-- Modal body -->
                    <form @submit.prevent="submit">

                        <button type="submit"
                            class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>

                    </form>
                </div>
            </div>

        </el-dialog>


        <!-- modal disapproved -->
        <el-dialog v-model="disapprovedModalVisible" title="Tips" width="500" :show-close="false" class="rounded-lg ">
            <template #header="{ close, titleId, titleClass }">
                <div class="relative  w-full max-h-full">
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <button @click="close" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to disapprove this Applicant?</h3>
                        <button @click="disapproved" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, I'm sure
                        </button>
                        <button @click="close" data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                    </div>
                </div>
            </div>
            </template>
            

        </el-dialog>
        <!-- component -->


        <!-- //table -->
        <!-- component -->
        <div class="sm:px-6 ">
            <Toast v-if="toastMessage" :message="toastMessage" @close="toastMessage = ''" />

            <!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->
          
            
            <div class="bg-white py-4 ">
                <div class="pb-3">
                <div class="flex items-center justify-between">
                    <p tabindex="0"
                        class="focus:outline-none text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-normal text-gray-800">
                        Admission Requests</p>
                    <div
                        class="py-3 flex items-center text-sm font-medium leading-none text-gray-600   cursor-pointer rounded">

                    </div>
                </div>
                <!-- <nav aria-label="breadcrumb" class="w-max">
    <ol class="flex w-full flex-wrap items-center rounded-md bg-blue-gray-50 bg-opacity-60 py-2">
      <li class="flex cursor-pointer items-center font-sans text-sm font-normal leading-normal text-blue-gray-900 antialiased transition-colors duration-300 hover:text-pink-500">
        <a class="opacity-60" href="#">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
          </svg>
        </a>
        <span class="pointer-events-none mx-2 select-none font-sans text-sm font-normal leading-normal text-blue-gray-500 antialiased">
          /
        </span>
      </li>
      <li class="flex cursor-pointer items-center font-sans text-sm font-normal leading-normal text-blue-gray-900 antialiased transition-colors duration-300 hover:text-pink-500">
        <a class="opacity-60" href="#">
          <span>Applicants</span>
        </a>
        <span class="pointer-events-none mx-2 select-none font-sans text-sm font-normal leading-normal text-blue-gray-500 antialiased">
          /
        </span>
      </li>
      <li class="flex cursor-pointer items-center font-sans text-sm font-normal leading-normal text-blue-gray-900 antialiased transition-colors duration-300 hover:text-pink-500">
        <a
          class="font-medium text-blue-gray-900 transition-colors hover:text-pink-500"
          href="#"
        >
          Requests
        </a>
      </li>
    </ol>
  </nav> -->
            </div>
                <div class="sm:flex items-center justify-between">
                    <div class="flex items-center">
                        <button type="button" @click="open = !open"
                            class="flex items-center text-gray-700 px-3 py-2 border font-medium rounded mr-2">
                            <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" class="w-5 h-5 mr-1">
                                <g class="">
                                    <path d="M0 0h24v24H0z" fill="none" class=""></path>
                                    <path
                                        d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z"
                                        class=""></path>
                                </g>
                            </svg>
                            Filter
                        </button>
                        <!-- <form class="max-w-sm mx-auto mr-2">
                            <select id="countries"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                <option>2024</option>
                                <option>2025</option>
                            </select>
                        </form>
                        <form class="max-w-sm mx-auto">
                            <select v-model="status" id="countries"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                <option>Pending</option>
                                <option>Approved</option>
                                <option>Disapproved</option>
                                <option>All</option>
                            </select>
                        </form>
 -->
 <form class="max-w-sm mx-auto">
                            <select v-model="schedule" id="countries"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled selected>Select an Schedule</option>
                           
                                <option v-for="submission_schedule in props.SubmissionSchedules" :key="submission_schedule.id" :value="submission_schedule.id">{{ submission_schedule.submission_date }} - {{ submission_schedule.venue }}</option>

                            </select>
                        </form>


                        <form class="max-w-sm mx-auto ml-2">
                            <div class="flex block">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-6">
                                        <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                                        <path fill-rule="evenodd"
                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                </span>
                                <input v-model="search" type="text" id="website-admin"
                                    class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Search Applicant">
                            </div>
                        </form>




                        <!-- <a class="rounded-full focus:outline-none focus:ring-2  focus:bg-indigo-50 focus:ring-indigo-800" href=" javascript:void(0)">
                            <div class="py-2 px-8 bg-indigo-100 text-indigo-700 rounded-full">
                                <p>All</p>
                            </div>
                        </a>
                        <a class="rounded-full focus:outline-none focus:ring-2 focus:bg-indigo-50 focus:ring-indigo-800 ml-4 sm:ml-8" href="javascript:void(0)">
                            <div class="py-2 px-8 text-gray-600 hover:text-indigo-700 hover:bg-indigo-100 rounded-full ">
                                <p>Done</p>
                            </div>
                        </a>
                        <a class="rounded-full focus:outline-none focus:ring-2 focus:bg-indigo-50 focus:ring-indigo-800 ml-4 sm:ml-8" href="javascript:void(0)">
                            <div class="py-2 px-8 text-gray-600 hover:text-indigo-700 hover:bg-indigo-100 rounded-full ">
                                <p>Pending</p>
                            </div>
                        </a> -->
                    </div>
                    <!-- <button onclick="popuphandler(true)"
                        class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-indigo-700 hover:bg-indigo-600 focus:outline-none rounded">
                        <p class="text-sm font-medium leading-none text-white">Add Applicant</p>
                    </button> -->

                </div>
                <div class="mt-7 ">
                    <table class="w-full">
                        <tbody>

                            <tr v-for="applicant in applicant1.data" :key="applicant.id">
                                <!-- {{ applicant }} -->
                                <div
                                    class="flex w-full mb-3 max-w-screen-xl border border-gray-100 transform cursor-pointer flex-col justify-between rounded-md bg-white bg-opacity-75 p-6 text-slate-800 transition duration-500 ease-in-out hover:-translate-y-1 hover:shadow-lg dark:bg-slate-700 dark:bg-opacity-25 dark:text-slate-300 lg:flex-row lg:p-3">
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
                                            <div
                                                class="w-full truncate text-md font-extrabold leading-5 tracking-tight uppercase">
                                                {{
                                                applicant.last_name }} {{ applicant.first_name }} {{
                                                applicant.middle_name }}
                                            </div>
                                            <div class="text-xs text-slate-500">ID:{{ applicant.uuid }}</div>
                                        </div>
                                    </div>

                                    <div class="z-50 hidden w-1/6 self-center lg:block">
                                        <div class="flex flex-row justify-center">
                                            <div x-data="{ tooltip: false }"
                                                class="relative z-0 -mr-4 inline-flex transition duration-300 ease-in-out hover:-mr-1"
                                                x-cloak>
                                                <img @mouseover="tooltip = true" @mouseleave="tooltip = false"
                                                    class="z-10 h-9 w-9 rounded-full border-2 border-white object-cover shadow hover:shadow-xl dark:border-slate-800"
                                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&w=128&h=128&q=60&facepad=1.5"
                                                    alt="Marilyn Monroe" />
                                                <span
                                                    class="absolute bottom-0 right-0 z-20 h-3 w-3 rounded-full border-2 border-slate-200 bg-green-400 dark:border-slate-800"></span>
                                                <div class="relative z-50 overflow-visible pt-2" x-cloak
                                                    x-show="tooltip"
                                                    x-transition:enter="transition ease-out duration-150"
                                                    x-transition:enter-start="transform opacity-0 translate-y-full"
                                                    x-transition:enter-end="transform opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-in duration-150"
                                                    x-transition:leave-start="transform opacity-100 translate-y-0"
                                                    x-transition:leave-end="transform opacity-0 translate-y-full">
                                                    <div
                                                        class="absolute -right-1 z-50 mt-1 w-40 -translate-x-10 -translate-y-5 transform overflow-x-hidden rounded-lg bg-blue-200 p-2 text-center leading-tight text-white shadow-md dark:bg-slate-900">
                                                        <div
                                                            class="text-slate-700 dark:text-slate-200 text-center text-base font-extrabold">
                                                            Marilyn Monroe</div>
                                                        <div class="text-slate-500 text-xs uppercase">Primary</div>
                                                    </div>
                                                    <svg class="absolute right-2 z-50 h-6 w-6 -translate-x-4 translate-y-0 transform fill-current stroke-current text-blue-200 dark:text-slate-900"
                                                        width="8" height="8">
                                                        <rect x="9" y="-8" width="8" height="8" transform="rotate(45)">
                                                        </rect>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div x-data="{ tooltip: false }"
                                                class="relative z-0 -mr-4 inline-flex transition duration-300 ease-in-out"
                                                x-cloak>
                                                <img @mouseover="tooltip = true" @mouseleave="tooltip = false"
                                                    class="z-10 h-9 w-9 rounded-full border-2 border-white object-cover shadow hover:shadow-xl dark:border-slate-800"
                                                    src="https://images.unsplash.com/photo-1554151228-14d9def656e4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&w=128&h=128&q=60&facepad=1.5"
                                                    alt="Salesperson" />
                                                <span
                                                    class="absolute bottom-0 right-0 z-20 h-3 w-3 rounded-full border-2 border-slate-200 bg-green-400 dark:border-slate-800"></span>
                                                <div class="relative z-50 overflow-visible pt-2" x-cloak
                                                    x-show="tooltip"
                                                    x-transition:enter="transition ease-out duration-150"
                                                    x-transition:enter-start="transform opacity-0 translate-y-full"
                                                    x-transition:enter-end="transform opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-in duration-150"
                                                    x-transition:leave-start="transform opacity-100 translate-y-0"
                                                    x-transition:leave-end="transform opacity-0 translate-y-full">
                                                    <div
                                                        class="absolute -right-1 z-50 mt-1 w-40 -translate-x-10 -translate-y-5 transform overflow-x-hidden rounded-lg bg-blue-200 p-2 text-center leading-tight text-white shadow-md dark:bg-slate-900">
                                                        <div
                                                            class="text-slate-700 dark:text-slate-200 text-center text-base font-extrabold">
                                                            Jimmy Stewart</div>
                                                        <div class="text-slate-500 text-xs uppercase">Secondary</div>
                                                    </div>
                                                    <svg class="absolute right-2 z-50 h-6 w-6 -translate-x-4 translate-y-0 transform fill-current stroke-current text-blue-200 dark:text-slate-900"
                                                        width="8" height="8">
                                                        <rect x="9" y="-8" width="8" height="8" transform="rotate(45)">
                                                        </rect>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full self-center pt-4 lg:w-1/2 lg:pt-0">
                                        <div class="ml-1">
                                            <div class="text-lg font-extrabold leading-5 tracking-tight">
                                                <span class="align-middle text-green-800">{{ applicant.dc_course
                                                    }}</span>
                                                <span
                                                    class="text-[8px]  ml-2 rounded  px-2 py-1 align-middle font-bold uppercase text-white"
                                                    :class="{ 'bg-green-600': applicant.status === 'Approved', 'bg-red-600': applicant.status === 'Disapproved', 'bg-orange-400': applicant.status !== 'Approved' }">{{ applicant.status }}</span>
                                            </div>
                                            <div class="text-sm text-slate-500">{{ applicant.dc_campus }}</div>
                                        </div>
                                    </div>
                                    <div class="w-full self-center pt-4 lg:w-1/5 lg:pt-0">
                                        <div class="">
                                            <div
                                                class="flex items-center text-lg font-extrabold leading-5 tracking-tight">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>

                                                <p class="text-sm leading-none text-gray-600 ml-2">
                                                    {{ applicant.created_at }}</p>
                                            </div>
                                            <div class="text-sm text-slate-500 pl-7">{{ applicant.created_at_human }}
                                            </div>
                                        </div>
                                    </div>


                                    <div
                                        class="w-full self-center px-1 pt-4 pb-2 lg:w-1/2 lg:px-0 lg:pt-0 lg:pb-0 center">
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
                                        <button @click="vieDetails(applicant)"
                                            class="focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-gray-600 py-2 px-2 bg-gray-100 rounded hover:bg-gray-200 focus:outline-none mr-2 "><svg
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                <path fill-rule="evenodd"
                                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                        </button>

                                        <button v-if="!applicant.schedule" @click="openModal(applicant)" type="button"
                                            class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-3.5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-1 mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6 mr-1">
                                                <path
                                                    d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                                <path fill-rule="evenodd"
                                                    d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            Set Schedule
                                        </button>
                                        <button v-else @click="openModal(applicant)" type="button"
                                            class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-3.5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-1 mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6 mr-1">
                                                <path
                                                    d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                                <path fill-rule="evenodd"
                                                    d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            {{ applicant.schedule }}
                                        </button>

                                        <button @click="Opendisapproved(applicant)"
                                            class="focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-white py-2 px-2 ml-1 bg-red-800 rounded hover:bg-red-700 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd"
                                                    d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                        </button>


                                    </div>
                                </div>
                            </tr>
                        </tbody>
                        <tfoot>
                            <div class="flex flex-col items-center mt-4">
                                <!-- Help text -->
                                <span class="text-sm text-gray-700 dark:text-gray-400">
                                    Showing <span class="font-semibold text-gray-900 dark:text-white">{{
                                        props.applicants.from
                                        }}</span> to <span
                                        class="font-semibold text-gray-900 dark:text-white">{{ props.applicants.to }}</span>
                                    of
                                    <span
                                        class="font-semibold text-gray-900 dark:text-white">{{ props.applicants.total }}</span>
                                    Entries
                                </span>
                                <div class="inline-flex mt-2 xs:mt-0">
                                    <!-- Buttons -->
                                    <a v-if="applicant1.links[0].url" :href="applicant1.prev_page_url"
                                        class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-s hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4" />
                                        </svg>
                                        Prev
                                    </a>
                                    <a v-if="applicant1.links[2].url" :href="applicant1.next_page_url"
                                        class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-s border-gray-700 rounded-e hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        Next
                                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


    </AppLayout>
</template>
<script>function dropdownFunction(element) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    let list = element.parentElement.parentElement.getElementsByClassName("dropdown-content")[0];
    list.classList.add("target");
    for (i = 0; i < dropdowns.length; i++) {
        if (!dropdowns[i].classList.contains("target")) {
            dropdowns[i].classList.add("hidden");
        }
    }
    list.classList.toggle("hidden");
}</script>