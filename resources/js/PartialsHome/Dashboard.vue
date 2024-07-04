<template>
    
    <ModalAction @click="UnderCostruction()" :showModal="showModalUnderCostruction"> 
        <div class="modal">
            <h2 class="text-2xl text-center m-4 uppercase">Dashboard</h2>
            <p class="text-center">Questa funzionalità sarà disponibile a breve</p>
        </div>
    </ModalAction>

</template>

<script>

import ModalAction from '../Components/ModalAction.vue';

export default {
    components: {
        ModalAction
    },
    data() {
        return {
            showModalUnderCostruction: true,
        }
    },
    methods: {
        UnderCostruction() {
            this.showModalUnderCostruction = !this.showModalUnderCostruction;
            this.$emit('changePage', 'Home');
            this.$emit('changeHeader', 'Benvenuto');
        }
    }
}

</script>