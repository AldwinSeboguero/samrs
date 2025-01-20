<script setup>
import AppLayout from '@/Layouts/MyLayout2.vue';
import Welcome from '@/Components/Welcome.vue';
import RegistrationFOrm from '@/Pages/Profile/Registration.vue'
    import { router, usePage,Link ,Head} from '@inertiajs/vue3'
    import QRCodeVue3 from "qrcode-vue3";
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
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
               
                <!-- <div class="w-full  p-4 bg-white border-dotted border-2 border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700"> -->
   
                    <!-- <Welcome /> -->

    <div class="max-w-md ">
       


        <div class="relative bg-white py-6 px-6 rounded-3xl my-4 shadow-xl border">
    <!-- <div class="text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-pink-500 left-4 -top-6">
       
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
</svg>

    </div> -->
    <div class="mt-2">
        <span class="rounded-md bg-blue-400 px-2 py-1 text-xs uppercase text-white">{{ props.Application.status }}</span>
        <p class="text-xl font-semibold my-2">Examinees Information</p>
        <div class="flex space-x-2 text-black-400 text-sm">
            <!-- Location icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5" >
  <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
</svg>
            <p class="font-black uppercase">{{ props.Application.last_name }}, {{ props.Application.first_name }} {{ props.Application.middle_name }} {{ props.Application.suffix }}</p> 
        </div>

        <div class="flex space-x-2 text-black-400 text-sm my-2">
            <!-- Location icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" >
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
</svg>

            <p class="font-medium">{{props.Application.dc_course}}({{ props.Application.dc_campus }})</p> 
            <!-- <p class="font-medium">{{props.Application.dc_course1}}({{ props.Application.dc_campus1 }})</p>  -->

        </div>
        <div class="flex space-x-2 text-black-400 text-sm my-2">
            <!-- Location icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" >
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
</svg>

            <!-- <p class="font-medium">{{props.Application.dc_course}}({{ props.Application.dc_campus }})</p>  -->
            <p class="font-medium">{{props.Application.dc_course1}}({{ props.Application.dc_campus1 }})</p> 

        </div>
  
        <div class="border-b border-dashed border-b-2 my-5"></div>
        <p class="text-xl font-semibold my-2">Examination Schedule</p>

        <div class="flex space-x-2 text-black-400 text-sm">
            <!-- Location icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <p class="font-black">{{ props.ExamSchedule.venue }}</p> 
        </div>

    
        <div class="flex space-x-2 text-black-400 text-sm my-3">
            <!-- Date icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="font-medium">{{ props.ExamSchedule.exam_date }}</p> 
        </div>
        <div class="border-b border-dashed border-b-2 my-5"></div>

        <div class="flex justify-between">
            <div class="my-2">
                <p class="font-semibold text-base mb-2">Examinee ID</p>
                <div class="text-base text-gray-400 font-semibold">
                    <p>{{props.ExamSchedule.exam_schedule_id}}</p>
                </div>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="mt-4 pb-10">
            <p class="font-semibold text-base mb-2">QR Code</p>
            <div class="w-72 h-72 mx-auto">
                <QRCodeVue3
          :value=props.ExamSchedule.qr_link
          :qrOptions="{ typeNumber: 0, mode: 'Byte', errorCorrectionLevel: 'H' }"
          image="images/psu_logo.png"
          :imageOptions="{ hideBackgroundDots: true, imageSize: 0.4, margin: 0 }"
          :dotsOptions="{
            type: 'rounded',
            color: '#26249a',
            gradient: {
              type: 'linear',
              rotation: 0,
              colorStops: [
                { offset: 0, color: '#26249a' },
                { offset: 1, color: '#26249a' },
              ],
            },
          }"
          :backgroundOptions="{ color: '#ffffff' }"
          fileExt="png"
          :download="true"
          myclass="my-qur"
          imgclass="img-qr"
          downloadButton="rounded-lg mt-1 w-full bg-pink-500 p-3 font-sans text-xs font-bold uppercase text-white shadow-md shadow-pink-500/20 transition-all hover:shadow-lg hover:shadow-pink-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
          :downloadOptions="{ name: 'b7ba1e8f-2c5e-4d25-8c7f-0f529b4e1d69', extension: 'png' }"  
        />
            </div>
           
           
        </div>
        <div class="w-full  p-4 bg-white border-dotted border-2 border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 mt-6">
<h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white text-center">TESTING REMINDERS</h2>
<ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
    <li>
        Bring a pen and pencil (Mongol 2).
    </li>
    <li>
        Wear white t-shirt/Polo Shirt and Pants/Knee Length Skirt.
    </li>
    <li>
        Bring an ID or Brgy. Certification with Picture.
    </li>
    <li>
        Please come to the testing venue (  1 Hour) before
the exam schedule.
    </li>
    <li class="font-black">
        LATE EXAMINEES WILL BE NOT BE RESCHEDULED
EXCEPT
FOR EMERGENCY AND HEALTH REASONS.
    </li> 
</ul>
</div>
    </div>
</div>

       

    </div>
       
                </div>
            </div>
        <!-- </div> -->
    </AppLayout>
</template>
