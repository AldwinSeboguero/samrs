<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import { ref, computed, watch,reactive } from 'vue' 
    import Welcome from '@/Components/Welcome.vue';
    import { router, usePage,Link ,Head} from '@inertiajs/vue3'
    import { onMounted,onUpdated } from 'vue' 
    import debounce from 'lodash/debounce'
    // const props = defineProps({
    //     Campuses : Object,
    //     Courses : Object,
    //     Schools : Object,
    //     TrackStrand : Object,
    //     Strands : Object,
    //     CivilStatus : Object,
    //     Gender : Object,
    //     filters : Object,
    //     auth: Object
    //     } )
    const { props } = usePage();
        // console.log(props.CivilStatus)
        let applicationDetails = reactive({

          last_name: props.Application ? props.Application.last_name : '',
          first_name: props.Application ? props.Application.first_name : '',
          middle_name: props.Application ? props.Application.middle_name : '',
          suffix: props.Application ? props.Application.suffix : '',
          street_address: props.Application ? props.Application.street_address : '',
          city_address: props.Application ? props.Application.city_address : '',
          province_address: props.Application ? props.Application.province_address : '',
          zip: props.Application ? props.Application.zip : '',
          civil_status_id: props.Application ? props.Application.civil_status_id : '',
          gender_id: props.Application ? props.Application.gender_id : '',
          birthday: props.Application ? props.Application.birthday : '',
          citizenship: props.Application ? props.Application.citizenship : '',
          place_birth: props.Application ? props.Application.place_birth : '',
          religion: props.Application ? props.Application.religion : '',
          contact_no: props.Application ? props.Application.contact_no : '',
          emergency_contact_name: props.Application ? props.Application.emergency_contact_name : '',
          emergency_contact_no: props.Application ? props.Application.emergency_contact_no : '',
          curriculum: props.Application ? props.Application.curriculum : '',
          sla_name: props.Application ? props.Application.sla_name : '',
          sla_address: props.Application ? props.Application.sla_address : '',
          sla_completed_year: props.Application ? props.Application.sla_completed_year : '',
          sla_track: props.Application ? props.Application.sla_track : '',
          sla_strand: props.Application ? props.Application.sla_strand : '',
          isPWD: props.Application ? props.Application.isPWD : '',
          isIPs: props.Application ? props.Application.isIPs : '',
          isSoloParent: props.Application ? props.Application.isSoloParent : '',
          isGIDAs: props.Application ? props.Application.isGIDAs : '',
          email: props.Application ? props.Application.dc_campus : props.auth.user.email, 
          dc_campus: props.Application ? props.Application.dc_campus : '',
          dc_course: props.Application ? props.Application.dc_course : '',
          dc_course1: props.Application ? props.Application.dc_course1 : '',
          type: props.Application ? props.Application.type : '',
          submission_schedule_id:  props.Application ? props.Application.submission_schedule_id : '',


        })
        watch(applicationDetails.sla_name, function (val) {
          // applicationDetails.sla_name = 
        });
    const user = props.auth.user;
    let SubSchedules = reactive(props.SubmissionSchedules);
        const searchTerm = ref('');
  const result = ref(null);
const loading = ref(false);

// Debounced function to handle the search logic
const searchZip = debounce(async (term) => {
  if (term.length < 4) {
    result.value = null; // Reset result if less than 4 characters
    return;
  }
 
  
  loading.value = true;
 
  try {
    const response = await axios.get('/getzip', {
      params: { search: term },
    });

    // Directly access the data returned from the response
    result.value = response.data; // Assuming your data is already in response.data
    applicationDetails.province_address = result.value.province;
    applicationDetails.city_address = result.value.city;
    console.log(result.value.region, ' ', result.value.province, ' ',result.value.city, ' ');
  } catch (error) {
    console.error('Error fetching data:', error);
    result.value = null; // Handle error appropriately
  } finally {
    loading.value = false;
  }
}, 100); // Adjust debounce delay as needed

// Watch for changes in the search term
watch(()=>applicationDetails.zip,
  (newTerm) => {
  // Call the debounced function
  console.log('Last Name changed from:', newTerm);
  searchZip(newTerm);
});

