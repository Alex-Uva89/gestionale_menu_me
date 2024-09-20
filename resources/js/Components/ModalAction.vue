<template>
    <section class="modal-container" v-if="showModal">
        <div class="modal">
            <div class="p-10">
                <slot></slot>
            </div>
        </div>
    </section>
</template>

<script>

import { ref } from 'vue';

export default {
    props: {
        showModal: {
            type: Boolean,
            default: false
        }
    }
}

</script>

<style scoped>

.modal-container{
    background-color: rgba(0, 0, 0, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    .modal{
        position: relative;
        background-color: white;
        margin: 60px;
        border: 3px solid #868686;
        border-radius: 10px;
        box-shadow: 0 0 20px rgb(0, 0, 0), 0 0 40px rgb(255, 255, 255);
    }

}

@media screen and (max-width: 768px){
    .modal-container{
        width: 100vw;
        height: 100vh;
    }
    
}
</style>