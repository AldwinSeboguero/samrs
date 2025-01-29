<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import { ref, computed, watch,reactive } from 'vue' 
    import Welcome from '@/Components/Welcome.vue';
    import { router, usePage,Link ,Head} from '@inertiajs/vue3'
    import { onMounted,onUpdated } from 'vue' 
    import debounce from 'lodash/debounce'
import { initFlowbite } from 'flowbite'

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

let applicationDetails = reactive({
          last_name:props.applicant.last_name,
          first_name:props.applicant.first_name,
          middle_name:props.applicant.middle_name ,
          suffix:props.applicant.suffix ,
          street_address:props.applicant.street_address ,
          city_address:props.applicant.city_address ,
          province_address:props.applicant.province_address ,
          zip:props.applicant.zip ,
          civil_status_id:props.applicant.civil_status_id ,
          gender_id:props.applicant.gender_id ,
          birthday:props.applicant.birthday ,
          citizenship:props.applicant.citizenship ,
          place_birth:props.applicant.place_birth ,
          religion:props.applicant.religion ,
          contact_no:props.applicant.contact_no ,
          emergency_contact_name:props.applicant.emergency_contact_name ,
          emergency_contact_no:props.applicant.emergency_contact_no ,
          curriculum:props.applicant.curriculum ,
          sla_name:props.applicant.sla_name ,
          sla_address:props.applicant.sla_address ,
          sla_completed_year:props.applicant.sla_completed_year ,
          sla_track:props.applicant.sla_track ,
          sla_strand:props.applicant.sla_strand ,
          isPWD:props.applicant.isPWD ,
          isIPs:props.applicant.isIPs ,
          isSoloParent:props.applicant.isSoloParent ,
          isGIDAs:props.applicant.isGIDAs ,
          email: props.applicant.email,
          dc_campus:props.applicant.dc_campus ,
          dc_course:props.applicant.dc_course ,
          dc_course1:props.applicant.dc_course1 ,
          submission_schedule_id:props.applicant.submission_schedule_id ,


        })
</script>