watch(()=>applicationDetails.dc_course1,
  (newTerm) => {
  // Call the debounced function
  const response =  axios.get('/getsubsched');
  SubSchedules.value = response;
  console.log('Last Name changed from:', props.SubmissionSchedules);
  // searchZip(newTerm);
});
        // watch(
        //   () => applicationDetails.zip,
        //   (value) => {
        //     router.get('/getzip',{search: value},{
        //         preserveState: true,
        //         replace: true
        //     });
        //     console.log('Last Name changed from:', value);
        //     // You can perform additional logic here
        //   }
        // );
        let submit = () =>{
          router.get('/application-details',{applicationDetails: applicationDetails})
          // router.visit(window.location.href, { method: 'get' })
        }

        let download =() =>{
    const url = route('download', { info: file })
    window.location.href = url
    
    l
}
let generatePdf = () =>{
  const url = route('generate-pdf', { applicantId: props.Application.uuid})
  window.location.href = url
         
        }
// applicationDetails.count = 1
// console.log(count.value)
// console.log(props.Campuses);
const currentYear = new Date().getFullYear();
    const years = ref([]);

    for (let year = currentYear; year >= 2000; year--) {
      years.value.push(year);
    }

</script>
<template>
   <div v-if="props.Application && !props.ExamSchedule" class="flex bg-yellow-100 rounded-lg p-4 mb-4 text-sm text-yellow-700" role="alert">
        <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700  pl-4" role="alert">
    <p class="font-bold">Important:</p>
    <p>You are scheduled for submission of PARSUCAT required documents on <strong>{{props.SubmissionSchedule.submission_date}}</strong>, at <strong>{{props.SubmissionSchedule.venue}}</strong>.</p>
</div>
    </div>

    <div v-if="props.Application && props.ExamSchedule" class="flex bg-green-100 rounded-lg p-4 mb-4 text-sm text-green-700" role="alert">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2">
  <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
</svg>
 <div class="bg-green-100 border-l-4 border-geen-500 text-green-700  pl-4" role="alert">
    <p class="font-bold">Important:</p>
    <p>Your Examination Schedule is now available.</p>
</div>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: center;">
              <div></div>

              <div>
                
                                <button v-if="props.Application" @click="generatePdf" type="submit" class="mr-2 mb-2  rounded-md bg-red-600 px-3 text-xs py-2 text-md font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 inline-block mr-1">
                        <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
                    </svg>
                    <span class="hidden sm:inline">PRINT PARSUCAT APPLICATION FORM</span>
                  </button>

                <a v-if="props.Application" href="SPR2024.docx" type="submit" class="rounded-md bg-blue-600 px-3 text-xs py-2 text-md font-semibold text-white  shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 inline-block mr-1">
                        <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                    </svg>
                    <span class="hidden sm:inline">STUDENT PERSONAL RECORD</span> 
                </a>
                      </div>
                  
                </div>
    <span>
                <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600 mb-3">Please provide the following personal details. </p>
              </span>
     <form @submit.prevent="submit" class="read-only">
          <div class="border-b border-gray-900/10 pb-12">
           
<label for="" class="block text-sm font-medium leading-6 text-gray-900 mt-4">Applicant Type</label>

 
<div class="flex items-center gap-x-4">
  <div class="flex items-center">
    <input 
      :disabled="props.Application" 
      v-model="applicationDetails.type" 
      value="Freshmen" 
      id="Freshmen" 
      name="Freshmen" 
      type="radio" 
      class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" 
    />
    <label 
      for="Freshmen" 
      class="ml-2 block text-sm font-medium leading-6 text-gray-900"
    >
      Freshmen
    </label>
  </div>
  <div class="flex items-center">
    <input 
      :disabled="props.Application" 
      v-model="applicationDetails.type" 
      value="Transferee" 
      id="Transferee" 
      name="Transferee" 
      type="radio" 
      class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" 
    />
    <label 
      for="transferee" 
      class="ml-2 block text-sm font-medium leading-6 text-gray-900"
    >
      Transferee
    </label>
  </div>
