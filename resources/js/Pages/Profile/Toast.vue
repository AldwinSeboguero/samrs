<!-- Toast.vue -->
<template>
    <div v-if="visible" class="fixed top-4 right-4 bg-green-500 text-white p-4 rounded shadow-lg transition-transform transform hover:scale-105">
        <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
    <span class="font-semibold mr-2 text-left flex-auto">  {{ message }}</span>
    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>

</div>
      
        <button @click="close" class="ml-4 text-white underline">Close</button>
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            visible: true,
        };
    },
    mounted() {
        // Set timeout to automatically close the toast after 3 seconds
        setTimeout(() => {
            this.close();
        }, 3000); // Adjust the duration as needed (in milliseconds)
    },
    methods: {
        close() {
            this.visible = false;
            this.$emit('close');
        },
    },
};
</script>

<style scoped>
/* Add any additional styles here */
</style>