<script setup>
</script>

<template>
     <h1
                            class="text-xl font-semibold text-white sm:text-2xl dark:text-white  bg-gradient-to-l from-indigo-950 via-blue-800 to-blue-800 py-2 px-4 rounded mb-3 shadow-md">
                            Grievances</h1>
    <div class="relative  w-full max-w-full max-h-full">
                <!-- Modal content -->
                <div class="relative p-6  rounded-lg  dark:bg-gray-700">

                    <!-- Modal body -->
                    <form class="">
                        <div class="grid gap-4 mb-4 grid-cols-3">
                            <div class="col-span-1">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                                <input value="" disabled type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type product name" required="">
                            </div>
                            <div class="col-span-1">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                                <input :value="transactionDate" disabled type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type product name" required="">
                            </div>
                            <div class="col-span-1 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name </label>
                                <input type="time" id="time"
                                    class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    min="09:00" max="18:00" :disabled="amin != '' && amin !== 'SAT' && amin !== 'SUN'"  :value="amin" />

                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suffix Name</label>
                                <input type="time" id="time"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    min="09:00" max="18:00" :disabled="amout != '' && amout !== 'SAT' && amout !== 'SUN'"  :value="amout" />

                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salutation</label>
                                <input type="time" id="time"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    min="09:00" max="18:00" :disabled="pmin != '' && pmin !== 'SAT' && pmin !== 'SUN'" :value="pmin" />

                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Birth</label>
                                <input type="date" id="time"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    min="09:00" max="18:00" :disabled="pmout != '' && pmout !== 'SAT' && pmout !== 'SUN'"  :value="pmout" />

                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Preferred Name</label>
                                <input type="time" id="time"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    min="09:00" max="18:00"  :value="otin"/>

                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Sex</label>
                                
                                    <input id="bordered-radio-1" type="radio" value="" name="bordered-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="bordered-radio-1" class="w-1/2 py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 mr-4">Male</label>
                                    <input checked id="bordered-radio-2" type="radio" value="" name="bordered-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="bordered-radio-2" class="w-1/2 py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                                



                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Number</label>
                                <input type="time" id="time"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    min="09:00" max="18:00" :value="otout" />

                            </div>
                            <div class="col-span-3 sm:col-span-3">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="time" id="time"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:border-slate-200 disabled:border-red-600 disabled:shadow-none"
                                    min="09:00" max="18:00" :value="otout" />

                            </div>
                            
                        </div>
                        <div class=" absolute right-0 ">
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