<template>
    <AppLayout title="Edit Employee">
   
        <Head title="Registration" />

        <div class="m-2">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
      

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
                    <form @submit.prevent="submit" class="">
          <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
       
      <p class="mt-1 text-sm leading-6 text-gray-600">Please provide the following personal details. </p>

        <div class="mt-2 grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
          <div class="md:col-span-3">
            <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
            <div class="mt-2">
              <input v-model="applicationDetails.last_name" type="text" name="last-name" id="last-name" requiredd autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="md:col-span-3">
            <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
            <div class="mt-2">
              <input v-model="applicationDetails.first_name"  type="text" name="first-name" requiredd id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="md:col-span-3">
            <label for="middle-name" class="block text-sm font-medium leading-6 text-gray-900">Middle name</label>
            <div class="mt-2">
              <input v-model="applicationDetails.middle_name"  type="text" name="middle-name" id="middle-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
          
          <div class="md:col-span-3">
            <label for="middle-name" class="block text-sm font-medium leading-6 text-gray-900">Ext. (e.g Jr., II)</label>
            <div class="mt-2">
              <input v-model="applicationDetails.suffix"  type="text" name="middle-name" id="middle-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
          
          <div class="md:col-span-2 ">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">ZIP / Postal code</label>
            <div class="mt-2">
              <input v-model="applicationDetails.zip"  type="text" name="postal-code"  requiredd  id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
         
          <div class="md:col-span-2">
            <label for="region" class="block text-sm font-medium leading-6 text-gray-900">State / Province</label>
            <div class="mt-2">
              <input v-model="applicationDetails.province_address" readonly  requiredd  type="text" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="md:col-span-2 ">
            <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
            <div class="mt-2">
              <input v-model="applicationDetails.city_address" readonly requiredd  type="text" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

       
          <div class="md:col-span-3">
            <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Street address</label>
            <div class="mt-2">
              <input v-model="applicationDetails.street_address" type="text" name="street-address" id="street-address" autocomplete="street-address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
          <div class="md:col-span-3">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Contact Number</label>
            <div class="mt-2">
              <input v-model="applicationDetails.contact_no"  requiredd  type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            
          </div>
          <div class="md:col-span-2">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Civil Status</label>
            <div class="mt-2">
              <select v-model="applicationDetails.civil_status_id"  requiredd  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
              
                <option v-for="civil_status_id in props.CivilStatus" :key="civil_status_id.id" :value="civil_status_id.id">{{ civil_status_id.name }}</option>

              </select>
            </div>
          </div>
          <div class="md:col-span-2">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">gender_id</label>
            <div class="mt-2">
              <select v-model="applicationDetails.gender_id"  requiredd  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="gender in props.Gender" :key="gender.id" :value="gender.id">{{ gender.name }}</option>


              </select>
            </div>
          </div>
          
          <div class="md:col-span-2 ">
            <label for="city" class="block text-sm font-medium leading-6 text-gray-900">Birthday</label>
            <div class="mt-2">
              <input v-model="applicationDetails.birthday"   requiredd type="date" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

         

          <div class="md:col-span-2">
            <label for="region" class="block text-sm font-medium leading-6 text-gray-900">Place of Birth</label>
            <div class="mt-2">
              <input v-model="applicationDetails.place_birth"  requiredd  type="text" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

     

        

          <div class="md:col-span-2 sm:col-start1">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Person to contact in case of emergency </label>
            <div class="mt-2">
              <input v-model="applicationDetails.emergency_contact_name"  requiredd  type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="md:col-span-2 sm:col-start1">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Contact Number  </label>
            <div class="mt-2">
              <input v-model="applicationDetails.emergency_contact_no"  requiredd  type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>


        </div>
      </div>
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Educational Background</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">Please provide the following details regarding your educational history.</p>

        
        <div class="mt-4 grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
          <div class="md:col-span-6">
            <fieldset>
            
            <div class="mt-2 mb-4  space-y-6">
              <div class="flex items-center gap-x-3">
                <input v-model="applicationDetails.curriculum" value="SENIOR HIGH SCHOOL" id="push-everything" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                <label for="push-everything" class="block text-sm font-medium leading-6 text-gray-900">SENIOR HIGH SCHOOL</label>
              </div>
              <div class="flex items-center gap-x-3">
                <input v-model="applicationDetails.curriculum" value="OLD CURRICULUM"  id="push-email" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                <label for="push-email" class="block text-sm font-medium leading-6 text-gray-900">OLD CURRICULUM</label>
              </div>
              <div class="flex items-center gap-x-3">
                <input v-model="applicationDetails.curriculum" value="Alternative Learning System"  id="push-nothing" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                <label for="push-nothing" class="block text-sm font-medium leading-6 text-gray-900">Alternative Learning System</label>
              </div>
            </div>
          </fieldset>
          </div>

          <legend class="text-sm font-semibold leading-6 text-gray-900">SCHOOL LAST ATTENDED (please do not abbreviate)</legend>

          <div class="md:col-span-6 mt-0">
            
            <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Name of School </label>
           <div class="mt-2">
              <select v-model="applicationDetails.sla_name"  requiredd  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="school in props.Schools" :key="school.id">{{ school.name }} - {{ school.address }}</option>


              </select>
           
          </div>
          </div>

          <!-- <div class="sm:col-span-3">
            <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Address</label>
            <div class="mt-2">
              <input v-model="applicationDetails.sla_address"  requiredd  type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div> -->

          <div class="md:col-span-6">
            <label for="middle-name" class="block text-sm font-medium leading-6 text-gray-900">Year Completed </label>
            <div class="mt-2">
              <input  v-model="applicationDetails.sla_completed_year"  requiredd type="number" name="middle-name" id="middle-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
          
          <div class="col-span-full">
         <p class="mt-1 text-sm leading-6 text-gray-600 ">For Senior High School Graduates/Graduating Students:</p>
        </div>
          <div class="sm:col-span-6">
            <label for="middle-name" class="block text-sm font-medium leading-6 text-gray-900">Track and Strand </label>
            <div class="mt-2">
              <select v-model="applicationDetails.sla_track"  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="trackStrand in props.TrackStrand" :key="trackStrand.id">{{ trackStrand.code }} - {{ trackStrand.name }} - {{ trackStrand.track }} </option>


              </select>
            </div>
          </div>
          
       
          <!-- <div class="sm:col-span-3">
            <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Strand </label>
            <div class="mt-2">
              <input v-model="applicationDetails.sla_strand"  type="text" name="street-address" id="street-address" autocomplete="street-address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div> -->

          

        </div>
      
      </div>
      </div>
      <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Other Information</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">Please provide any additional details that may be relevant.</p>

        
        <div class="mt-4 grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
          <div class="md:col-span-6">
            <fieldset>
            <legend class="text-sm font-semibold leading-6 text-gray-900">By Email</legend>
            <div class="mt-6 space-y-6">
              <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                  <input v-model="applicationDetails.isPWD"  id="comments" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                </div>
                <div class="text-sm leading-6">
                  <label for="comments" class="font-medium text-gray-900">PWD</label>
                  <p class="text-gray-500">Are you a person with disability?</p>
                </div>
              </div>
              <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                  <input  v-model="applicationDetails.isIPs" id="candidates" name="candidates" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                </div>
                <div class="text-sm leading-6">
                  <label for="candidates" class="font-medium text-gray-900">IPs</label>
                  <p class="text-gray-500">Are you a member of indigenous group/community?</p>
                </div>
              </div>
              <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                  <input v-model="applicationDetails.isSoloParent"  id="offers" name="offers" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                </div>
                <div class="text-sm leading-6">
                  <label for="offers" class="font-medium text-gray-900">Solo Parent</label>
                  <p class="text-gray-500">Are you a Solo Parent or Child of a Solo Parent?</p>
                </div>
              </div>
              <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                  <input v-model="applicationDetails.isGIDAs"  id="offers" name="offers" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                </div>
                <div class="text-sm leading-6">
                  <label for="offers" class="font-medium text-gray-900">GIDAs</label>
                  <p class="text-gray-500">Are you a resident of Geographically Isolated and Disadvantaged Areas (GIDAs)?               </p>
                </div>
              </div>
            </div>
          </fieldset>
          </div>

         
        </div>
      
      </div>
