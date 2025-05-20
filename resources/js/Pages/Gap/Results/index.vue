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
// usePoll(2000, {
//     onStart() {
//         console.log('Polling request started')

//     },
//     onFinish() {
//         console.log('Polling request finished')
//     }
// })
const { props } = usePage();
let venue = ref(props.filters.venue);
let search = ref(props.filters.search);


watch(search, debounce(function (value) {

    router.get('/exam/results', { search: value}, {
     
     replace: true
 });
}, 500));
 

let loadingGenerate = ref(false);
const generateExcel = async () => {
    try {
        loadingGenerate.value = true; // Start loading state

        // Make the request to get the Excel file
        const response = await axios.get(route('generate-result-report'),  {
          
            responseType: 'blob', // Important: set responseType to 'blob'
        });

        // Create a Blob from the response
        const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

        // Create a link element to download the file
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'Exam Results '+'.xlsx'); // Specify the file name

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
let applicant1 = computed(() => props.applicants);
let scheduless = computed(() => props.schedules);
const dialogVisible = ref(false);
  
const applicantId = ref('');
const file = ref(null);
const message = ref('');



let applicationDetails = reactive({
    applicant_id: applicantId,
    exam_schedule_id: props.schedules ? props.schedules[0].id : '',

    status: 'Pending',

})
const importExamResults = async () => {
      const formData = new FormData();
      formData.append('file', file.value);
    console.log(formData);
      try {
        const response = await axios.post('/exam-results/import', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        message.value = 'Import successful!';
      } catch (error) {
        message.value = 'Import failed: ' + (error.response?.data?.message || error.message);
      }
    };
    const onFileChange = (event) => {
  if (event.target.files.length > 0) {
    file.value = event.target.files[0];
    console.log('File selected:', file.value);
  } else {
    file.value = null;
  }
};
    
const vieDetails = async (applicant) => {
    try {
        const response = await router.get('/gap/applicant/details', { applicantId: applicant.id });

    } catch (error) {
        console.error('Error updating timesheet:', error);
    }
 

};
const toastMessage = ref('');


const openModal = () => {

dialogVisible.value = true;

}


const openUpdateModal = (formData) => {
  console.log(formData)
form.id = formData.id;
applicant_name = formData.name;
form.percentile_rank = formData.pr;
form.reading = formData.r;
form.math = formData.m;
form.language = formData.l;
form.status_1 = formData.status_1.toUpperCase();
form.status_2 = formData.status_2.toUpperCase();
form.endorsed_for = formData.endorsed_for;
course_1 = formData.dc_course +" "+formData.dc_campus; 
course_2 = formData.dc_course1 +" "+formData.dc_campus1; 


dialogVisible.value = true;

}
let applicant_name = '';
let course_1 = '';
let course_2 = '';

let form = {
id: '', 
percentile_rank: '',
reading: '',
math: '',
language: '',
status_1: '',
status_2: '',
endorsed_for:'',



 



}; 
const submit = async () => {
try {
 
        await axios.post('/save-result', { resultData: form });
        dialogVisible.value = false;
  
} catch (error) {
    console.error('Error updating timesheet:', error);
}
router.visit(window.location.href, { status: props.filters.status, search: props.filters.search }, {
    only: ['filters'],
}) // Reload the page after successful submission
// toastMessage.value = 'response.props.message'; 

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
<el-dialog v-model="dialogVisible" title="Tips" width="600" :show-close="false" class="rounded-lg ">
            <template #header="{ close, titleId, titleClass }">
                <div class="my-header">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between  border-b border-dashed border-b-2  rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Exam Result
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

                    <form @submit.prevent="submit">
                        <div class="flex items-center space-x-2 text-black-400 text-sm mb-3">
   

     
</div>

<div class="relative w-full mt-1">
      <input type="text" id="small_filled"  v-model="applicant_name" disabled
        class="block rounded-t-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
      <label for="small_filled" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 left-2.5 z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">
          Applicant Name
        </label>
    </div> 
<div class="flex items-center space-x-2 text-black-400 text-sm mb-3">
     


<div class="relative w-full mt-1">
      <input type="text" id="small_filled"  v-model="form.percentile_rank"
        class="block rounded-t-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
      <label for="small_filled" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 left-2.5 z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">
           Percentile Rank
        </label>
    </div>

    <div class="relative w-full mt-2">
      <input type="text" id="small_filled"  v-model="form.reading"
        class="block rounded-t-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
      <label for="small_filled" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 left-2.5 z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">
           Reading
        </label>
    </div><div class="relative w-full mt-1">
      <input type="text" id="small_filled"  v-model="form.math"
        class="block rounded-t-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
      <label for="small_filled" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 left-2.5 z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">
           Math
        </label>
    </div>
<div class="relative w-full mt-2">
      <input type="text" id="small_filled"  v-model="form.language"
        class="block rounded-t-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
      <label for="small_filled" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 left-2.5 z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">
           Language
        </label>
    </div>
</div>

<div class="flex items-center space-x-2 text-black-400 text-sm mb-3 mt-2">
  <div class="relative w-full mt-1">
    <textarea  rows="4"  id="small_filled"  v-model="course_1" disabled
        class="block rounded-t-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
      <label for="small_filled" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 left-2.5 z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">
          Course 1
        </label>
    </div> 
    <div class="relative w-full mt-1">
      <textarea  rows="4"  id="small_filled"  v-model="course_2" disabled
        class="block rounded-t-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
      <label for="small_filled" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 left-2.5 z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">
          Course 2
        </label>
    </div> 
 </div>

<div class="flex items-center space-x-2 text-black-400 text-sm mb-3 mt-2">
    



    <div class="relative w-full">
        <select v-model="form.status_1" id="role" required
                    class="block rounded-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">

                    <option value="PASSED">
                      PASSED
                    </option>
                    <option value="WAITLISTED">
                      WAITLISTED
                    </option>
                    <option value="BELOW QUOTA">
                      BELOW QUOTA
                    </option>
                    <option value="NOT QUALIFIED">
                      NOT QUALIFIED
                    </option>
                    <option value="NOT APPLICABLE">
                      NOT APPLICABLE
                    </option>
                    <option value="BELOW CUTOFF SCORE">
                      BELOW CUTOFF SCORE
                    </option>

                  </select> 
                  <label for="role" 
                    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                    Select
                    Status 1</label>
    </div>

    <div class="relative w-full">
        <select v-model="form.status_2" id="role" required
                    class="block rounded-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">

                    <option value="PASSED">
                      PASSED
                    </option>
                    <option value="WAITLISTED">
                      WAITLISTED
                    </option>
                    <option value="BELOW QUOTA">
                      BELOW QUOTA
                    </option>
                    <option value="NOT APPLICABLE">
                      NOT APPLICABLE
                    </option>
                    <option value="NOT QUALIFIED">
                      NOT QUALIFIED
                    </option>
                    <option value="BELOW CUTOFF SCORE">
                      BELOW CUTOFF SCORE
                    </option>

                  </select> 
                  <label for="role" 
                    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                    Select
                    Status 2</label>
    </div>

   
</div>
<div class="relative w-full mt-1">
      <textarea  rows="4"  id="small_filled"  v-model="form.endorsed_for"
        class="block rounded-t-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
      <label for="small_filled" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 left-2.5 z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">
           Endorsed For
        </label>
    </div>      
                 
                 


                    <!-- Modal body -->

                        <button type="submit" v-if="form.id"
                            class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            
                            UPDATE RESULT</button>

                            <button type="submit" v-else
                            class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            
                            ADD NEW EXAM RESULT</button>

                    </form>
                </div>
            </div>

        </el-dialog>
<div class="m-2">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">



        <div
          class="w-full  p-4 bg-white border-dotted border-2 border-gray-200 rounded-lg   sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">


          <p class="error">{{ error }}</p>
          <div class="bg-white rounded-lg   ">
            
            <form @submit.prevent="importExamResults" method="POST" enctype="multipart/form-data">
 
 <input type="file" name="file" @change="onFileChange" accept=".xlsx,.csv" required>
<button type="submit" class="text-white   font-semibold text-xs my-auto mx-auto bg-gradient-to-r from-green-800 to-green-500 p-4 py-2 px-5 rounded-md">Import Exam Results</button>
 
</form>


            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <h3 class="text-lg font-bold mb-2 md:mb-0">
                    Examination Result
                </h3>

                   <!-- Align the search input and button to the right -->
    <div class="flex items-center md:ml-auto">
      <div class="relative flex-1 md:flex-none w-full md:w-64">
                  <input type="text" id="small_filled"  v-model="search"
        class="block rounded-t-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
        
  <label for="venue" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Search Applicant</label>
                </div>
              </div>
        
        <button @click="openModal"
                class="focus:ring-2 w-64 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-700 hover:bg-indigo-600 focus:outline-none rounded ml-3">
            <p class="text-sm font-medium leading-none text-white">Add Result</p>
        </button>
        
 <button @click="generateExcel()"       :disabled="loadingGenerate"
                        class="text-white   font-semibold text-xs  ml-2 bg-gradient-to-r from-green-800 to-green-500 p-4 py-2 px-5 rounded-md ">
                 
                        <span v-if="loadingGenerate">
                            <svg aria-hidden="true" role="status" class="inline size-3 mr-2 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    Generating...
                        </span>
                        <span v-else>   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="inline size-3 mr-2">
  <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.54 15h6.42l.5 1.5H8.29l.5-1.5Zm8.085-8.995a.75.75 0 1 0-.75-1.299 12.81 12.81 0 0 0-3.558 3.05L11.03 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 0 0 1.146-.102 11.312 11.312 0 0 1 3.612-3.321Z" clip-rule="evenodd" />
</svg>

                            Generate Report</span>
                         
                    </button>
    </div>
                


            <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
              <form class="max-w-full mx-auto">

                <div class="relative">
  
        
      
                </div>
 
                </form>
              <div
                class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4 m-2 ">
                <div class="col-span-1">
                  <form class="max-w-full mx-auto mb-4 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 ">
                   



                 
                      <!-- component --> 
                      <a v-if="exam_id" @click="generatePdfWithScanned" href="#" class="text-white w-full font-semibold text-xs pr-4 my-auto mx-auto bg-gradient-to-r from-red-800 to-red-500 p-4 py-2 px-5 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                          class="h-5 w-5 inline-block mr-1">
                          <path fill-rule="evenodd"
                            d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                            clip-rule="evenodd" />
                        </svg>
                        <span class="">PRINT SCANNED ATTENDANCE</span>
                      </a> 
                      <a v-if="exam_id" @click="generatePdf"  href="#"  class="text-white w-full font-semibold text-xs my-auto mx-auto bg-gradient-to-r from-red-800 to-red-500 p-4 py-2 px-5 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                          class="h-5 w-5 inline-block mr-1">
                          <path fill-rule="evenodd"
                            d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                            clip-rule="evenodd" />
                        </svg>
                        <span class="">PRINT ATTENDANCE</span>
                      </a> 
                  </form>
                </div>

              </div>
              
              <table class="w-full text-sm text-left rtl:text-right text-gray-600 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                  <tr>
                    <th scope="col" class="px-6 py-3   ">
                      Action
                    </th>
                    <th scope="col" class="  py-3 bg-gray-50 dark:bg-gray-800"  >
                      Exam ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                      Type
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                      Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                      Percentile Rank
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                      Reading
                    </th>
                    <th scope="col" class="px-6 py-3">
                      Math
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                      Language
                    </th>
                    <th scope="col" class="px-6 py-3">
                      Status 1
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                      Status 2
                    </th>
                    <th scope="col" class=""  >
                      Endorsed For
                    </th>
                   
                  </tr>
                </thead>
                <tbody> 
                  <tr class="border-b border-gray-200 dark:border-gray-700" v-for="(schedule, index) in props.exam_results.data"
                    :key="schedule.id" :value="schedule.id">
                    <td class="px-6 py-4">
                        <button  @click="openUpdateModal(schedule)" class="flex p-2.5 bg-green-500 rounded-xl hover:rounded-2xl hover:bg-yellow-600 transition-all duration-300 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        </button>
                    </td>
                    <th scope="row"
                      class="font-medium  text-wrap text-black-800   bg-gray-50 dark:text-white dark:bg-gray-800">
                      {{ schedule.uuid }} 
                    </th>
                    <td class="px-6 py-4">
                      {{ schedule.type.toUpperCase() }}
                    </td> 

                    <th scope="row"
                      class="px-6 py-4 font-medium text-black-800 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                      {{ schedule.name }} 
                    </th>
                    <td class="px-6 py-4">
                      {{ schedule.pr }}
                    </td> <th scope="row"
                      class="px-6 py-4 font-medium text-black-800 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                      {{ schedule.r }} 
                    </th>
                    <td class="px-6 py-4">
                      {{ schedule.m }}
                    </td> <th scope="row"
                      class="px-6 py-4 font-medium text-black-800 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                      {{ schedule.l }} 
                    </th>
                    <td class="px-6 py-4">
                      {{ schedule.status_1 }}
                    </td> <th scope="row"
                      class="px-6 py-4 font-medium text-black-800 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                      {{ schedule.status_2 }} 
                    </th>
                    <td class="min-w-xl">
                      {{ schedule.endorsed_for }}
                    </td> 
                   
                  </tr>

                </tbody>
              </table>
            </div>





          </div>

          <ul class="flex mt-4">
    <li>
      <a
        class="mx-1 flex h-9 w-9 items-center justify-center rounded-full border border-blue-gray-100 bg-transparent p-0 text-sm text-blue-gray-500 transition duration-150 ease-in-out hover:bg-light-300"
        href="#"
        aria-label="Previous"
      >
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
</svg>

      </a>
    </li>
    <li>
      <a
        class="mx-1 flex h-9 w-9 items-center justify-center rounded-full bg-pink-500 p-0 text-sm text-white shadow-md transition duration-150 ease-in-out"
        href="#"
      >
        1
      </a>
    </li>
    <li>
      <a
        class="mx-1 flex h-9 w-9 items-center justify-center rounded-full border border-blue-gray-100 bg-transparent p-0 text-sm text-blue-gray-500 transition duration-150 ease-in-out hover:bg-light-300"
        href="#"
      >
        2
      </a>
    </li>
    <li>
      <a
        class="mx-1 flex h-9 w-9 items-center justify-center rounded-full border border-blue-gray-100 bg-transparent p-0 text-sm text-blue-gray-500 transition duration-150 ease-in-out hover:bg-light-300"
        href="#"
      >
        3
      </a>
    </li>
    <li>
      <a
        class="mx-1 flex h-9 w-9 items-center justify-center rounded-full border border-blue-gray-100 bg-transparent p-0 text-sm text-blue-gray-500 transition duration-150 ease-in-out hover:bg-light-300"
        href="#"
        aria-label="Next"
      >
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
</svg>

      </a>
    </li>
  </ul>
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