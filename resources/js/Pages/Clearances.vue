<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import { ref, computed } from 'vue'
    import Welcome from '@/Components/Welcome.vue';
    import { router, usePage } from '@inertiajs/vue3'
    import { onMounted,onUpdated } from 'vue' 
    import { store } from '../store.js'
import {
  Combobox,
  ComboboxInput,
  ComboboxButton,
  ComboboxOptions,
  ComboboxOption,
  TransitionRoot,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
const props = defineProps(['table_data'])


const semesters = [
  { id: null, name: '' },
  { id: 1, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 2, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 3, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 4, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 5, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 6, name: 'Enrollment AY 2023-2024 2nd Semester' },
]

const colleges = [
  { id: null, name: '' },
  { id: 1, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 2, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 3, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 4, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 5, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 6, name: 'Enrollment AY 2023-2024 2nd Semester' },
]

const programs = [
  { id: null, name: '' },
  { id: 1, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 2, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 3, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 4, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 5, name: 'Enrollment AY 2023-2024 2nd Semester' },
  { id: 6, name: 'Enrollment AY 2023-2024 2nd Semester' },
]

let selected = ref(semesters[0])
let query = ref('')

let filteredPeople = computed(() =>

  query.value === ''
    ? semesters
    : semesters.filter((semesters) =>
    semesters.name
          .toLowerCase()
          .replace(/\s+/g, '')
          .includes(query.value.toLowerCase().replace(/\s+/g, ''))
      )
)

// onMounted(()=>{
// // router.visit('/submittedclearances', { page: 11 }, { preserveState: true,preserveScroll: false  }) 
// increment();
// })

</script>

<template>
    <AppLayout title="SubmittedClearance">
        <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                  <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                      <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                      Home
                    </a>
                  </li> 
                  <li>
                    <div class="flex items-center ">
                      <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                      <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Submitted Clearances  
                        <button @click="store.increment()">
    From B: {{ store.count }}
  </button>
                      </span>
                    </div>
                  </li>
                </ol>
            </nav>
        </div>
        

        <div class="flex flex-col mt-4">
    <div class="overflow-x-auto">
        <div class="grid grid-cols-8 gap-4 mb-4">
         <div class=" col-span-2">
                
            <h1 class="text-sm text-white sm:text-xl dark:text-white  bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 py-2 px-4 rounded mb-3 shadow-md font-sans inline-flex w-full"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2">
  <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
</svg>
FILTERS</h1>
            

            <form class="max-w-sm mx-auto">
            <div class="mb-3">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                <Combobox v-model="selected">
                    <div class="relative mt-1">
                        <div
                        class="relative bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500m"
                        >
                        <ComboboxInput
                            class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 bg-gray-50 text-gray-900 focus:ring-0"
                            :displayValue="(semesters) => semesters.name"
                            @change="query = $event.target.value"
                        />
                        <ComboboxButton
                            class="absolute inset-y-0 right-0 flex items-center pr-2"
                        >
                            <ChevronUpDownIcon
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                            />
                        </ComboboxButton>
                        </div>
                        <TransitionRoot
                        leave="transition ease-in duration-100"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                        @after-leave="query = ''"
                        >
                        <ComboboxOptions
                            class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"
                        >
                            <div
                            v-if="filteredPeople.length === 0 && query !== ''"
                            class="relative cursor-default select-none px-4 py-2 text-gray-700"
                            >
                            Nothing found.
                            </div>

                            <ComboboxOption
                            v-for="semester in filteredPeople"
                            as="template"
                            :key="semester.id"
                            :value="semesters"
                            v-slot="{ selected, active }"
                            >
                            <li
                                class="relative cursor-default select-none py-2 pl-10 pr-4"
                                :class="{
                                'bg-teal-600 text-white': active,
                                'text-gray-900': !active,
                                }"
                            >
                                <span
                                class="block truncate"
                                :class="{ 'font-medium': selected, 'font-normal': !selected }"
                                >
                                {{ semesters.name }}
                                </span>
                                <span
                                v-if="selected"
                                class="absolute inset-y-0 left-0 flex items-center pl-3"
                                :class="{ 'text-white': active, 'text-teal-600': !active }"
                                >
                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                </span>
                            </li>
                            </ComboboxOption>
                        </ComboboxOptions>
                        </TransitionRoot>
                    </div>
                    </Combobox>
            </div>
            <div class="mb-3">
                <label for="password" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">College</label>
                <Combobox v-model="selected">
                    <div class="relative mt-1">
                        <div
                        class="relative bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500m"
                        >
                        <ComboboxInput
                            class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 bg-gray-50 text-gray-900 focus:ring-0"
                            :displayValue="(colleges) => colleges.name"
                            @change="query = $event.target.value"
                        />
                        <ComboboxButton
                            class="absolute inset-y-0 right-0 flex items-center pr-2"
                        >
                            <ChevronUpDownIcon
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                            />
                        </ComboboxButton>
                        </div>
                        <TransitionRoot
                        leave="transition ease-in duration-100"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                        @after-leave="query = ''"
                        >
                        <ComboboxOptions
                            class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"
                        >
                            <div
                            v-if="filteredPeople.length === 0 && query !== ''"
                            class="relative cursor-default select-none px-4 py-2 text-gray-700"
                            >
                            Nothing found.
                            </div>

                            <ComboboxOption
                            v-for="colleges in filteredPeople"
                            as="template"
                            :key="colleges.id"
                            :value="colleges"
                            v-slot="{ selected, active }"
                            >
                            <li
                                class="relative cursor-default select-none py-2 pl-10 pr-4"
                                :class="{
                                'bg-teal-600 text-white': active,
                                'text-gray-900': !active,
                                }"
                            >
                                <span
                                class="block truncate"
                                :class="{ 'font-medium': selected, 'font-normal': !selected }"
                                >
                                {{ colleges.name }}
                                </span>
                                <span
                                v-if="selected"
                                class="absolute inset-y-0 left-0 flex items-center pl-3"
                                :class="{ 'text-white': active, 'text-teal-600': !active }"
                                >
                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                </span>
                            </li>
                            </ComboboxOption>
                        </ComboboxOptions>
                        </TransitionRoot>
                    </div>
                    </Combobox>
            </div>
            <div class="mb-5">
                <label for="repeat-password" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Program</label>
                <Combobox v-model="selectedPerson">
    <!-- Render children directly instead of an `input` -->
    <ComboboxInput
    class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 bg-gray-50 text-gray-900 focus:ring-0"
      as="template"
      @change="query = $event.target.value"
      :displayValue="(semesters) => semesters.name"
    >
      <input />
    </ComboboxInput>

    <ComboboxOptions>
      <ComboboxOption
        v-for="semesters in filteredPeople"
        :key="semesters.id"
        :value="semesters"
      >
        {{ semesters.name }}
      </ComboboxOption>
    </ComboboxOptions>
  </Combobox>
            </div>  
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Clear</button>
            </form>

            

        </div>
            <div class=" rounded   dark:bg-gray-800 col-span-6">
            <h1 class="text-xl font-semibold text-white sm:text-2xl dark:text-white  bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 py-2 px-4 rounded mb-3 shadow-md">Submitted Clearances</h1>

                <div class="sm:flex">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <form class="lg:pr-3" action="#" method="GET">
                    <label for="users-search" class="sr-only">Search</label>
                    <div class="relative mt-1 lg:w-64 xl:w-96">
                        <input type="text" name="email" id="users-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search for Students">
                    </div>
                    </form>
                    <!-- <div class="flex pl-0 mt-3 space-x-1 sm:pl-2 sm:mt-0">
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                        </a>
                    </div> -->
                </div>
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <!-- <button type="button" data-modal-target="add-user-modal" data-modal-toggle="add-user-modal" class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Add user
                    </button> -->
                    <a href="#" class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                        Export
                    </a>
                </div>
            </div>
            <div class="inline-block min-w-full mt-2 pr-1">
            <div class="overflow-hidden shadow">
                
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-white dark:bg-gray-700">
                        <tr>
                            <!-- <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all" class="sr-only">checkbox</label>
                                </div>
                            </th> -->
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                             
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Student No.
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Name
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Program
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Purpose
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Date Submitted
                            </th>
                            
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                      
                        <tr v-for="({ id,name, student_number, program,purpose,datesubmitted }, index) in $props.table_data.data"
                        :key="id" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                             
                        <td class="max-w-sm p-2 overflow-hidden text-sm font-black text-gray-800 truncate xl:max-w-xs dark:text-gray-400"></td>
                          
                            <td class="max-w-sm p-2 overflow-hidden text-sm font-black text-gray-800 truncate xl:max-w-xs dark:text-gray-400">{{student_number }}</td>
                            <td class="max-w-sm p-2 overflow-hidden text-sm font-black text-gray-800 truncate xl:max-w-xs dark:text-gray-400 text-wrap">{{name }}</td>
                            <td class="max-w-sm p-2 overflow-hidden text-sn font-normal text-gray-800 truncate xl:max-w-xs dark:text-gray-400 text-wrap">{{program }}</td>
                            <td class="max-w-sm p-2 overflow-hidden text-sm font-normal text-gray-800 truncate xl:max-w-xs dark:text-gray-400 text-wrap">{{purpose }}</td>
                            <td class="max-w-sm p-2 overflow-hidden text-sn font-normal text-gray-800 truncate xl:max-w-xs dark:text-gray-400">
                                
                                <span class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-grren-400">
                                <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                                </svg>
                                {{ datesubmitted }}
                                </span>
                            </td>

                             
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                
                                <a href="#" class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                    <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                                    Export
                                </a>