</div>
        <div class="mt-2 grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
        
          <div class="md:col-span-3">
            <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
            <div class="mt-2">
              <input  :disabled="props.Application"  v-model="applicationDetails.last_name" type="text" name="last-name" id="last-name" required autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="md:col-span-3">
            <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
            <div class="mt-2">
              <input :disabled="props.Application"   v-model="applicationDetails.first_name"  type="text" name="first-name" required id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="md:col-span-3">
            <label for="middle-name" class="block text-sm font-medium leading-6 text-gray-900">Middle name</label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.middle_name"  type="text" name="middle-name" id="middle-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
          
          <div class="md:col-span-3">
            <label for="middle-name" class="block text-sm font-medium leading-6 text-gray-900">Ext. (e.g Jr., II)</label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.suffix"  type="text" name="middle-name" id="middle-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
          
          <div class="md:col-span-2 ">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">ZIP / Postal code</label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.zip"  type="text" name="postal-code"  required  id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
         
          <div class="md:col-span-2">
            <label for="region" class="block text-sm font-medium leading-6 text-gray-900">State / Province</label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.province_address" readonly  required  type="text" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="md:col-span-2 ">
            <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.city_address" readonly required  type="text" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

       
          <div class="md:col-span-3">
            <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Street address</label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.street_address" type="text" name="street-address" id="street-address" autocomplete="street-address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
          <div class="md:col-span-3">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Contact Number</label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.contact_no"  required  type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            
          </div>
          <div class="md:col-span-2">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Civil Status</label>
            <div class="mt-2">
              <select :disabled="props.Application"  v-model="applicationDetails.civil_status_id"  required  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
              
                <option v-for="civil_status_id in props.CivilStatus" :key="civil_status_id.id" :value="civil_status_id.id">{{ civil_status_id.name }}</option>

              </select>
            </div>
          </div>
          <div class="md:col-span-2">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Sex</label>
            <div class="mt-2">
              <select :disabled="props.Application"  v-model="applicationDetails.gender_id"  required  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="gender in props.Gender" :key="gender.id" :value="gender.id">{{ gender.name }}</option>


              </select>
            </div>
          </div>
          
          <div class="md:col-span-2 ">
            <label for="city" class="block text-sm font-medium leading-6 text-gray-900">Birthday</label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.birthday"   required type="date" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <!-- <div class="md:col-span-2 sm:col-start-1">
            <label for="city" class="block text-sm font-medium leading-6 text-gray-900">Citizenship</label>
            <div class="mt-2">
              <input v-model="applicationDetails.citizenship"  required  type="text" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div> -->

          <div class="md:col-span-2">
            <label for="region" class="block text-sm font-medium leading-6 text-gray-900">Place of Birth</label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.place_birth"  required  type="text" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
