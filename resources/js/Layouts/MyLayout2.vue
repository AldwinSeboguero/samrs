<script setup>
import { ref, computed, watch, reactive } from 'vue'
import Welcome from '@/Components/Welcome.vue';
import { router, usePage, Link, Head } from '@inertiajs/vue3'
import { onMounted, onUpdated } from 'vue'
import debounce from 'lodash/debounce'
import { Collapse } from 'flowbite';
import {
    initAccordions,
    initCarousels,
    initCollapses,
    initDials,
    initDismisses,
    initDrawers,
    initDropdowns,
    initModals,
    initPopovers,
    initTabs,
    initTooltips
} from 'flowbite'
const { props } = usePage();
const logout = () => {
        router.post(route('logout'));
    };
</script>
<template>

  <Head :title="title" />



  

<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-2xl p-4">
        <a href="https://gapms.parsu.edu.ph" class="flex items-center space-x-3 rtl:space-x-reverse">
          <div class="">
                    <img class="h-10 w-10" src="https://parsu.edu.ph/images/logo/NewPSUlogo.png" alt="ChitChat Logo">
                </div>
                <div>
                    <div class="text-md text-blue-950 font-black font-sans uppercase">Partido State University</div>
                    <p class="text-slate-500 text-sm md:text-md">Student-Applicant Management & Results System</p>
                    
                </div>
        </a> 
        <div class="flex items-center space-x-6 rtl:space-x-reverse">
            <!-- <a href="tel:5541251234" class="text-sm  text-gray-500 dark:text-white hover:underline">(555) 412-1234</a> -->
            <a href="#" @click="logout"  class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 me-2 font-black text-gray-800">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg></a>
        </div>
    </div>
</nav>
<nav class="bg-gray-50 dark:bg-gray-700">
    <div class="max-w-screen-2xl px-4 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li>
                    <a :href="route('home')" :active="route().current('home')" 
                     :class="{ 'bg-blue-500 p-3 font-sans text-xs font-bold uppercase rounded-3xl text-white shadow-md shadow-blue-500/20 transition-all ':  route().current('home') }" class="text-gray-900 dark:text-white focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" aria-current="page">Application</a>
                </li>
                <li>
                  <a 
                      v-if="props.ExamSchedule" 
                      :href="route('examschedule')" 
                      :active="route().current('examschedule')"  
                      :class="{
                          'bg-blue-500 p-3 font-sans text-xs font-bold uppercase rounded-3xl text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none': route().current('examschedule'),
                          'text-gray-900 dark:text-white': true
                      }"
                  >
                      Exam Schedule
                  </a>
                  <span 
                      v-else 
                      class="p-3 font-sans text-xs font-bold uppercase rounded-3xl text-gray-400 cursor-not-allowed">
                      Exam Schedule
                  </span>
              </li>
                <li>
                    <!-- <a  v-if="props.ExamResult" :href="route('examresults')" :active="route().current('examresults')"  :class="{ 'bg-blue-500 p-3 font-sans text-xs font-bold uppercase  rounded-3xl text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none':  route().current('examresults') }" class="text-gray-900 dark:text-white focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">Results</a> -->
                    <span 
                   
                      class="p-3 font-sans text-xs font-bold uppercase rounded-3xl text-gray-400 cursor-not-allowed">
                      Exam Result
                  </span>
                  </li>
                <li>
                    <a :href="route('announcements')" :active="route().current('announcements')"  :class="{ 'bg-blue-500 p-3 font-sans text-xs font-bold uppercase  rounded-3xl text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none':  route().current('announcements') }" class="text-gray-900 dark:text-white focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">Announcements</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


  <div class="">




    <div class="p-4  mt-1 ">

      <main>
        <div class="mt-2">
          <slot />
        </div>

      </main>
    </div>
  </div>

</template>

<!-- <script setup>   
    import { 
        initAccordions, 
        initCarousels, 
        initCollapses, 
        initDials, 
        initDismisses, 
        initDrawers, 
        initDropdowns, 
        initModals, 
        initPopovers, 
        initTabs, 
        initTooltips } from 'flowbite'
        import ApexCharts from 'apexcharts'

        import { ref, computed, watch,reactive } from 'vue' 
    import Welcome from '@/Components/Welcome.vue';
    import { router, usePage,Link ,Head} from '@inertiajs/vue3'
    import { onMounted,onUpdated } from 'vue' 
    import debounce from 'lodash/debounce'

    const { props } = usePage();

const showingNavigationDropdown = ref(false);

    // initialize components based on data attribute selectors
    onMounted(() => {
        initAccordions();
        initCarousels();
        initCollapses();
        initDials();
        initDismisses();
        initDrawers();
        initDropdowns();
        initModals();
        initPopovers();
        initTabs();
        initTooltips();
    //     const chart = new ApexCharts(document.getElementById("column-chart"), options);
    //   chart.render();
    })
    onUpdated(() =>{
     
    })
    const logout = () => {
        router.post(route('logout'));
    };
    
    
    const options = {
      colors: ["#1A56DB", "#FDBA8C"],
      series: [
        {
          name: "Organic",
          color: "#1A56DB",
          data: [
            { x: "Mon", y: 231 },
            { x: "Tue", y: 122 },
            { x: "Wed", y: 63 },
            { x: "Thu", y: 421 },
            { x: "Fri", y: 122 },
            { x: "Sat", y: 323 },
            { x: "Sun", y: 111 },
          ],
        },
        {
          name: "Social media",
          color: "#FDBA8C",
          data: [
            { x: "Mon", y: 232 },
            { x: "Tue", y: 113 },
            { x: "Wed", y: 341 },
            { x: "Thu", y: 224 },
            { x: "Fri", y: 522 },
            { x: "Sat", y: 411 },
            { x: "Sun", y: 243 },
          ],
        },
      ],
      chart: {
        type: "bar",
        height: "320px",
        fontFamily: "Inter, sans-serif",
        toolbar: {
          show: false,
        },
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: "70%",
          borderRadiusApplication: "end",
          borderRadius: 8,
        },
      },
      tooltip: {
        shared: true,
        intersect: false,
        style: {
          fontFamily: "Inter, sans-serif",
        },
      },
      states: {
        hover: {
          filter: {
            type: "darken",
            value: 1,
          },
        },
      },
      stroke: {
        show: true,
        width: 0,
        colors: ["transparent"],
      },
      grid: {
        show: false,
        strokeDashArray: 4,
        padding: {
          left: 2,
          right: 2,
          top: -14
        },
      },
      dataLabels: {
        enabled: false,
      },
      legend: {
        show: false,
      },
      xaxis: {
        floating: false,
        labels: {
          show: true,
          style: {
            fontFamily: "Inter, sans-serif",
            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
          }
        },
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
      },
      yaxis: {
        show: false,
      },
      fill: {
        opacity: 1,
      },
    }
    
    if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
      
    }


    
    
    </script> -->