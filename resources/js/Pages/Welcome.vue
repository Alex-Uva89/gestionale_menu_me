<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Sidebar from '@/Partials/Sidebar.vue';
import Header from '@/Partials/Header.vue';
import Inbox from '@/Partials/Inbox.vue';

const selectedVenueName = ref('Benvenuto');
const selectedVenueColor = ref('blue');
const selectedValueButton = ref('Dashboard');
const newMessage = ref(false);

function updateSelectedVenueName(name) {
  selectedValueButton.value = '';
  selectedVenueName.value = name;
}

function updateSelectedVenueColor(color) {
  selectedVenueColor.value = color;
}

function updateSelectedValueButton(value) {
  selectedValueButton.value = value;
  selectedVenueName.value = '';
  selectedVenueColor.value = 'blue';
}

function updateNewMessage(value) {
  return newMessage.value = value;
}
   
</script>

<template>
    <Head title="Mamma Elvira" />
    <div class="">
      <div class="bg-gray-50 flex dark:bg-gray-800 h-screen">
        <Sidebar @venue-name="updateSelectedVenueName" @venue-color="updateSelectedVenueColor" @value-button="updateSelectedValueButton" />
        <div class="main-app">
          <Header class="col-9" v-if="selectedVenueName? selectedVenueName : selectedValueButton" :selectedVenueName="selectedVenueName" :selectedVenueColor="selectedVenueColor" :selectedValueButton="selectedValueButton" :newMessage="newMessage"/>
          <Inbox :messages="messages" v-if="selectedValueButton === 'inbox'" @message-not-read="updateNewMessage"/>
        </div>
      </div>
    
    </div>
</template>

<style scoped>
.main-app{
    width: calc(100% - 250px);
}
</style>

<script>
export default {
  props: {
    messages: Array,
  }
}
</script>