<!-- 
          <div class="md:col-span-2">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Religion</label>
            <div class="mt-2">
              <input v-model="applicationDetails.religion"  required  type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div> -->

        

          <div class="md:col-span-2 sm:col-start1">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Person to contact in case of emergency </label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.emergency_contact_name"  required  type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="md:col-span-2 sm:col-start1">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Contact Number  </label>
            <div class="mt-2">
              <input :disabled="props.Application"  v-model="applicationDetails.emergency_contact_no"  required  type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
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
                <input :disabled="props.Application"  v-model="applicationDetails.curriculum" value="SENIOR HIGH SCHOOL" id="push-everything" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                <label for="push-everything" class="block text-sm font-medium leading-6 text-gray-900">SENIOR HIGH SCHOOL</label>
              </div>
              <div class="flex items-center gap-x-3">
                <input :disabled="props.Application"  v-model="applicationDetails.curriculum" value="OLD CURRICULUM"  id="push-email" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                <label for="push-email" class="block text-sm font-medium leading-6 text-gray-900">OLD CURRICULUM</label>
              </div>
              <div class="flex items-center gap-x-3">
                <input :disabled="props.Application"  v-model="applicationDetails.curriculum" value="Alternative Learning System"  id="push-nothing" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                <label for="push-nothing" class="block text-sm font-medium leading-6 text-gray-900">Alternative Learning System</label>
              </div>
            </div>
          </fieldset>
          </div>

          <legend class="text-sm font-semibold leading-6 text-gray-900">SCHOOL LAST ATTENDED (please do not abbreviate)</legend>

          <div class="md:col-span-6 mt-0">
            
            <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Name of School </label>
           <div class="mt-2">
              <select :disabled="props.Application"  v-model="applicationDetails.sla_name"  required  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="school in props.Schools" :key="school.id">{{ school.name }} - {{ school.address }}</option>


              </select>
           
          </div>
          </div>

          <!-- <div class="sm:col-span-3">
            <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Address</label>
            <div class="mt-2">
              <input v-model="applicationDetails.sla_address"  required  type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div> -->

          <div class="md:col-span-6">
            <label for="middle-name" class="block text-sm font-medium leading-6 text-gray-900">Year Completed </label>
            <div class="mt-2">
              <select :disabled="props.Application"   v-model="applicationDetails.sla_completed_year"  required type="number" name="middle-name" id="middle-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
 
              <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
            </select>
            </div>
          </div>
          
          <div class="col-span-full">
         <p class="mt-1 text-sm leading-6 text-gray-600 ">For Senior High School Graduates/Graduating Students:</p>
        </div>
          <div class="sm:col-span-6">
            <label for="middle-name" class="block text-sm font-medium leading-6 text-gray-900">Track and Strand </label>
            <div class="mt-2">
              <select :disabled="props.Application"  v-model="applicationDetails.sla_track"  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
            <!-- <legend class="text-sm font-semibold leading-6 text-gray-900">By Email</legend> -->
            <div class="mt-6 space-y-6">
              <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                  <input :disabled="props.Application"  v-model="applicationDetails.isPWD"  id="comments" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                </div>
                <div class="text-sm leading-6">
                  <label for="comments" class="font-medium text-gray-900">PWD</label>
                  <p class="text-gray-500">Are you a person with disability?</p>
                </div>
              </div>
              <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                  <input :disabled="props.Application"   v-model="applicationDetails.isIPs" id="candidates" name="candidates" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                </div>
                <div class="text-sm leading-6">
                  <label for="candidates" class="font-medium text-gray-900">IPs</label>
                  <p class="text-gray-500">Are you a member of indigenous group/community?</p>
                </div>
              </div>
              <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                  <input :disabled="props.Application"  v-model="applicationDetails.isSoloParent"  id="offers" name="offers" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                </div>
                <div class="text-sm leading-6">
                  <label for="offers" class="font-medium text-gray-900">Solo Parent</label>
                  <p class="text-gray-500">Are you a Solo Parent or Child of a Solo Parent?</p>
                </div>
              </div>
              <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                  <input :disabled="props.Application"  v-model="applicationDetails.isGIDAs"  id="offers" name="offers" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
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
              <select v-model="applicationDetails.dc_campus"  required   id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="campus in props.Campuses" :key="campus.id" :value="campus.id">{{ campus.name }}</option>
            

              </select>
            </div>
          </div> -->
          <div class="sm:col-span-6">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">1st Choice</label>
            <div class="mt-2">
              <select :disabled="props.Application"  v-model="applicationDetails.dc_course"  required  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="course in props.Courses" :key="course.id" :value="course.id">{{ course.campus }} - {{ course.name }}</option>

              </select>
            </div>
          </div>

          <div class="sm:col-span-6">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">2nd Choice</label>
            <div class="mt-2">
              <select :disabled="props.Application"  v-model="applicationDetails.dc_course1"  required  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="course in props.Courses" :key="course.id" :value="course.id">{{ course.campus }} - {{ course.name }}</option>

              </select>
            </div>
          </div>

         
        </div>
      
      </div>
    </div>
    
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Desired Venue For Documents Submission</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">Please indicate the date and venue for documents submission.</p>

        
        <div class="mt-4 grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
          
          <!-- <div class="md:col-span-3">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Campus</label>
            <div class="mt-2">
              <select v-model="applicationDetails.dc_campus"  required   id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="campus in props.Campuses" :key="campus.id" :value="campus.id">{{ campus.name }}</option>
            

              </select>
            </div>
          </div> -->
          <div class="sm:col-span-6">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Schedule</label>
            <div class="mt-2">
              <select :disabled="props.Application"  v-model="applicationDetails.submission_schedule_id"  required  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="submission_schedule in SubSchedules" :key="submission_schedule.id" :value="submission_schedule.id">{{ submission_schedule.submission_date }} - {{ submission_schedule.venue }}-(Available Slot: {{ submission_schedule.available }} )</option>

              </select>
            </div>
          </div>

       

         
        </div>
      
      </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
      <!-- <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button> -->
      <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" v-if="!props.Application">Submit</button>
    
    </div>
  </form>
</template>