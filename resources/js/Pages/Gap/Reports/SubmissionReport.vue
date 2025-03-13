<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import { router, usePage, Link, Head, usePoll } from '@inertiajs/vue3' 

import { ref, computed, watch, reactive, onMounted } from 'vue'
import Applicants from '@/Pages/Profile/TableRow.vue'
import Toast from '@/Pages/Profile/Toast.vue';
import debounce from 'lodash/debounce'
import { initFlowbite } from 'flowbite'
import JsonExcel from 'vue-json-excel3';

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();

})
 
const { props } = usePage();
let search = ref(props.filters.search);
let schedule = ref(props.filters.schedule);
let loadingGenerate = ref(false);
let schedule_name = ref('');

let status = ref(props.filters.status || 'Pending');


watch(search, debounce(function (value) {

    router.get('/reports/submission-summary', { search: value, status: props.filters.status,schedule: props.filters.schedule }, {

        replace: true
    });
}, 500));
watch(status, function (value) {
    router.get('/reports/submission-summary', { status: value,schedule: props.filters.schedule, search: props.filters.search }, {

        replace: true
    });

});

watch(schedule, function (value) {
    router.get('/reports/submission-summary', {schedule: value, status: props.filters.status, search: props.filters.search }, {

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
    processed_by:props.auth.user.id,
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


const generateExcel = async () => {
    try {
        loadingGenerate.value = true; // Start loading state

        // Make the request to get the Excel file
        const response = await axios.get(route('generate-submission-report'),  {
            params: {
                schedule: schedule.value ? schedule.value.id : null,// Pass the schedule as a query parameter
            },
            responseType: 'blob', // Important: set responseType to 'blob'
        });

        // Create a Blob from the response
        const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

        // Create a link element to download the file
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'Applicants '+(schedule.value ? schedule.value.submission_date+' '+schedule.value.venue : '')+'.xlsx'); // Specify the file name

        // Append to the body and trigger the download
        document.body.appendChild(link);
        link.click();

        // Clean up
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url); // Free up memory

        loadingGenerate.value = false; // End loading state

    } catch (error) {
        console.error('Error generating report:', error);
        loadingGenerate.value = false; // Ensure loading is false on error
    }
};
const toastMessage = ref('');

const excelData = ref([]);

    const exportData = () => {
    //   Inertia.get('/export-excel', {}, {
    //     onSuccess: (response) => {
    //       // Assume response.data contains the data for Excel
    //       excelData.value = response.data;
    //     },
    //     onError: (error) => {
    //       console.error('Error fetching data:', error);
    //     },
    //   });
    };

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
 

<!-- Breadcrumb -->
<nav class="flex px-5 py-3 mb-4 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
  <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
    <li class="inline-flex items-center">
      <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
        </svg>
        Home
      </a>
    </li> 
    <li aria-current="page">
      <div class="flex items-center">
        <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg>
        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Master List</span>
      </div>
    </li>
  </ol>
</nav>

 
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
          
            
            <div class="bg-white ">
                <div class="pb-3">
                <div class="flex items-center justify-between">
                    <p tabindex="0"
                        class="focus:outline-none text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-normal text-gray-800">
                        Master List</p>
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
                           
                                <option v-for="submission_schedule in props.SubmissionSchedules" :key="submission_schedule.id" :value="submission_schedule">{{ submission_schedule.submission_date }} - {{ submission_schedule.venue }}</option>

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
                        <button @click="generateExcel()"       :disabled="loadingGenerate"
                        class="focus:ring-2 ml-2 focus:ring-offset-2 text-white focus:ring-green-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-3 py-2 bg-green-600 hover:bg-green-600 focus:outline-none rounded">
                 
                        <span v-if="loadingGenerate">
                            <svg aria-hidden="true" role="status" class="inline size-6 mr-2 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    Generating...
                        </span>
                        <span v-else>   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="inline size-6 mr-2">
  <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.54 15h6.42l.5 1.5H8.29l.5-1.5Zm8.085-8.995a.75.75 0 1 0-.75-1.299 12.81 12.81 0 0 0-3.558 3.05L11.03 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 0 0 1.146-.102 11.312 11.312 0 0 1 3.612-3.321Z" clip-rule="evenodd" />
</svg>

                            Generate Report</span>
                         
                    </button>

                  


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
                <div class="mt-7 border-y-2  border-dashed">

                    <div class="overflow-x-auto mt-6 ">

                        <table class="table-auto border-collapse   w-full">
                            <thead>
                            <tr class="rounded-lg text-sm font-medium text-gray-700 text-left" style="font-size: 0.9674rem">
                                <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Last Name</th>
                                <th class="px-4 py-2 " style="background-color:#f8f8f8">First Name</th>
                                <th class="px-4 py-2 " style="background-color:#f8f8f8">Middle Name</th>
                                <th class="px-4 py-2 " style="background-color:#f8f8f8">School</th>
                                <th class="px-4 py-2 " style="background-color:#f8f8f8">Date of Submmisson/Venue</th>
                                <th class="px-4 py-2 " style="background-color:#f8f8f8">Status</th>




                            </tr>
                            </thead>
                            <tbody class="text-sm  font-black text-gray-700">
                            <tr class="hover:bg-gray-100 border-b border-gray-200 py-10"
                            v-for="applicant in applicant1.data" :key="applicant.id"
                            >
                                <td class="px-4 py-4">{{applicant.last_name}}</td>
                                <td class="px-4 py-4">{{ applicant.first_name }}</td>
                                <td class="px-4 py-4">{{ applicant.middle_name }}</td>
                                <td class="px-4 py-4">{{ applicant.sla_school }}</td>
                                <td class="px-4 py-4">{{ applicant.subschedule }}-{{ applicant.venue }}</td>
                                <td class="px-4 py-4">{{ applicant.status }}</td>




                                
                                
                            </tr>
                            
                            </tbody>
                        </table>
                        </div>
                  
                </div>
            </div>
        </div>


    </AppLayout>
</template><script> 
import JsonExcel from 'vue-json-excel3';

export default {
  components: {
    downloadExcel: JsonExcel,
  },
  
};
</script>