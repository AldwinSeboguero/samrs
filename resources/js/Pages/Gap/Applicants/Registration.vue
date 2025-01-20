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
          last_name:'',
          first_name:'',
          middle_name:'',
          suffix:'',
          street_address:'',
          city_address:'',
          province_address:'',
          zip:'',
          civil_status_id:'',
          gender_id:'',
          birthday:'',
          citizenship:'',
          place_birth:'',
          religion:'',
          contact_no:'',
          emergency_contact_name:'',
          emergency_contact_no:'',
          curriculum:'',
          sla_name:'',
          sla_address:'',
          sla_completed_year:'',
          sla_track:'',
          sla_strand:'',
          isPWD:'',
          isIPs:'',
          isSoloParent:'',
          isGIDAs:'',
          email: props.auth.email,
          dc_campus:'',
          dc_course:'',
        })
        watch(applicationDetails.sla_name, function (val) {
          // applicationDetails.sla_name = 
        });
    const user = props.auth.user;

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
          router.post('/application-details',{applicationDetails: applicationDetails})
        }
// applicationDetails.count = 1
// console.log(count.value)
// console.log(props.Campuses);
</script>
<template>
     <form @submit.prevent="submit" class="">
          <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
        {{ user.name }}
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

          <div class="md:col-span-2 sm:col-start-1">
            <label for="city" class="block text-sm font-medium leading-6 text-gray-900">Citizenship</label>
            <div class="mt-2">
              <input v-model="applicationDetails.citizenship"  requiredd  type="text" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="md:col-span-2">
            <label for="region" class="block text-sm font-medium leading-6 text-gray-900">Place of Birth</label>
            <div class="mt-2">
              <input v-model="applicationDetails.place_birth"  requiredd  type="text" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="md:col-span-2">
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Religion</label>
            <div class="mt-2">
              <input v-model="applicationDetails.religion"  requiredd  type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
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
            <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Course</label>
            <div class="mt-2">
              <select v-model="applicationDetails.dc_course"  requiredd  id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option></option>
                <option v-for="course in props.Courses" :key="course.id" :value="course.id">{{ course.campus }} - {{ course.name }}</option>

              </select>
            </div>
          </div>

         
        </div>
      
      </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
      <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
      <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
    </div>
  </form>
</template>