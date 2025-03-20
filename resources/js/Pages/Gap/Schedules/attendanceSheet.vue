<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import { ref, computed, watch, reactive } from 'vue'
import Welcome from '@/Components/Welcome.vue';
import { router, usePage, Link, Head } from '@inertiajs/vue3'
import { onMounted, onUpdated } from 'vue'
import debounce from 'lodash/debounce'
import { initFlowbite } from 'flowbite'
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader'
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
onMounted(() => {
  initFlowbite();

})
const { props } = usePage();
const dialogVisible = ref(false);
const result = ref(null);
const loading = ref(false);
/*** detection handling ***/
const resulted = ref('')
const exam_id = ref('')
const examinees = ref('')
const count = ref('')
const scanned = ref('')



/*** error handling ***/
const error = ref('')

watch(exam_id, async function (value) {
  try {

    const response = await axios.post('/get-examinees', {
      exam_id: value,
    });

    // Access the response data after awaiting
    examinees.value = response.data.applicant;
    count.value = response.data.count;
    scanned.value = response.data.scanned;

    console.log(response.data.applicant);

  } catch (error) {
    console.error('Error fetching data:', error);
    resulted.value = null; // Handle error appropriately
  } finally {
    loading.value = false; // Reset loading state
  }

  // onDetect('5ea14f98-fb41-4e6a-b828-1db60371038b');
  // try {
  //   const response = await axios.post('/get-examinee-details', {
  //     exam_id: "5ea14f98-fb41-4e6a-b828-1db60371038b",
  //     exam_schedule_id: value,
  //   });

  //   // Access the response data after awaiting
  //   resulted.value = response.data;
  //   console.log(response.data.applicant);

  // } catch (error) {
  //   console.error('Error fetching data:', error);
  //   resulted.value = null; // Handle error appropriately
  // } finally {
  //   loading.value = false; // Reset loading state
  // }
});

let generatePdf =() =>{
  const url = route('generate-attendance', { exam_id : exam_id.value})
  window.location.href = url 
console.log(url)
 

    
        }
        let generatePdfWithScanned =() =>{
  const url = route('generate-attendancewithscanned', { exam_id : exam_id.value})
  window.location.href = url  
 

    
        }
 

</script>
<style scoped>
.error {
  font-weight: bold;
  color: red;
}

.barcode-format-checkbox {
  margin-right: 10px;
  white-space: nowrap;
  display: inline-block;
}
</style>

<template>
  <AppLayout>

    <Head title="Registration" />


    <div class="m-2">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">



        <div
          class="w-full  p-4 bg-white border-dotted border-2 border-gray-200 rounded-lg   sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">


          <p class="error">{{ error }}</p>
          <div class="bg-white rounded-lg   ">
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <h3 class="text-lg font-bold mb-2 md:mb-0">
                  Attendance Overview:
                  <span class="text-blue-600">{{ scanned }}</span> /
                  <span class="text-gray-700">{{ count }}</span>
                </h3>

                <div class="relative flex-1 md:flex-none w-full md:w-64">
                  <input type="text" id="search" class="block p-2 pr-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full md:w-64 bg-gray-50 
            focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 
            dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search...">
                  <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                    </svg>
                  </div>
                </div>
              </div>


            <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
              <form class="max-w-full mx-auto">

                <div class="relative">
                  <select v-model="exam_id" id="exam-schedule"
                    class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">

                    <option v-for="schedule in props.Schedules" :key="schedule.id" :value="schedule.id">{{
                      schedule.exam_date }} - Available({{ schedule.available }}) - {{ schedule.venue }}
                    </option>

                  </select>
                  <label for="floating_helper"
                    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Select
                    Examination Schedule</label>
                </div>
 
                </form>
              <div
                class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between  m-2 ">
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
                      <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        #
                      </th>
                      <th scope="col" class="px-6 py-3">
                        Name
                      </th>
                      <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        Date Taken
                      </th>
                      <th scope="col" class="px-6 py-3">
                        Scanned By
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-b border-gray-200 dark:border-gray-700" v-for="(examinee, index) in examinees"
                      :key="examinee.id" :value="examinee.id">
                      <th scope="row"
                        class="px-6 py-4 font-medium text-black-800 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        {{ index + 1 }}
                      </th>
                      <td class="px-6 py-4">
                        {{ examinee.name.toUpperCase() }}
                      </td>
                      <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                        {{ examinee.date }}
                      </td>
                      <td class="px-6 py-4">
                        {{ examinee.scannedBy.toUpperCase() }}
                      </td>
                    </tr>

                </tbody>
              </table>
            </div>





          </div>

        </div>
      </div>
    </div>
  </AppLayout>
</template>
