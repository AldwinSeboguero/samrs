<script setup>
import { ref, computed, watch } from 'vue'
import Welcome from '@/Components/Welcome.vue';
import { router, usePage, Link } from '@inertiajs/vue3'
import { onMounted, onUpdated } from 'vue'
import debounce from 'lodash/debounce'
import InputError from '@/Components/InputError.vue';
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'

import {
    Combobox,
    ComboboxInput,
    ComboboxButton,
    ComboboxOptions,
    ComboboxOption,
    TransitionRoot,
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
    RadioGroup,
    RadioGroupLabel,
    RadioGroupDescription,
    RadioGroupOption,
    Dialog, DialogPanel, DialogTitle, TransitionChild
} from '@headlessui/vue'
const props = defineProps({
    employee: Object,
    filters: Object, 
    statuses: Object,



})
const amin = ref('')
amin.value = "2024-08-09"
let selectedStatus= ref('')
let query = ref('')

let filteredStatus = computed(() =>
    query.value === ''
        ? props.statuses
        : props.statuses.filter((status) =>
        status.name
                .toLowerCase()
                .replace(/\s+/g, '')
                .includes(query.value.toLowerCase().replace(/\s+/g, ''))
        )
)
const imageUrl = ref(null);

    const loadFile = (event) => {
      const file = event.target.files[0];
     

      if (file) {
        imageUrl.value = URL.createObjectURL(file);
        // Free memory when the image is loaded
        const img = new Image();
        img.src = imageUrl.value;
        img.onload = () => {
          URL.revokeObjectURL(imageUrl.value);
        };
      }
      else{
      }
    };
    const sex = [
  {
    name: 'Male', 
  },
  {
    name: 'Female', 
  }
]

