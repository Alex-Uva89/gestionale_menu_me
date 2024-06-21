<script setup>
import ButtonCss from '@/Components/ButtonCss.vue';
import Modal from '@/Components/Modal.vue';
import Category from '@/Components/Sections/Category.vue';
import CategoryDrink from '@/Components/Sections/CategoryDrink.vue';


const props = defineProps({
    selectedVenueName: String,
    selectedVenueColor: String,
    category_enoteca: Array,
    dish_enoteca_category: Array,
    drink_enoteca_category: Array,
    allergens: Array,
    allergensDishes: Array,
    allergensDrinks: Array,
    drinks: Array,
    pairingsEnoteca: Array,
});


</script>

<template>
<div class="section_accordion relative h-full" >
  <section class="sticky w-full top-0 z-10" >
    
    
    <div class="bg-white p-2 border-2 border-black items-center">
      <div class="first-letter:uppercase font-bold flex justify-center items-center gap-2 margin-negative cursor-pointer" @click="toggleVisibility()" id="button-category">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16">
          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        </svg>
        <span class="leading-7">
          opzioni
        </span>
      </div>
      <div 
      class="items-center pt-3 gap-2 grid-cols-4"
      :class="isVisible? 'grid' : 'hidden' ">
        
      </div>
    </div>
    
  </section>

  <section class="flex justify-evenly">
    <div class="container-food">
      <form class="grid grid-cols-5" @submit.prevent="createCategory(3)">
          <h2 class="text-2xl col-span-5 font-bold text-center uppercase">food</h2>
          <div class="flex flex-col gap-2 col-span-4">
            <label for="inputCategory">Aggiungi categoria food</label>
            <input v-model="newCategory.name" type="text" placeholder="Nome categoria" id="inputCategory">
          </div>
          <button type="submit" class=" self-end col-span-1 justify-self-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
              </svg>
          </button>
      </form>
      <Category
        :category_enoteca="category_enoteca"
        :selectedVenueColor="selectedVenueColor"
        :deleteCategory="deleteCategory"
        :editCategory="editCategory"
        :updateIsShowStatus="updateIsShowStatus"
        :dish_enoteca_category="dish_enoteca_category"
        :addDishes="addDishes"
        :showAddDishesModal="showAddDishesModal"
        :componentKey="componentKey"
        @dishAdded="$emit('dishAdded')"
        :allergens="allergens"
        :allergensDishes="allergensDishes"
        :drinks="drinks"
        :pairingsEnoteca="pairingsEnoteca"

      />
    </div>



    <div class="container-beverage">
      <form class="grid grid-cols-5" @submit.prevent="createCategoryDrink(3)">
          <h2 class="text-2xl col-span-5 font-bold text-center uppercase">beverage</h2>
          <div class="flex flex-col gap-2 col-span-4">
            <label for="inputCategoryDrink">Aggiungi categoria beverage</label>
            <input v-model="newCategoryDrink.name" type="text" placeholder="Nome categoria drink" id="inputCategoryDrink">
          </div>
          
          <button type="submit" class=" self-end col-span-1 justify-self-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
              </svg>
          </button>
      </form>
      <CategoryDrink
        :allergensDrinks="allergensDrinks"
        :category_enoteca="category_enoteca"
        :selectedVenueColor="selectedVenueColor"
        :deleteCategory="deleteCategory"
        :editCategory="editCategory"
        :updateIsShowStatus="updateIsShowStatus"
        :drink_enoteca_category="drink_enoteca_category"
        :addDishes="addDishes"
        :showAddDishesModal="showAddDishesModal"
        :componentKey="componentKey"
        @drinkAdded="$emit('drinkAdded')"
        @updateDrinks="addDrink"
        :allergens="allergens"
      />
    </div>

  </section>





</div>




</template>

<script>
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';


export default {
    components: {
        Modal,
        Category,
        CategoryDrink,
        ButtonCss,
    },
    props: {
        category_enoteca: Array,
        dish_enoteca_category: Array,
    },
    data() {
      return {
        componentKey: 0,
        newCategory: {
          name: '',
        },
        newCategoryDrink: {
          name: '',
        },
        venues: [],
        localCategory_enoteca: this.category_enoteca,
        showDeleteModal: false,
        showEditModal: false,
        showAddDishesModal: false,
        dishToCreateId: null,
        isVisible: false,
      }
    },
    methods: {
        createCategory(venue_ids) {
          const venue_id = [venue_ids];
          const newCategory = { name: this.newCategory.name, is_drink: false};
        
          axios.post('/api/categories', newCategory)
          .then(response => {
        
            this.category = response.data;
            this.localCategory_enoteca.push(response.data);
            
            axios.post(`/api/categories/${response.data.id}/venues`, {category_id: response.data.id, venue_id})
            .then(response => {
              venue_id.push(response.data);
              Inertia.visit('/confirm-new-category');
            })
            .catch(error => {
              console.log(error);
            });
        
            this.newCategory.name = '';
          })
          .catch(error => {
            console.log(error);
          });
        },
        createCategoryDrink(venue_ids) {
          const venue_id = [venue_ids];
          const newCategoryDrink = { name: this.newCategoryDrink.name, is_drink: true};

          axios.post('/api/categories', newCategoryDrink)
          .then(response => {

              this.category = response.data;
              this.localCategory_enoteca.push(response.data);
              
              axios.post(`/api/categories/${response.data.id}/venues`, {category_id: response.data.id, venue_id})
              .then(response => {
                  venue_id.push(response.data);
              })
              .catch(error => {
                  console.log(error);
              });

              this.newCategory.name = '';
          })
          .catch(error => {
              console.log(error);
          });
        },
        toggleVisibility() {
          const buttonCategory = document.getElementById('button-category');
          this.isVisible = !this.isVisible;
          if(this.isVisible) {
            if(buttonCategory.innerText === '❌') {
              buttonCategory.innerText = 'aggiungi categoria';
              buttonCategory.style.borderBottom = 'none';
              buttonCategory.style.paddingBottom = '0';
            } else {
              buttonCategory.innerText = '❌';
              buttonCategory.style.borderBottom = '3px solid black';
              buttonCategory.style.paddingBottom = '10px';
            }
          } else {
            if(buttonCategory.innerText === '❌') {
              buttonCategory.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
          </svg> opzioni`;
              buttonCategory.style.borderBottom = 'none';
              buttonCategory.style.paddingBottom = '0';
            } else {
              buttonCategory.innerText = '❌';
              buttonCategory.style.borderBottom = '3px solid black';
              buttonCategory.style.paddingBottom = '10px';
            }
          }
        },
        addDrink(newDrink) {
          this.drinks.push(newDrink);
        },
    },
    watch: {
        category_enoteca(newVal) {
            this.localCategory_enoteca = newVal;
        },
        dish_enoteca_category(newVal) {
            this.dish_enoteca_category = newVal;
        },
    },
    created() {
        this.componentKey = 0;
    }
}

</script>

<style scoped>

.section_accordion{
  overflow: scroll;
  overflow-x: hidden;
  min-height: calc(100vh - 7rem);
  scrollbar-width: none;
}

section.accordion{
  width: 90%;
  margin: 10px auto;
}

.container-food, .container-beverage{
  form{
    width: calc(100% - 35px);
    margin: 20px auto 0px;
    border-bottom: none;
    padding: 10px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    background-color: rgba(0, 0, 0, 0.060);
  }
}

.section-delete, .section-edit, .section-create-dishes{
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
    .modal-confirm{
        background-color: white;
        padding: 60px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }
}

.margin-negative{
  margin: 0 -10px;
}

</style>

