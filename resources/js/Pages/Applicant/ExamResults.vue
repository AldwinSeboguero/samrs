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
const link = "https://samrs.parsu.edu.ph/examverification?exam="+props.ExamResult.uuid;

let generatePdf = () =>{
  const url = route('generate-result', { applicant_id: props.ExamResult.applicant_id})
  window.location.href = url
         
        }
        let goBack = () =>{
          window.history.back();

         
        } 
</script>

<template>
    <AppLayout title="Edit Employee">
   
        <Head title="Registration" />

        <div class="m-2">
            <div class="max-w-9xl mx-auto border sm:px-6 lg:px-8">
               
               
                    <!-- <Welcome /> -->

    <div class="max-w-9xl ">
        <!-- <div class="flex justify-between items-center py-4 px-6 bg-white shadow-md rounded-lg mb-4">
            <p class="text-xl font-semibold ">Examinatio Result</p>
    <button class="bg-red-700 text-white py-2 px-2 rounded-lg transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85]">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
</svg>

    </button>
</div> -->
  <div class="mx-auto flex max-w-2xl flex-col rounded-lg bg-white  shadow-lg sm:rounded-3xl sm:px-14 sm:pb-10 p-5">
    <div style="display: flex; justify-content: space-between; align-items: center;" class="">
              <span>
                <p class="text-xl font-semibold ">Examination Result</p>
                
              </span>


    <button @click="generatePdf" v-if="props.Application" type="submit" class="rounded-md bg-red-600 px-2 text-xs py-1 text-md font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 inline-block mr-1">
            <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
        </svg>
        
    </button>
</div>
 
    <hr class="mt-5" />
          
    <div style="font-family: Arial, sans-serif; text-align: center;">
<div style=" width: 100%; padding: 15px;  padding-bottom:20px; padding-top:10px;">
        <div style="font-size: 16px; font-weight: bold;">Percentile Rank</div>
        <div style="font-size: 60px; font-weight: bold;"> <span class="mt-2 text-center font-serif text-8xl font-bold text-blue-900 sm:mt-4 sm:text-6xl">{{ props.ExamResult.percentile_rank }}<p class="text-sm mt-4"></p> </span>
            <div style="font-weight: normal; font-size: 14px;" class="mb-6">School Ability</div>
        </div>
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <tr>
                <td style="border: none; text-align: center;">
                    <div style="font-weight: bold; font-size: 18px;">{{ props.ExamResult.reading }}</div>
                    <div style="font-weight: normal; font-size: 14px;">Reading</div>
                </td>
                <td style="border: none; text-align: center;">
                    <div style="font-weight: bold; font-size: 18px;">{{ props.ExamResult.math }}</div>
                    <div style="font-weight: normal; font-size: 14px;">Math</div>
                </td>
                <td style="border: none; text-align: center;">
                    <div style="font-weight: bold; font-size: 18px;">{{ props.ExamResult.language }}</div>
                    <div style="font-weight: normal; font-size: 14px;">Language</div>
                </td>
            </tr>
        </table>
    </div>

    </div>
 


    <table class="mt-4" style="width: 100%;">
        <thead>
            <th colspan="1"
                style="text-align: center; width:60%; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                COURSE & CAMPUS</th> 
                <th colspan="1"
                style="text-align: center; width:40%; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                Status</th> 
        </thead>

        <tr style="margin:0;padding:0;">
            <td class="font-black  text-left" style=" vertical-align:top; width: 60%;   padding-bottom:5px;  padding-top:5px;">
                {{ props.Application.dc_course }} {{ props.Application.dc_campus }}

            </td>
            <td style="vertical-align: top; width: 40%; padding-bottom: 5px; padding-top: 5px;">
    <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
        <button class="rounded-3xl bg-green-500 px-6 py-1 mt-2 text-white font-black">
            {{ props.ExamResult.status_1 }}
        </button>
    </div>
