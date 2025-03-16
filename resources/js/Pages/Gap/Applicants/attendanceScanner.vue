<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import { ref, computed, watch, reactive } from 'vue'
import Welcome from '@/Components/Welcome.vue';
import { router, usePage, Link, Head } from '@inertiajs/vue3'
import { onMounted, onUpdated } from 'vue'
import debounce from 'lodash/debounce'
import { initFlowbite } from 'flowbite'
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader'
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
const dialogVisible = ref(false);
const result = ref(null);
const loading = ref(false);
/*** detection handling ***/
const resulted = ref('')
const exam_id = ref('')
const examinees = ref('')
const count = ref('')
const scanned = ref('')




async function onDetect(detectedCodes) {
  console.log(detectedCodes[0]?.rawValue);

  // Set loading state if necessary
  loading.value = true;
  const rawValue = detectedCodes[0]?.rawValue;

// Check if rawValue exists and remove the substring
// const cleanedValue = rawValue ? rawValue.replace('https://samrs.parsu.edu.ph/examverification?exam=', '') : '';
 
  try {
    const response = await axios.post('/get-examinee-details', {
      exam_id: rawValue,
      exam_schedule_id: exam_id,
    });

    // Access the response data after awaiting
    resulted.value = response.data;
    console.log(response.data.applicant);

  } catch (error) {
    console.error('Error fetching data:', error);
    resulted.value = null; // Handle error appropriately
  } finally {
    loading.value = false; // Reset loading state
  }
  try {
    const response = await axios.post('/get-examinees', {
      exam_id: exam_id,
    });

    // Access the response data after awaiting
    examinees.value = response.data.applicant;
    count.value = response.data.count;
    scanned.value = response.data.scanned;
    console.log(response.data.applicant);

  } catch (error) {
    console.error('Error fetching data:', error);
    resulted.value = null; // Handle error appropriately
  } finally {
    loading.value = false; // Reset loading state
  }
}

/*** select camera ***/
const selectedConstraints = ref({ facingMode: 'environment' })
const defaultConstraintOptions = [
  { label: 'Rear Camera', constraints: { facingMode: 'environment' } },
  { label: 'Front Camera', constraints: { facingMode: 'user' } }
]
const constraintOptions = ref(defaultConstraintOptions)

async function onCameraReady() {
  const devices = await navigator.mediaDevices.enumerateDevices()
  const videoDevices = devices.filter(({ kind }) => kind === 'videoinput')

  constraintOptions.value = [
    ...defaultConstraintOptions,
    ...videoDevices.map(({ deviceId, label }) => ({
      label: `${label} (ID: ${deviceId})`,
      constraints: { deviceId }
    }))
  ]

  error.value = ''
}

/*** track functions ***/
function paintOutline(detectedCodes, ctx) {
  for (const detectedCode of detectedCodes) {
    const [firstPoint, ...otherPoints] = detectedCode.cornerPoints

    ctx.strokeStyle = 'red'
    ctx.beginPath()
    ctx.moveTo(firstPoint.x, firstPoint.y)
    for (const { x, y } of otherPoints) {
      ctx.lineTo(x, y)
    }
    ctx.lineTo(firstPoint.x, firstPoint.y)
    ctx.closePath()
    ctx.stroke()
  }
}

function paintBoundingBox(detectedCodes, ctx) {
  for (const detectedCode of detectedCodes) {
    const {
      boundingBox: { x, y, width, height }
    } = detectedCode

    ctx.lineWidth = 2
    ctx.strokeStyle = '#007bff'
    ctx.strokeRect(x, y, width, height)
  }
}

function paintCenterText(detectedCodes, ctx) {
  for (const detectedCode of detectedCodes) {
    const { boundingBox, rawValue } = detectedCode

    const centerX = boundingBox.x + boundingBox.width / 2
    const centerY = boundingBox.y + boundingBox.height / 2

    const fontSize = Math.max(12, (50 * boundingBox.width) / ctx.canvas.width)

    ctx.font = `bold ${fontSize}px sans-serif`
    ctx.textAlign = 'center'

    ctx.lineWidth = 3
    ctx.strokeStyle = '#35495e'
    ctx.strokeText(rawValue, centerX, centerY)

    ctx.fillStyle = '#5cb984'
    ctx.fillText(rawValue, centerX, centerY)
  }
}

const trackFunctionOptions = [
  { text: 'Nothing (default)', value: undefined },
  { text: 'Outline', value: paintOutline },
  { text: 'Centered Text', value: paintCenterText },
  { text: 'Bounding Box', value: paintBoundingBox }
]
const trackFunctionSelected = ref(trackFunctionOptions[1])

/*** barcode formats ***/
const barcodeFormats = ref({
  aztec: false,
  code_128: false,
  code_39: false,
  code_93: false,
  codabar: false,
  databar: false,
  databar_expanded: false,
  data_matrix: false,
  dx_film_edge: false,
  ean_13: false,
  ean_8: false,
  itf: false,
  maxi_code: false,
  micro_qr_code: false,
  pdf417: false,
  qr_code: true,
  rm_qr_code: false,
  upc_a: false,
  upc_e: false,
  linear_codes: false,
  matrix_codes: false
})

