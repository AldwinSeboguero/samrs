<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import { ref, computed, watch } from 'vue'
import Welcome from '@/Components/Welcome.vue';
import { router, usePage, Link } from '@inertiajs/vue3'
import { onMounted, onUpdated } from 'vue'
import debounce from 'lodash/debounce'
import InputError from '@/Components/InputError.vue';
import EmployeeProfile from '../Employee/Component/EmployeeProfile.vue'
import EmployeePosition from '../Employee/Component/EmployeePosition.vue'
import EmployeeGovernmentID from '../Employee/Component/EmployeeGovernmentID.vue'
import EmployeeAbsent from '../Employee/Component/EmployeeAbsent.vue'
import EmployeeAsset from '../Employee/Component/EmployeeAsset.vue'
import EmployeeDepenedent from '../Employee/Component/EmployeeDependent.vue'
import EmployeePriorEducation from '../Employee/Component/EmployeePriorEducation.vue'
import EmployeeFileAttachment from '../Employee/Component/EmployeeFileAttachment.vue'
import EmployeeGrievance from '../Employee/Component/EmployeeGrievance.vue'
import EmployeeRenewableDocument from '../Employee/Component/EmployeeRenewableDocuments.vue'
import EmployeeSkill from '../Employee/Component/EmployeeSkill.vue'
import EmployeeTraining from '../Employee/Component/EmployeeTraining.vue'
import EmployeeEligibility from '../Employee/Component/EmployeeEligibility.vue'





const props = defineProps({
    employee: Object,
    filters: Object, 



})
const activeButton = ref('employee-profile');
const setActive = (activeBtn) => {
    activeButton.value = activeBtn;
}
</script>

<template>
        <AppLayout title="Edit Employee">
            <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#"
                            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center ">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Edit Employee
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="flex flex-col mt-4">
            <div class="">
                <div class="grid grid-cols-8 gap-4 mb-4">
                 
                    <div class=" rounded   dark:bg-gray-800 col-span-12">
                        <!-- <h1
                            class="text-xl font-semibold text-white sm:text-2xl dark:text-white  bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 py-2 px-4 rounded mb-3 shadow-md">
                            Employees</h1> -->

                        

