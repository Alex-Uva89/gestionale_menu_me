<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Sidebar from '@/Partials/Sidebar.vue';
import Header from '@/Partials/Header.vue';
import Inbox from '@/Pages/Inbox.vue';
import LaCucina from '@/Pages/LaCucina.vue';
import Scante from '@/Pages/Scante.vue';
import Enoteca from '@/Pages/Enoteca.vue';
import Preview from '@/Pages/Preview.vue';

const selectedVenueName = ref('Benvenuto');
const selectedVenueColor = ref('blue');
const selectedValueButton = ref('Dashboard');
const newMessage = ref(false);
let currentPageComponent = '';

function updateSelectedVenueName(name) {
  selectedValueButton.value = '';
  selectedVenueName.value = name;
  updateCurrentPageComponent(name);
}

function updateSelectedVenueColor(color) {
  selectedVenueColor.value = color;
}

function updateSelectedValueButton(value) {
  selectedValueButton.value = value;
  selectedVenueName.value = '';
  selectedVenueColor.value = 'blue';
  updateCurrentPageComponent(value);
}

function updateNewMessage(value) {
  return newMessage.value = value;
}

function updateCurrentPageComponent(value) {
    return currentPageComponent = value === 'Scante' ? Scante : value === 'La Cucina' ? LaCucina : value === 'Enoteca' ? Enoteca : value === 'Anteprima menù' ? Preview : '';
}
   
</script>

<template>
    <Head title="Mamma Elvira" />
      <div class="bg-gray-50 flex dark:bg-gray-800 h-screen">
        <Sidebar :messages="messages" @venue-name="updateSelectedVenueName" @venue-color="updateSelectedVenueColor" @value-button="updateSelectedValueButton" />

        <div class="main-app flex">
          <Header class="col-9" v-if="selectedVenueName? selectedVenueName : selectedValueButton" :selectedVenueName="selectedVenueName" :selectedVenueColor="selectedVenueColor" :selectedValueButton="selectedValueButton" :newMessage="newMessage"/>
          <Inbox :messages="messages" v-if="selectedValueButton === 'inbox'" @message-not-read="updateNewMessage"/>
          <!-- dynamic component for pages Scante, LaCucina,  Enoteca and preview -->
          <component :is="currentPageComponent" />
        </div>


      
    
    </div>
</template>

<style scoped>
.main-app{
    width: calc(100% - 250px);
    flex-direction: column;
    .scante{
        height: calc(100vh - 7rem);
        max-width: fit-content;
        overflow-y: scroll;
        scrollbar-width: thin;
    }
}
</style>

<script>
export default {
  props: {
    messages: Array,
  },
}

</script>
