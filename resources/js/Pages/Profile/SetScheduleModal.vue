<script>
export default {
    data() {
        modal: ''
    },
    methods: {
        toggleModal() {
            modal.value = true;
            // this.modal.toggle();
        }
    },
    mounted() {
        // set the modal menu element
        const targetEl = document.getElementById('defaultModal');

        if (targetEl) {
            // options with default values
            const options = {
                placement: 'center',
                // backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0',
                onHide: () => {
                    console.log('modal is hidden');
                },
                onShow: () => {
                    console.log('modal is shown');
                },
                onToggle: () => {
                    console.log('modal has been toggled');
                }
            };

            this.modal = new Modal(targetEl, options);
        }

    }
}
</script>
<template>
    
</template>
<script setup>
import AppLayout from '@/Layouts/MyLayout.vue';
import { ref, computed, watch,reactive } from 'vue' 
    import Welcome from '@/Components/Welcome.vue';
    import { router, usePage,Link ,Head} from '@inertiajs/vue3'
    import { onMounted,onUpdated } from 'vue' 
    import debounce from 'lodash/debounce'
    const {props} = usePage();
    const dialogVisible = ref(false);
    const openModal = (time_record) => {
    
        dialogVisible.value = true
    }
    let form = {
    id:'',
    employee_id:'',
    transactionDate: '',
    amin : '',
    amout: '',
    pmin : '',
    pmout : '',
    otin : '',
    otout : '',
    aminIsEnable : '',
    amoutIsEnable: '',
    pminIsEnable : '',
    pmoutIsEnable : '',
    otinIsEnable : '',
    otoutIsEnable : '',
};
</script>