const selectedBarcodeFormats = computed(() => {
  return Object.keys(barcodeFormats.value).filter((format) => barcodeFormats.value[format])
})

/*** error handling ***/
const error = ref('')

function onError(err) {
  error.value = `[${err.name}]: `

  switch (err.name) {
    case 'NotAllowedError':
      error.value += 'You need to grant camera access permission'
      break
    case 'NotFoundError':
      error.value += 'No camera on this device'
      break
    case 'NotSupportedError':
      error.value += 'Secure context required (HTTPS, localhost)'
      break
    case 'NotReadableError':
      error.value += 'Is the camera already in use?'
      break
    case 'OverconstrainedError':
      error.value += 'Installed cameras are not suitable'
      break
    case 'StreamApiNotSupportedError':
      error.value += 'Stream API is not supported in this browser'
      break
    case 'InsecureContextError':
      error.value += 'Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.'
      break
    default:
      error.value += err.message
  }
}
watch(exam_id, async function (value) {
  try {
    const response = await axios.post('/get-examinees', {
      exam_id: value,
    });

    // Access the response data after awaiting
    examinees.value = response.data.applicant;
    count.value = response.data.count;
    scanned.value = response.data.scanned;

    console.log(response.data.applicant);

  } catch (error) {
    console.error('Error fetching data:', error);
    resulted.value = null; // Handle error appropriately
  } finally {
    loading.value = false; // Reset loading state
  }
  // try {
  //   const response = await axios.post('/get-examinee-details', {
  //     exam_id: "5ea14f98-fb41-4e6a-b828-1db60371038b",
  //     exam_schedule_id: value,
  //   });

  //   // Access the response data after awaiting
  //   resulted.value = response.data;
  //   console.log(response.data.applicant);

  // } catch (error) {
  //   console.error('Error fetching data:', error);
  //   resulted.value = null; // Handle error appropriately
  // } finally {
  //   loading.value = false; // Reset loading state
  // }
});
</script>
<style scoped>
.error {
  font-weight: bold;
  color: red;
}

.barcode-format-checkbox {
  margin-right: 10px;
  white-space: nowrap;
  display: inline-block;
}
</style>

<template>
  <AppLayout>

    <Head title="Registration" />
    <el-dialog v-model="dialogVisible" title="Tips" width="500" :show-close="false" class="rounded-lg ">
      <template #header="{ close, titleId, titleClass }">
        <div class="my-header">
          <!-- Modal header -->
          <div
            class="flex items-center justify-between  border-b border-dashed border-b-2  rounded-t dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
              Set Exam Schedule
            </h3>


            <button @click="close" type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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



          <!-- Modal body -->
          <form @submit.prevent="submit">

            <button type="submit"
              class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>

          </form>
        </div>
      </div>

    </el-dialog>

    <div class="m-2">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">



        <div
          class="w-full  p-4 bg-white border-dotted border-2 border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
          


          <form class="max-w-full mx-auto">
            <select v-model="exam_id" id="countries"
              class="bg-gray-50 border border-blue-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

              <option v-for="schedule in props.Schedules" :key="schedule.id" :value="schedule.id">{{
                schedule.exam_date }} - Available({{ schedule.available }}) - {{ schedule.venue }}
              </option>

            </select>
          </form>
          <p class="error">{{ error }}</p>

          <p class="decode-result">
            Status: <b> <span v-if="resulted">
                {{ resulted.name }} {{ resulted.date }}
            </span>
            <span v-else>
                
            </span></b>
          </p>
          <div class="flex justify-center items-center   ">
            <div class="relative w-80 h-80 border-4 border-green-500 rounded-lg overflow-hidden shadow-lg">
              <div class="absolute inset-0 flex justify-center items-center">
                <div class="border-t-4 border-green-500 w-full h-8 absolute top-0 transform -translate-y-1/2">
                  <div class="animate-pulse h-full w-full bg-gray-900"></div>
                </div>
                <div class="border-b-4 border-green-500 w-full h-8 absolute bottom-0 transform translate-y-1/2">
                  <div class="animate-pulse h-full w-full bg-gray-900"></div>
                </div>
              </div>
              <qrcode-stream :constraints="selectedConstraints" :track="trackFunctionSelected.value"
                :formats="selectedBarcodeFormats" @error="onError" @detect="onDetect" @camera-on="onCameraReady"
                class="w-full h-full"></qrcode-stream>
            </div>
          </div>
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold mb-4">Attendance Overview ({{ scanned }}/{{ count }})</h3>
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100" v-for="examinee in examinees" :key="examinee.id" :value="examinee.id">
                        <td class="py-3 px-4 border-b">{{ examinee.name }}</td>
                        <td class="py-3 px-4 border-b">{{ examinee.date }}</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>

        </div>
      </div>
    </div>
  </AppLayout>
</template>
