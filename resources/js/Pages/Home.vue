<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Loading from '@/Components/Loading.vue';
import Sidebar from '@/Partials/Sidebar.vue';
import Header from '@/Partials/Header.vue';
import Inbox from '@/PartialsHome/Inbox.vue';
import LaCucina from '@/PartialsHome/Venues/LaCucina.vue';
import Scante from '@/PartialsHome/Venues/Scante.vue';
import Enoteca from '@/PartialsHome/Venues/Enoteca.vue';
import Preview from '@/PartialsHome/Preview.vue';
import Allergens from '@/PartialsHome/Allergens.vue';
import Dashboard from '@/PartialsHome/Dashboard.vue';
import Welcome from '@/PartialsHome/Welcome.vue';
import Receips from '@/PartialsHome/Receips.vue';
import { all } from 'axios';

const selectedVenueName = ref('Benvenuto');
const selectedVenueColor = ref('blue');
const selectedValueButton = ref('Dashboard');
const newMessage = ref(false);
let currentPageComponent = '';

function updateSelectedVenueName(name) {
  selectedValueButton.value = '';
  // selectedVenueName.value = name;
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
    return currentPageComponent = value === "'Scante" ? Scante : value === 'La Cucina' ? LaCucina : value === 'Enoteca' ? Enoteca : value === 'Anteprima menù' ? Preview : value === 'Allergeni' ? Allergens : value === 'Dashboard' ? Dashboard : value === 'Ricette' ? Receips : value === 'Home' ? Welcome : '';
}
   
</script>

<template>
    <Head title="Mamma Elvira" />
    <div class="relative">
      <Loading v-if="isLoading" /> <!-- Mostra il caricamento -->
      <div v-else>

        <div class="h-screen">
          <Sidebar :messages="messages" @venue-name="updateSelectedVenueName" @venue-color="updateSelectedVenueColor" @value-button="updateSelectedValueButton" />

          <div class="main-app flex">
            <Header class="col-9" v-if="selectedVenueName? selectedVenueName : selectedValueButton" :selectedVenueName="selectedVenueName" :selectedVenueColor="selectedVenueColor" :selectedValueButton="selectedValueButton" :newMessage="newMessage"/>
            <Inbox :messages="messages" v-if="selectedValueButton === 'inbox'" @message-not-read="updateNewMessage"/>
            <Welcome 
              v-if="currentPageComponent === ''"
              @open-modal-instruction="toggleModalInstruction"
              />
            <component 
              v-else
              :allergens="allergens"
              :allergensDishes="allergensDishes"
              :allergensDrinks="allergensDrinks"
              :is="currentPageComponent" 
              :selectedVenueName="selectedVenueName" 
              :selectedVenueColor="selectedVenueColor" 
              :category_laCucina="category_laCucina" 
              :category_scante="category_scante"
              :category_enoteca="category_enoteca"
              @update:category_laCucina="category_laCucina=$event"
              @update:category_scante="category_scante=$event"
              @update:category_enoteca="category_enoteca=$event"
              :categories="categories" 
              :dish_enoteca_category="dish_enoteca_category"
              :drink_enoteca_category="drink_enoteca_category"
              :dish_laCucina_category="dish_laCucina_category"
              :drink_laCucina_category="drink_laCucina_category"
              :dish_scante_category="dish_scante_category"
              :drink_scante_category="drink_scante_category"
              :messages="messages"
              @dishAdded="componentKey += 1"
              @drinkAdded="componentKey += 1"
              :key="componentKey"
              :receips="receips"
              :updateIsShowStatus="updateIsShowStatus"
              @changePage="updateCurrentPageComponent"
              @changeHeader="updateSelectedValueButton"
              :drinks="drinks"
              :dishes="dishes"
              :pairingsEnoteca="pairingsEnoteca"
              :pairingsScante="pairingsScante"
              :pairingsLaCucina="pairingsLaCucina"
              />     
          </div>
    

          
        </div>
        <div @click="toggleModalInstruction()" class="z-50 modal-instruction absolute w-screen h-screen top-0 right-0 bg-opacity-50 bg-black" :class="{ visible: openModalInstruction }">
          <div class="focus-modal cursor-pointer" :class="{ visible: openModalInstruction }">
          </div>
          <div class="focus-instruction flex flex-col gap-5" :class="{ visible: openModalInstruction }">
          <span class="text-6xl cursor-pointer">
            clicca qui per iniziare
          </span>
          <span>
            <svg xmlns="https://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-arrow-return-left text-2xl cursor-pointer" viewBox="0 0 26 26">
              <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
            </svg>
          </span>
          </div>
        </div>
      </div>

      
    </div>
</template>

<style scoped>
.main-app{
    width: calc(100% - 250px);
    margin-left: 250px;
    flex-direction: column;
    .scante{
        height: calc(100vh - 7rem);
        max-width: fit-content;
        overflow-y: scroll;
        scrollbar-width: thin;
    }
}
.modal-instruction {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.5);
    visibility: hidden;
    opacity: 0;
    transition: visibility .5s, opacity .5s linear;
}

.modal-instruction.visible {
    visibility: visible;
    opacity: 1;
}

.focus-modal {
    position: absolute;
    top: 18%;
    left: 15px;
    width: 235px;
    height: 350px;
    background: transparent;
    border-radius: 10px;
    border: 4px solid #fff;
    box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.8);
    visibility: hidden;
    opacity: 0;
    transform: scale(10);
    transition: visibility .5s, opacity .5s, transform .5s linear;
}

.focus-modal.visible {
    transform: scale(1);
    visibility: visible;
    opacity: 1;
}

.focus-instruction {
    position: absolute;
    top: 30%;
    left: 300px;
    color: #fff;
    transition: visibility 2s, opacity 2s linear;
}

.focus-instruction.visible {
    visibility: visible;
    opacity: 1;
}

@media screen and (max-width: 600px) {
    .main-app{
        width: 100%;
        margin:0;
    }
    .focus-instruction {
        left: 50%;
        transform: translateX(-50%);
    }
}

</style>

<script>
export default {
  props: {
    messages: Array,
    categories: Array,
    category_laCucina: Array,
    category_scante: Array,
    category_enoteca: Array,
    dish_enoteca_category: Array,
    drink_enoteca_category: Array,
    dish_laCucina_category: Array,
    drink_laCucina_category: Array,
    dish_scante_category: Array,
    drink_scante_category: Array,
    allergensDishes: Array,
    allergensDrinks: Array,
    allergens: Array,
    receips: Array,
    drinks: Array,
    pairingsEnoteca: Array,
    pairingsScante: Array,
    pairingsLaCucina: Array,
    dishes: Array,
  },
  data() {
    return {
      componentKey: 0,
      openModalInstruction: false,
      isLoading: true,
    };
  },
  methods: {
    toggleModalInstruction() {
      this.openModalInstruction = !this.openModalInstruction;
    },
  },
  mounted() {
      setTimeout(() => {
        this.isLoading = false; 
      }, 3000);
  },
}

</script>
