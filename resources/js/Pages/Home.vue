<!-- per aggiungere una nuova voce alla dashboard, inserire l'import del componente in dashboardComponents -->
<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, defineAsyncComponent } from 'vue';
import Sidebar from '@/Partials/Sidebar.vue';
import Header from '@/Partials/Header.vue';

const {components, venues} = defineProps({
  messages: Array,
  venues: Array,
  allergensDishes: Array,
  allergensDrinks: Array,
  allergens: Array,
  receips: Array,
  drinks: Array,
  pairingsEnoteca: Array,
  dishes: Array,
  venue: Object,
  dish_categories: Object,
  drink_categories: Object,
  category_relations: Array,
  components: Array,
  default_id: Number,
});


// const componentsTable = { // dispatch table
//   '\'Scante':{
//     pathComponent: defineAsyncComponent(() => import('@/PartialsHome/Venues/Scante.vue')),
//   },
//   'La Cucina':{
//     pathComponent: defineAsyncComponent(() => import('@/PartialsHome/Venues/LaCucina.vue')),
//   },
//   'Enoteca':{
//     pathComponent: defineAsyncComponent(() => import('@/PartialsHome/Enoteca.vue')),
//   },
//   'Welcome':{
//     pathComponent: defineAsyncComponent(() => import('@/PartialsHome/Welcome.vue')),
//   },
//   'Dashboard':{
//     pathComponent: defineAsyncComponent(() => import('@/PartialsHome/Dashboard.vue')),
//   },
//   'Anteprima':{
//     pathComponent: defineAsyncComponent(() => import('@/PartialsHome/Preview.vue')),
//   },
//   'Allergeni':{
//     pathComponent: defineAsyncComponent(() => import('@/PartialsHome/Allergens.vue')),
//   },
//   // { 
//   //   pathComponent: defineAsyncComponent(() => import('@/PartialsHome/Receips.vue')),
//   // },
//   'Messaggi':{
//     pathComponent: defineAsyncComponent(() => import('@/PartialsHome/Inbox.vue')),
//   }
// };


// Usa la funzione per creare la dashboardMap
// const dashboardMap = dashboardComponents.reduce((map, comp) => {
//   const dashboardMap = dashboardComponents.reduce((map, comp) => {
//   map[comp.name] = comp;
//   return map;
// }, {});
// const pippo = ref('PartialsHome/Welcome.vue');
// const pluto = defineAsyncComponent(() => import(`@/${pippo.value}`));

let selectedVenue = ref(null);
let selectedValueButton = {};
let openModalInstruction = ref(false);
const newMessage = ref(false);
let currentPageComponent = ref(null);

function updateSelectedVenue(venue) {
  // console.log('DEBUG VALE HOME SIDEBAR', venue);// object
  selectedVenue = venue;
  // selectedValueButton.value = '';
  updateCurrentPageComponent(venue);
}


function updateSelectedValueButton(value) {
  // console.log('DEBUG VALE HOME SIDEBAR', value); // string
  selectedValueButton = value;
  // selectedVenue = null;
  updateCurrentPageComponent(value);
}

function updateNewMessage(value) {
  return newMessage.value = value;
}

function updateCurrentPageComponent(component) {
  // currentPageComponent.value = dashboardMap[nameComponent].component;
  // currentPageComponent.value = defineAsyncComponent(() => import(component.pathComponent));
  // const myfunc = new Function(`return ${component.pathComponent}`);
  
  // currentPageComponent.value = eval(myfunc()); //`"${defineAsyncComponent(() => import('@/PartialsHome/Venues/Enoteca.vue'))}"`;
  // console.log(component)
  // currentPageComponent.value = componentsTable[component].pathComponent;
  console.log(component)
  const pathComponent = `/resources/js/Dashboard/${component.componentName}.vue`;
  // const pathComponentVenues = `/resources/js/PartialsHome/Venues/${component.componentName}.vue`;

  const partials = import.meta.glob(`@/Dashboard/*.vue`, {eager: false});  

  // const partialsVenue = import.meta.glob(`@/PartialsHome/Venues/*.vue`, {eager: false})
  // currentPageComponent.value = defineAsyncComponent(async () => await partials[path]())
  currentPageComponent.value = defineAsyncComponent(async () => await partials[pathComponent]())
  // console.log('ciccio', currentPageComponent)
  // eval(currentPageComponent.value);
}

function toggleModalInstruction() {
      openModalInstruction = !openModalInstruction;
}

// onMounted(function(){
//   components.reduce((map, comp) => {
//     componentTable[comp.name] = comp.pathComponent;
//   });

//   venues.reduce((map, comp) => {
//     componentTable[comp.name] = comp.pathComponent;
//   });
//   console.log(12, componentTable);
// })
</script>

<template>
    <Head title="Mamma Elvira" />
    <div class="relative">
      <div class="bg-gray-50 flex dark:bg-gray-800 h-screen">
        <Sidebar :dashboardMap="dashboardMap" :messages="messages" :components="components" @venue="updateSelectedVenue" @value-button="updateSelectedValueButton" />

        <div class="main-app flex">
          <Header class="col-9" v-if="selectedVenue? selectedVenue : selectedValueButton" :selectedVenue="selectedVenue" :selectedValueButton="selectedValueButton" :components="components" :default_id="default_id" :newMessage="newMessage"/>
          <Inbox :messages="messages" v-if="selectedValueButton === 'inbox'" @message-not-read="updateNewMessage"/>
          <!-- {{ console.log('HOME',venue) }} -->
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
            :categories="categories" 
            @update:categories="categories=$event"
            :dish_categories="dish_categories"
            :drink_categories="drink_categories"
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
            :pairings="pairings"
            :venue="selectedVenue"
            :category_relations="category_relations"
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

</style>