</div>  
<div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Desired Course</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">Please indicate the course you wish to enroll in.</p>

        
        <div class="mt-4 grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
          
          <!-- <div class="md:col-span-3">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Campus</label>
            <div class="mt-2">
              <select v-model="applicationDetails.dc_campus"  requiredd   id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="campus in props.Campuses" :key="campus.id" :value="campus.id">{{ campus.name }}</option>
            

              </select>
            </div>
          </div> -->
          <div class="sm:col-span-6">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">1st Choice</label>
            <div class="mt-2">
              <select v-model="applicationDetails.dc_course"  requiredd  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="course in props.Courses" :key="course.id" :value="course.id">{{ course.campus }} - {{ course.name }}</option>


              </select>
            </div>
          </div>

          <div class="sm:col-span-6">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">2nd Choice</label>
            <div class="mt-2">
              <select v-model="applicationDetails.dc_course1"  requiredd  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="course in props.Courses" :key="course.id" :value="course.id">{{ course.campus }} - {{ course.name }}</option>


              </select>
            </div>
          </div>
<div class="sm:col-span-6">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Schedule</label>
            <div class="mt-2">
              <select   v-model="applicationDetails.submission_schedule_id"  required  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="submission_schedule in props.SubmissionSchedules" :key="submission_schedule.id" :value="submission_schedule.id">{{ submission_schedule.submission_date }} - {{ submission_schedule.venue }}</option>

              </select>
            </div>
          </div>
         
        </div>
      
      </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
      <!-- <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button> -->
      <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update Application Details</button>
    </div>
  </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