</td>

        </tr>

        <tr style="margin:0;padding:0;">
            <td class="font-black  text-left" style=" vertical-align:top; width: 60%;   padding-bottom:5px;  padding-top:5px;">
                {{ props.Application.dc_course1 }} {{ props.Application.dc_campus1 }}

            </td>
            <td style="vertical-align: top; width: 40%; padding-bottom: 5px; padding-top: 5px;">
    <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
        <button class="rounded-3xl bg-green-500 px-6 py-1 mt-2 text-white font-black">
            {{ props.ExamResult.status_2 }}
        </button>
    </div>
</td>

        </tr>
    </table>
    <table class="mt-4" style="width: 100%;">
        <thead>
            <th colspan="1"
                style="text-align: center; width:100%; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                ENDORSED FOR</th> 
        </thead>

        <tr style="margin:0;padding:0;">
            <td style=" vertical-align:top; width: 100%;  border: 1px solid black;  padding-bottom:5px;  padding-top:5px;">

            <div style="text-align: center; font-size: 16px;  min-height:20px;">
                {{ props.ExamResult.endorsed_for }}
                </div>

            </td>

        </tr>
    </table>
    <div class="border-b border-dashed border-b-2 my-5"></div>
 
    <div style="border: 1px solid black; width: 100%;" class="p-4">
        <div style=" font-weight: 100;  font-size: 14px; margin-left:10px">Legend:</div>
        <table style="width: 100%; border-collapse: collapse; margin:10px;">
            <tr>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal; padding-right: 10px;">
                    <strong> <u>PASSED</u></strong>
                    - The applicant met the required cut-off score and is qualified or has secured a slot for the program they applied for.
                </td>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal">
                    <strong> <u>NOT QUALIFIED</u></strong>
                    - The applicant did not meet the cut-off score for both the board and non-board programs and is not qualified to enter any programs offered by the university.
                </td>
            </tr>
            <tr>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal; padding-right: 10px;">
                    <strong><u>WAITLISTED</u></strong>
                     - The applicant has not met the required cut-off scores but admission to the University will depend on the availability of slots open by qualified applicants who did not confirm their slots.
                </td>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal">
                    <strong><u>BELOW CUTOFF SCORE</u></strong>
                     - The applicant has met the required cutoff scores but was outperformed by other examinees in their chosen programs. Admission to the University will depend on the availability of slots.
                </td>
            </tr>
            <tr>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal; padding-right: 10px;">
                    <strong> <u>BELOW QUOTA</u> </strong>
                     - The applicant did not meet the required cut-off score for Board
                     Programs but is qualified to apply to Non-Board Programs with available slots.
                </td>
                
            </tr>
        </table>
       
    </div>
        <div class="border-b border-dashed border-b-2 my-5"></div>

        <div class="flex justify-between">
            <div class="my-2">
                <p class="font-semibold text-base mb-2">Examinee ID</p>
                <div class="text-base text-gray-400 font-semibold">
                    <p>{{props.ExamResult.uuid}}</p>
                </div>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="mt-4 pb-10">
            <p class="font-semibold text-base mb-2">QR Code</p>
            <div class="w-72 h-72 mx-auto">
                <QRCodeVue3
          :value=link
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
          downloadButton="rounded-lg w-full bg-pink-500 p-3 font-sans text-xs font-bold uppercase text-white shadow-md shadow-pink-500/20 transition-all hover:shadow-lg hover:shadow-pink-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
          :downloadOptions="{ name: 'b7ba1e8f-2c5e-4d25-8c7f-0f529b4e1d69', extension: 'png' }"  
        />
            </div>
           
           
        </div>


  </div>

           
   

        <!-- <div class="bg-gray-200 p-4 rounded-lg">
            <h3 class="font-bold text-lg mb-2">ENDORSED FOR</h3>
            <table class="min-w-full border border-gray-300 bg-white text-center">
                <thead>
                    <tr class="bg-gray-300">
                        <th class="border border-gray-300 p-2">Programs</th>
                        <th class="border border-gray-300 p-2">Campus</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 p-2 text-xl font-bold">Bachelor of Science in Environmental Science </td>
                        <td class="border border-gray-300 p-2">Tinambac Campus</td>
                     
                    </tr>
                </tbody>
            </table>
        </div> -->
   
       
                </div>
            </div>
        </div>
    </AppLayout>
</template>