const selected = ref(props.employee.gender)
</script> 
<template>


     <h1
                            class="text-xl font-semibold text-white sm:text-2xl dark:text-white  bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 py-2 px-4 rounded shadow-md">
                            Employee Information</h1>
    <div class="relative  w-full max-w-full max-h-full">

       
       
                        <!-- Modal content -->
                <div class="relative p-6  rounded-lg  dark:bg-gray-700">
                    <h1 class="text-3xl font-extrabold dark:text-white text-black mb-4">Employee<small class="ms-2 font-semibold text-gray-500 dark:text-gray-400">Profile</small></h1>
                    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                    <!-- Modal body -->
                    <form class="">
                        <div class="grid gap-4 mb-4 grid-cols-5">
                            
                            <div class="col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white font-black">Profile Picture</label>

                            <div
                            class="bg-gray-50 text-center px-4 
                                rounded max-w-md flex flex-col items-center 
                                justify-center cursor-pointer border-2 border-gray-400 border-dashed mx-auto font-[sans-serif]">
                            <div class=" mt-3" v-if="imageUrl">
                                <label class="shrink-0" for="uploadFile1">
                                        <img id="preview_img"  :src="imageUrl"  alt="Image Preview" class="w-full fill-gray-600 inline-block" />
                                    </label>
                            </div>
                            <div class="py-6" v-else>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 mb-2 fill-gray-600 inline-block" viewBox="0 0 32 32">
                                <path
                                    d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                                    data-original="#000000" />
                                <path
                                    d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                                    data-original="#000000" />
                                </svg>
                                <h4 class="text-base font-semibold text-gray-600">Drag and drop files here</h4>
                            </div>
                           
                            <hr class="w-full border-gray-400" />

                            <div class="py-2">
                                <input type="file" id='uploadFile1' class="hidden"  @change="loadFile" />
                                <label for="uploadFile1"
                                class="block px-6 py-2.5 rounded text-gray-600 text-sm tracking-wider font-semibold border-none outline-none cursor-pointer bg-gray-200 hover:bg-gray-100">Browse
                                Files</label>
                                <p class="text-xs text-gray-400 mt-4">PNG, JPG SVG, WEBP, and GIF are Allowed.</p>
                            </div>
                            </div>
                            <form class="mt-2  ml-2">
                                <div class="flex items-center space-x-6 ">
                                    <!-- <label class="shrink-0" for="uploadFile1">
                                        <img id="preview_img"  :src="imageUrl"  alt="Image Preview" class="h-16 w-16 object-cover rounded-full" />
                                    </label> -->
                                    <label class="block">
                                    <span class="sr-only">Choose profile photo</span>
                                
                                    <div class="hidden bg-white text-[#333] flex items-center shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] p-1 min-w-[300px] w-max font-[sans-serif] rounded-md overflow-hidden my-8 mx-auto">
                                    <div class="px-4 flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 612.675 612.675">
                                        <path d="M581.209 223.007 269.839 530.92c-51.592 51.024-135.247 51.024-186.839 0-51.592-51.023-51.592-133.737 0-184.761L363.248 69.04c34.402-34.009 90.15-34.009 124.553 0 34.402 34.008 34.402 89.166 0 123.174l-280.249 277.12c-17.19 17.016-45.075 17.016-62.287 0-17.19-16.993-17.19-44.571 0-61.587L394.37 161.42l-31.144-30.793-249.082 246.348c-34.402 34.009-34.402 89.166 0 123.174 34.402 34.009 90.15 34.009 124.552 0l280.249-277.12c51.592-51.023 51.592-133.737 0-184.761-51.593-51.023-135.247-51.023-186.839 0L36.285 330.784l1.072 1.071c-53.736 68.323-49.012 167.091 14.5 229.88 63.512 62.79 163.35 67.492 232.46 14.325l1.072 1.072 326.942-323.31-31.122-30.815z" data-original="#000000" />
                                        </svg>
                                        <p class="text-sm ml-3">{{img}}</p>
                                    </div>
                                    <label for="uploadFile1" class="   bg-gray-800 hover:bg-gray-700 text-white text-sm px-3 py-2.5 outline-none rounded-md cursor-pointer ml-auto w-max block">Upload</label>
                                    <input type="file" id='uploadFile1' class="hidden"  @change="loadFile"  />
                                    </div>
                                    </label>
                                </div>
                                </form>
                            </div>
                            <div class="col-span-4">
                                <div class="grid gap-4 mb-4 grid-cols-3">
                            <div class="col-span-1">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                                <input :value="props.employee.first_name" disabled type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                     required="">
                            </div>
                            <div class="col-span-1">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                                <input :value="props.employee.last_name" disabled type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                     required="">
                            </div>
                            <div class="col-span-1 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name </label>
                                <input type="text" id="time" :value="props.employee.middle_name" 
                                    class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    />

                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suffix Name</label>
                                <input type="text" id="time" :value="props.employee.suffix_name" 
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    />

                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salutation</label>
                                <input type="text" id="time" :value="props.employee.salutation" 
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                     />

                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="birthday" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Birth</label>
                                <input  datepicker
                                    type="text" 
                                    id="birthday" 
                                    class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                   :value="props.employee.birthday"
                                />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Preferred Name</label>
                                <input type="text" id="time" :value="props.employee.preferred_name" 
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    />

                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Sex</label>
                                
                                    <!-- <input id="bordered-radio-1" type="radio" value="" name="bordered-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="bordered-radio-1" class="w-1/2 py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 mr-4">Male</label>
                                    <input id="bordered-radio-2" type="radio" value="" name="bordered-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="bordered-radio-2" class="w-1/2 py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                                 -->
                                    <RadioGroup v-model="selected">
                                    <div class="space-y-2">
                                    <RadioGroupOption
                                        as="template"
                                        v-for="plan in sex"   
                                        :key="plan.name"
                                        :value="plan.name"
                                        v-slot="{ active, checked }"
                                    >
                                        <div
                                        :class="[
                                            active
                                            ? (plan.name == 'Male' ? 'ring-2 ring-white/60 ring-offset-2 ring-offset-sky-300 bg-blue-500 ' :'ring-2 ring-white/60 ring-offset-2 ring-offset-sky-300 bg-pink-500 text-white  ')
                                            : '',
                                            checked ?  (plan.name == 'Male' ? 'ring-2 ring-white/60 ring-offset-2 ring-offset-sky-300 bg-blue-500 text-white ' :' ring-2 ring-white/60 ring-offset-2 ring-offset-pink-300 bg-pink-500  '): 'bg-white text-black ',
                                        ]"
                                        
                                        class="relative flex cursor-pointer  px-3 py-2 shadow-md focus:outline-none w-1/2 inline-flex "
                                        >
                                        <div class="flex w-full items-inline justify-between">
                                            <div class="flex items-center">
                                            <div class="text-sm">
                                                <RadioGroupLabel
                                                as="p"
                                                :class="checked ? 'text-white' : 'text-gray-900'"
                                                class="font-medium"
                                                >
                                                {{ plan.name }}
                                                </RadioGroupLabel>
                                               
                                            </div>
                                            </div>
                                            <div v-show="checked" class="shrink-0 text-white">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                                                <circle
                                                cx="12"
                                                cy="12"
                                                r="12"
                                                fill="#fff"
                                                fill-opacity="0.2"
                                                />
                                                <path
                                                d="M7 13l3 3 7-7"
                                                stroke="#fff"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                />
                                            </svg>
                                            </div>
                                        </div>
                                        </div>
                                    </RadioGroupOption>
                                    </div>
                                </RadioGroup>
                                


                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Number</label>
                                <input type="text" id="time" :value="props.employee.contact_number" 
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    />

                            </div>
                            <div class="col-span-3 sm:col-span-3">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="text" id="time" :value="props.employee.email" 
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                      />

                            </div>
                        
                            
                        </div> 
                            </div>


                        </div>
                     
                        <!-- Employment Details -->
                         
                        <h1 class="text-3xl font-extrabold dark:text-white text-black my-4">Employment<small class="ms-2 font-semibold text-gray-500 dark:text-gray-400">Details</small></h1>
                        <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="grid gap-4 mb-4 grid-cols-3">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                <input type="text" id="time"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    />
                                    <div class="z-20 relative">
                                       
                                        <Combobox v-model="selectedStatus">
                                            <div class="relative mt-1 ">
                                                <div
                                                    class="relative   text-left  rounded-lg border border-gray-300 
                                                    sm:text-sm">
                                                    <ComboboxInput
                                                        class="w-full  border-none rounded-lg  text-sm leading-5 text-gray-900 focus:ring-0"
                                                        :displayValue="(status) => status.name"
                                                        @change="query = $event.target.value" />
                                                    <ComboboxButton
                                                        class="absolute inset-y-0 right-0 flex items-center pr-2 ">
                                                        <ChevronUpDownIcon class="h-5 w-5 text-gray-400"
                                                            aria-hidden="true" />
                                                    </ComboboxButton>
                                                </div>
                                                <TransitionRoot leave="transition ease-in duration-100"
                                                    leaveFrom="opacity-100" leaveTo="opacity-0" @after-leave="query = ''">
                                                    <ComboboxOptions
                                                        class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md 
                                                        bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm">
                                                        <div v-if="filteredStatus.length === 0 && query !== ''"
                                                            class="relative cursor-default select-none px-4 py-2 text-gray-700">
                                                            Nothing found.
                                                        </div>

                                                        <ComboboxOption v-for="status in filteredStatus" as="template"
                                                            :key="status.id" :value="status" v-slot="{ selected, active }">
                                                            <li class="relative cursor-default select-none py-2 pl-10 pr-4"
                                                                :class="{
                                                                    'bg-blue-100 text-black': active,
                                                                    'text-gray-900': !active,
                                                                }">
                                                                <span class="block truncate"
                                                                    :class="{ 'font-medium': selected, 'font-normal': !selected }">
                                                                    {{ status.name }}
                                                                </span>
                                                                <span v-if="selected"
                                                                    class="absolute inset-y-0 left-0 flex items-center pl-3"
                                                                    :class="{ 'text-blue': active, 'text-blue-600': !active }">
                                                                    <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                                </span>
                                                            </li>
                                                        </ComboboxOption>
                                                    </ComboboxOptions>
                                                </TransitionRoot>
                                            </div>
                                        </Combobox>
                                    </div>
                            </div>
                            <div class="col-span-1">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee Code</label>
                                <input  type="text" :value="props.employee.employee_code" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                     required="">
                            </div>
                            <div class="col-span-1">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee Type</label>
                                <input  :value="props.employee.employee_code"  disabled type="text" name="name" id="name" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                     required="">
                            </div>
                            <div class="col-span-1 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position/Job Title</label>
                                <input type="text" id="time"  :value="props.employee.employee_code" 
                                    class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    />

                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                                <input type="text" id="time"  :value="props.employee.employee_code" 
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    />

                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                                <input type="text" id="time"  :value="props.employee.employee_code" 
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                     />

                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Division</label>
                                <input  id="time"  :value="props.employee.employee_code" 
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    min="09:00" max="18:00" :disabled="pmout != '' && pmout !== 'SAT' && pmout !== 'SUN'"    />

                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Start Date</label>
                                <input type="text" id="date" datepicker    :value="props.employee.start_date" 
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    />

                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Report To</label>
                                    <input type="text" id="time"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    />


                            </div>
                            <div class="col-span-3  ">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Work Days</label>
                                <input type="text" id="time"  :value="props.employee.employee_code" 
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    />

                            </div>
                           
                            
                        </div>
                        <div class=" absolute right-0 p-6">
                            <button type="submit"
                            class="text-white mr-2 inline-flex  items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Delete Record
                        </button>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Update Record
                        </button>
                        </div>
                  
                    </form>
                </div>
            </div>
</template>