<div class="md:flex">
    <ul  id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist" class="flex-column space-y space-y-3 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0">
        <li >
            <a  @click="setActive('employee-profile')"  id="profile-tab" data-tabs-target="#profile" type="button" role="tab" href="#"  class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"   :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-profile' }" :active="activeButton == 'employee-profile'" aria-current="page">
                <svg class="w-4 h-4 me-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                </svg>
                Employee Information
            </a>
        </li>
        <li>
            <a @click="setActive('employee-position')"   id="position-tab" data-tabs-target="#position" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-position' }" 
            :active="activeButton == 'employee-position'">
                <svg class="w-4 h-4 me-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18"><path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/></svg>
                Position & Salaries
            </a>
        </li>
        <li>
            <a @click="setActive('employee-ids')"   id="ids-tab" data-tabs-target="#ids" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-ids' }" 
            :active="activeButton == 'employee-ids'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2 " >
                <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.92 7.47 7.47 0 0 1-3.522.877 7.47 7.47 0 0 1-3.522-.877.75.75 0 0 1-.351-.92ZM15 8.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15Z" clip-rule="evenodd" />
                </svg>

                Gevernment IDs
            </a>
        </li>
        <li>
            <a @click="setActive('employee-eligibility')"   id="eligibility-tab" data-tabs-target="#eligibility" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-eligibility' }" 
            :active="activeButton == 'employee-eligibility'"> 
              
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2  ">
                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                </svg>

                Eligibility
            </a>
        </li>
        <li>
            <a @click="setActive('employee-absent')"   id="absent-tab" data-tabs-target="#absent" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-absent' }" 
            :active="activeButton == 'employee-absent'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class="w-4 h-4 me-2  ">
                <path d="M12 11.993a.75.75 0 0 0-.75.75v.006c0 .414.336.75.75.75h.006a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75H12ZM12 16.494a.75.75 0 0 0-.75.75v.005c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H12ZM8.999 17.244a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.006ZM7.499 16.494a.75.75 0 0 0-.75.75v.005c0 .414.336.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H7.5ZM13.499 14.997a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.005a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.005ZM14.25 16.494a.75.75 0 0 0-.75.75v.006c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75h-.005ZM15.75 14.995a.75.75 0 0 1 .75-.75h.005a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75H16.5a.75.75 0 0 1-.75-.75v-.006ZM13.498 12.743a.75.75 0 0 1 .75-.75h2.25a.75.75 0 1 1 0 1.5h-2.25a.75.75 0 0 1-.75-.75ZM6.748 14.993a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z" />
                <path fill-rule="evenodd" d="M18 2.993a.75.75 0 0 0-1.5 0v1.5h-9V2.994a.75.75 0 1 0-1.5 0v1.497h-.752a3 3 0 0 0-3 3v11.252a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3V7.492a3 3 0 0 0-3-3H18V2.993ZM3.748 18.743v-7.5a1.5 1.5 0 0 1 1.5-1.5h13.5a1.5 1.5 0 0 1 1.5 1.5v7.5a1.5 1.5 0 0 1-1.5 1.5h-13.5a1.5 1.5 0 0 1-1.5-1.5Z" clip-rule="evenodd" />
                </svg>

                Absenses/Leaves
            </a>
        </li>
        <!-- <li>
            <a class="inline-flex items-center px-4 py-3 text-gray-400 rounded-lg cursor-not-allowed bg-gray-50 w-full dark:bg-gray-800 dark:text-gray-500">
                <svg class="w-4 h-4 me-2 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
            Assets</a>
        </li> -->
        <li>
            <a @click="setActive('employee-asset')"   id="asset-tab" data-tabs-target="#asset" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-asset' }" 
            :active="activeButton == 'employee-asset'">
             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2  ">
                <path fill-rule="evenodd" d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Zm7.5 0v.09a49.488 49.488 0 0 0-6 0v-.09a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5Zm-3 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                <path d="M3 18.4v-2.796a4.3 4.3 0 0 0 .713.31A26.226 26.226 0 0 0 12 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 0 1-6.477-.427C4.047 21.128 3 19.852 3 18.4Z" />
                </svg>

                Assets
            </a>
        </li>
        <li>
            <a @click="setActive('employee-dependent')"   id="dependent-tab" data-tabs-target="#dependent" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-dependent' }" 
            :active="activeButton == 'employee-dependent'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2  ">
                <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                </svg>

                Dependents
            </a>
        </li>
        <li>
            <a @click="setActive('employee-education')"   id="education-tab" data-tabs-target="#education" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-education' }" 
            :active="activeButton == 'employee-education'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class="w-4 h-4 me-2" >
                <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                </svg>

                Prior Educations
            </a>
        </li>
        <li>
            <a @click="setActive('employee-file-attachment')"   id="file-attachment-tab" data-tabs-target="#file-attachment" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-file-attachment' }" 
            :active="activeButton == 'employee-file-attachment'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2 ">
                <path fill-rule="evenodd" d="M18.97 3.659a2.25 2.25 0 0 0-3.182 0l-10.94 10.94a3.75 3.75 0 1 0 5.304 5.303l7.693-7.693a.75.75 0 0 1 1.06 1.06l-7.693 7.693a5.25 5.25 0 1 1-7.424-7.424l10.939-10.94a3.75 3.75 0 1 1 5.303 5.304L9.097 18.835l-.008.008-.007.007-.002.002-.003.002A2.25 2.25 0 0 1 5.91 15.66l7.81-7.81a.75.75 0 0 1 1.061 1.06l-7.81 7.81a.75.75 0 0 0 1.054 1.068L18.97 6.84a2.25 2.25 0 0 0 0-3.182Z" clip-rule="evenodd" />
                </svg>

                File Attachments
            </a>
        </li>
        <li>
            <a @click="setActive('employee-grievance')"   id="grievance-tab" data-tabs-target="#grievance" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-grievance' }" 
            :active="activeButton == 'employee-grievance'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2  " >
                <path fill-rule="evenodd" d="M11.484 2.17a.75.75 0 0 1 1.032 0 11.209 11.209 0 0 0 7.877 3.08.75.75 0 0 1 .722.515 12.74 12.74 0 0 1 .635 3.985c0 5.942-4.064 10.933-9.563 12.348a.749.749 0 0 1-.374 0C6.314 20.683 2.25 15.692 2.25 9.75c0-1.39.223-2.73.635-3.985a.75.75 0 0 1 .722-.516l.143.001c2.996 0 5.718-1.17 7.734-3.08ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75ZM12 15a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75v-.008a.75.75 0 0 0-.75-.75H12Z" clip-rule="evenodd" />
                </svg>

                Grievances
            </a>
        </li>
        <li>
            <a @click="setActive('employee-renewable-document')"   id="renewable-document-tab" data-tabs-target="#renewable-document" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-renewable-document' }" 
            :active="activeButton == 'employee-renewable-document'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2 ">
                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                </svg>

                Renewable Documents
            </a>
        </li>
        <li>
            <a @click="setActive('employee-skill')"   id="skill-tab" data-tabs-target="#skill" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-skill' }" 
            :active="activeButton == 'employee-skill'">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2 ">
                <path fill-rule="evenodd" d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z" clip-rule="evenodd" />
                </svg>

               

                Skills
            </a>
        </li>
        <li>
            <a @click="setActive('employee-training')"   id="training-tab" data-tabs-target="#training" type="button" role="tab" href="#" 
            class="inline-flex items-center px-4 py-3 rounded-lg w-56 dark:bg-blue-600"  
            :class="{ 'bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 hover:text-white text-white':  activeButton == 'employee-training' }" 
            :active="activeButton == 'employee-training'">  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2  ">
                <path d="M12 .75a8.25 8.25 0 0 0-4.135 15.39c.686.398 1.115 1.008 1.134 1.623a.75.75 0 0 0 .577.706c.352.083.71.148 1.074.195.323.041.6-.218.6-.544v-4.661a6.714 6.714 0 0 1-.937-.171.75.75 0 1 1 .374-1.453 5.261 5.261 0 0 0 2.626 0 .75.75 0 1 1 .374 1.452 6.712 6.712 0 0 1-.937.172v4.66c0 .327.277.586.6.545.364-.047.722-.112 1.074-.195a.75.75 0 0 0 .577-.706c.02-.615.448-1.225 1.134-1.623A8.25 8.25 0 0 0 12 .75Z" />
                <path fill-rule="evenodd" d="M9.013 19.9a.75.75 0 0 1 .877-.597 11.319 11.319 0 0 0 4.22 0 .75.75 0 1 1 .28 1.473 12.819 12.819 0 0 1-4.78 0 .75.75 0 0 1-.597-.876ZM9.754 22.344a.75.75 0 0 1 .824-.668 13.682 13.682 0 0 0 2.844 0 .75.75 0 1 1 .156 1.492 15.156 15.156 0 0 1-3.156 0 .75.75 0 0 1-.668-.824Z" clip-rule="evenodd" />
                </svg>
                Trainings
            </a>
        </li>
       
    </ul>
    <!-- <div class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Profile Tab</h3>
        <p class="mb-2">This is some placeholder content the Profile tab's associated content, clicking another tab will toggle the visibility of this one for the next.</p>
        <p>The tab JavaScript swaps classes to control the content visibility and styling.</p> 
    </div> -->
    <div id="default-tab-content" class="  text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
    <div class="hidden rounded-lg  dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <EmployeeProfile :employee = "props.employee"/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="position" role="tabpanel" aria-labelledby="position-tab">
        <EmployeePosition/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="ids" role="tabpanel" aria-labelledby="ids-tab">
        <EmployeeGovernmentID/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="absent" role="tabpanel" aria-labelledby="absent-tab">
        <EmployeeAbsent/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="asset" role="tabpanel" aria-labelledby="asset-tab">
        <EmployeeAsset/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="dependent" role="tabpanel" aria-labelledby="dependent-tab">
        <EmployeeDepenedent/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="education" role="tabpanel" aria-labelledby="education-tab">
        <EmployeePriorEducation/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="file-attachment" role="tabpanel" aria-labelledby="file-attachment-tab">
        <EmployeeFileAttachment/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="grievance" role="tabpanel" aria-labelledby="grievance-tab">
        <EmployeeGrievance/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="renewable-document" role="tabpanel" aria-labelledby="renewable-document-tab">
        <EmployeeRenewableDocument/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="skill" role="tabpanel" aria-labelledby="skill-tab">
        <EmployeeSkill/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="training" role="tabpanel" aria-labelledby="training-tab">
        <EmployeeTraining/>
    </div>
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800" id="eligibility" role="tabpanel" aria-labelledby="eligibility-tab">
        <EmployeeTraining/>
    </div>
</div>
</div>


                </div>
            </div>
            </div>


        </div>
        </AppLayout>
</template>