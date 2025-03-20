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
const toastMessage = ref('');
const Users = ref(props.Users.data);
const Roles = ref(props.Roles.data);

const role_id = ref('');
let search = ref(props.filters.search);

watch(role_id, async function (value) {
    try {

        const response = await axios.post('/management/getusers', {
        search: search.value,
        role_id: value
        });
        console.log(response);

        // Access the response data after awaiting
        Users.value = response.data.Users.data; 
        } catch (error) {
        console.error('Error fetching data:', error);

        } finally {

        }
});

watch(search,  async function (value) {
    try {

        const response = await axios.post('/management/getusers', {
        search: value,
        role_id: role_id.value
        });
        console.log(response);

        // Access the response data after awaiting
        Users.value = response.data.Users.data; 
        } catch (error) {
        console.error('Error fetching data:', error);
        
        } finally {
     
        }
 
} );
const dialogVisible = ref(false);
const updatedialogVisible = ref(false);


const openModal = () => {

    dialogVisible.value = true;

}


const openUpdateModal = (formData) => {
    form.id = formData.id;
    form.name = formData.name;
    form.email = formData.email;
    form.role = formData.role;

    dialogVisible.value = true;

}
let form = {
    id: '',
    name: '',
    email: '',
    role: '',

   
};
const getRoles = (roles) =>{
            if (!roles || roles.length === 0) return '';
            return roles.map(role => role.name).join(', '); // Assuming 'role.name' gives you the role title
        }
const submit = async () => {
    try {
     
            await axios.post('/save-user', { userData: form });
            dialogVisible.value = false;
      
    } catch (error) {
        console.error('Error updating timesheet:', error);
    }
    router.visit(window.location.href, { status: props.filters.status, search: props.filters.search }, {
        only: ['Schools', 'schedules', 'filters'],
    }) // Reload the page after successful submission
    // toastMessage.value = 'response.props.message'; 

};

const update = async () => {
    try {
     
            await axios.post('/update-school', { schoolData: form });
            dialogVisible.value = false;
      
    } catch (error) {
        console.error('Error updating timesheet:', error);
    }
    router.visit(window.location.href, { status: props.filters.status, search: props.filters.search }, {
        only: ['Schools', 'schedules', 'filters'],
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

    
<div class="m-2">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">



        <div
          class="w-full  p-4 bg-white border-dotted border-2 border-gray-200 rounded-lg   sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">


          <p class="error">{{ error }}</p>
          <div class="bg-white rounded-lg   ">
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
    <h3 class="text-lg font-bold mb-2 md:mb-0">
        User Management
    </h3>

    <!-- Align the search input and button to the right -->
    <div class="flex items-center md:ml-auto">
        <div class="relative w-full md:w-64">
            <input type="text" 
                v-model="search" 
                class="block p-2 pr-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 
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
        
        <button @click="openModal"
                class="focus:ring-2 w-64 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-700 hover:bg-indigo-600 focus:outline-none rounded ml-3">
            <p class="text-sm font-medium leading-none text-white">Add User</p>
        </button>
    </div>
</div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
              <form class="max-w-full mx-auto">

                <div class="relative">
                  <select v-model="role_id" id="exam-schedule"
                    class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">

                    <option v-for="Role in props.Roles" :key="Role.id" :value="Role.id">{{
                      Role.name }}  
                    </option>

                  </select>
                  <label for="floating_helper"
                    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Select
                    User Role</label>
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
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                     Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                      Email
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                      Role
                    </th>
                    <th scope="col" class="px-6 py-3">
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody> 
                  <tr class="border-b border-gray-200 dark:border-gray-700" v-for="(user, index) in Users"
                    :key="user.id" :value="user.id">
                    <th scope="row"
                      class="px-6 py-4 font-medium text-black-800 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                      {{ user.name.toUpperCase() }}
                    </th>
                    <td class="px-6 py-4">
                      {{ user.email.toLowerCase() }}
                    </td>
                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                      {{ getRoles(user.roles) }}
                    </td>
                    <td class="px-6 py-4">
                        <button  @click="openUpdateModal(user)" class="flex p-2.5 bg-green-500 rounded-xl hover:rounded-2xl hover:bg-yellow-600 transition-all duration-300 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        </button>
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

 
        <el-dialog v-model="dialogVisible" title="Tips" width="500" :show-close="false" class="rounded-lg ">
            <template #header="{ close, titleId, titleClass }">
                <div class="my-header">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between  border-b border-dashed border-b-2  rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            User Information
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
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"> 
  <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
</svg>

    <div class="relative w-full">
        <input type="text" id="small_filled" required v-model="form.name" class="block rounded-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
        <label for="small_filled" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 left-2.5 z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">
           Name
        </label>
    </div>
</div>

<div class="flex items-center space-x-2 text-black-400 text-sm mb-3">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">  
  <path fill-rule="evenodd" d="M17.834 6.166a8.25 8.25 0 1 0 0 11.668.75.75 0 0 1 1.06 1.06c-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788 3.807-3.808 9.98-3.808 13.788 0A9.722 9.722 0 0 1 21.75 12c0 .975-.296 1.887-.809 2.571-.514.685-1.28 1.179-2.191 1.179-.904 0-1.666-.487-2.18-1.164a5.25 5.25 0 1 1-.82-6.26V8.25a.75.75 0 0 1 1.5 0V12c0 .682.208 1.27.509 1.671.3.401.659.579.991.579.332 0 .69-.178.991-.579.3-.4.509-.99.509-1.671a8.222 8.222 0 0 0-2.416-5.834ZM15.75 12a3.75 3.75 0 1 0-7.5 0 3.75 3.75 0 0 0 7.5 0Z" clip-rule="evenodd" />
</svg>


    <div class="relative w-full">
        <input type="email" id="small_filled"  required v-model="form.email" class="block rounded-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
        <label for="small_filled" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 left-2.5 z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">
           Email
        </label>
    </div>
</div>

<div class="flex items-center space-x-2 text-black-400 text-sm mb-3">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">   
  <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08Zm3.094 8.016a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
</svg>



    <div class="relative w-full">
        <select v-model="form.role" id="role" required
                    class="block rounded-lg px-2.5 pb-1.5 pt-4 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">

                    <option v-for="Role in props.Roles" :key="Role.id" :value="Role.id">{{
                      Role.name }}  
                    </option>

                  </select> 
                  <label for="role" 
                    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Select
                    Role</label>
    </div>
</div>
                  
                 
                 


                    <!-- Modal body -->

                        <button type="submit" v-if="form.id"
                            class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            
                            UPDATE USER</button>

                            <button type="submit" v-else
                            class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            
                            ADD NEW USER</button>

                    </form>
                </div>
            </div>

        </el-dialog>
        <!-- component -->

 


    </AppLayout>
</template>

<style>
  
thead tr th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px;}
thead tr th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px;}

tbody tr td:first-child { border-top-left-radius: 5px; border-bottom-left-radius: 0px;}
tbody tr td:last-child { border-top-right-radius: 5px; border-bottom-right-radius: 0px;}


</style>
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