<!--  
                                <button data-modal-target="select-modal" data-modal-toggle="select-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Toggle modal
                                </button>
 
                                <div id="select-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                   
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                           
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Open Decision
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="select-modal">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                          
                                            <div class="p-4 md:p-5">
                                                <p class="text-gray-500 dark:text-gray-400 mb-4">Select your desired decision:</p>
                                                <ul class="space-y-4 mb-4">
                                                    <li>
                                                        <input type="radio" id="job-1" name="job" value="job-1" class="hidden peer" required />
                                                        <label for="job-1" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">                           
                                                            <div class="block">
                                                                <div class="w-full text-lg font-semibold text-green-600">
                                                                    <span class="inline-flex items-center justify-center w-6 h-6 me-2 font-semibold text-green-800 bg-green-100 rounded-full dark:bg-gray-700 dark:text-green-400">
                                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill="currentColor" d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z"/>
                                                                    <path fill="#fff" d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 0 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z"/>
                                                                    </svg>
                                                                    <span class="sr-only">Icon description</span>
                                                                    </span>
                                                                    Approve Request
                                                                </div>
                                                                <div class="w-full text-gray-500 dark:text-gray-400 text-wrap text-sm">This is to certify that the student mentioned above is cleared from any property and money responsibility as of
                                                                    this date.</div>
                                                            </div>
                                                            <svg class="w-8 h-8 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="job-2" name="job" value="job-2" class="hidden peer">
                                                        <label for="job-2" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                                                            <div class="block">
                                                                <div class="w-full text-lg font-semibold text-red-600">
                                                                    <span class="inline-flex items-center justify-center w-6 h-6 me-2 font-semibold text-red-800 bg-red-100 rounded-full dark:bg-gray-700 dark:text-green-400">
                                                                
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                                                    
                                                                        <path d="M15.73 5.5h1.035A7.465 7.465 0 0 1 18 9.625a7.465 7.465 0 0 1-1.235 4.125h-.148c-.806 0-1.534.446-2.031 1.08a9.04 9.04 0 0 1-2.861 2.4c-.723.384-1.35.956-1.653 1.715a4.499 4.499 0 0 0-.322 1.672v.633A.75.75 0 0 1 9 22a2.25 2.25 0 0 1-2.25-2.25c0-1.152.26-2.243.723-3.218.266-.558-.107-1.282-.725-1.282H3.622c-1.026 0-1.945-.694-2.054-1.715A12.137 12.137 0 0 1 1.5 12.25c0-2.848.992-5.464 2.649-7.521C4.537 4.247 5.136 4 5.754 4H9.77a4.5 4.5 0 0 1 1.423.23l3.114 1.04a4.5 4.5 0 0 0 1.423.23ZM21.669 14.023c.536-1.362.831-2.845.831-4.398 0-1.22-.182-2.398-.52-3.507-.26-.85-1.084-1.368-1.973-1.368H19.1c-.445 0-.72.498-.523.898.591 1.2.924 2.55.924 3.977a8.958 8.958 0 0 1-1.302 4.666c-.245.403.028.959.5.959h1.053c.832 0 1.612-.453 1.918-1.227Z" />
                                                                    </svg>

                                                                    <span class="sr-only">Icon description</span>
                                                                    </span>
                                                                    Disapproved Request
                                                                </div>
                                                                <div class="w-full text-gray-500 dark:text-gray-400 text-wrap text-sm">Student not cleared of property and money responsibility.</div>
                                                            </div>
                                                            <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                                                        </label>
                                                    </li>
                                                    
                                                </ul>
                                                <button class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Confirm
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>  -->


                            </td>
                        </tr>
                        
                        
                    </tbody>
                </table>
            
                <div class=" items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
    
    
    <div class="flex items-center mb-4 sm:mb-0">
        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        </a>
        <a href="#" class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
        </a>
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span class="font-semibold text-gray-900 dark:text-white">{{($props.table_data.current_page-1)* $props.table_data.per_page+1}} - {{($props.table_data.current_page * $props.table_data.per_page)}}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{$props.table_data.total}}</span></span>
    </div>
    <div class="flex items-center space-x-3">
        <a :href="props.table_data.links.prev" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            Previous
        </a>
        <a :href="props.table_data.links.next" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            Next
            <svg class="w-5 h-5 ml-1 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
        </a>
    </div>
            </div>
            </div>
        </div>
    </div>
</div>

         </div> 
         
      </div>
       
 
    </AppLayout>
</template>
 