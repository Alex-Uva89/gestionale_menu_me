<template>


    <div class="h-screen flex flex-col justify-between items-center">
        <div  class="flex flex-col h-96 max-w-2xl justify-around  border border-blue-700 border-4 rounded-2xl p-6 bg-blue-100 mt-5  font-bold">
            <h2 class="text-center text-4xl uppercase">Benvenuto nel gestionale di mamma elvira</h2>
            <p @click="openModalInstruction" class="cursor-pointer text-center text-3xl leading-7 text-blue-700 uppercase">
                <!-- svg freccia sinistra -->
                <svg class="w-6 h-6 inline-block font-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Seleziona una delle voci del menù a sinistra per iniziare
            </p>
        </div>

        <div class="flex justify-center">
            <ApplicationLogo class="w-44 h-44" />
        </div>
    </div>

</template>

<script>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

export default {
    components: {
        ApplicationLogo,
    },
    methods: {
        openModalInstruction() {
            this.$emit('open-modal-instruction');
        }
    }
}

</script>