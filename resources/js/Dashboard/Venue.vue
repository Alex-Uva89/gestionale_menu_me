<script setup>
import ButtonCss from '@/Components/ButtonCss.vue';
import Modal from '@/Components/Modal.vue';
import Category from '@/Components/Sections/Category.vue';



const props = defineProps({
    categories: Array,
    dish_enoteca_category: Array,
    drink_enoteca_category: Array,
    allergens: Array,
    allergensDishes: Array,
    allergensDrinks: Array,
    drinks: Array,
    pairingsEnoteca: Array,
    venues: Array,
    venue: Object,
    dish_category: Object,
    drink_category: Object,
    category_relations: Array
});


</script>

<template>
<div class="section_accordion relative h-full" >

  <!-- <section class="sticky w-full top-0 z-10" > -->
    <!-- {{ console.log('LOCALE', categories) }}     -->
    <!-- <div class="bg-white p-2 border-2 border-black items-center">
      <div class="first-letter:uppercase font-bold flex justify-center items-center gap-2 margin-negative cursor-pointer" @click="toggleVisibility()" id="button-categories">
        <svg xmlns="https://www.w3.org/2000/svg" width="20" height="20" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16">
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
    </div> -->
    
  <!-- </section> -->

  <section class="flex justify-evenly">
    
    <!-- <template v-for="category_relation in category_relations"> -->
      <!-- <div :class="`container-{{ category_relation.classification }}`">
        <form class="grid grid-cols-5" @submit.prevent="createCategory(venue.id)">
          <h2 class="text-2xl col-span-5 font-bold text-center uppercase">{{ category_relation.classification }}</h2>
          <div class="flex flex-col gap-2 col-span-4">
            <label for="inputCategory">Aggiungi categoria {{ category_relation.classification }}</label>
            <input v-model="newCategory.name" type="text" placeholder="Nome categoria" id="inputCategory">
          </div>
          
          <button type="submit" class=" self-end col-span-1 justify-self-center">
              <svg xmlns="https://www.w3.org/2000/svg" width="35" height="35" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
              </svg>
          </button>
        </form> -->
     
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
        :newDrink="newDrink"
        :venue="venue"
        :categories="categories"
        :dish_category="dish_category"
        :category_relation="category_relation"
        :category_relations="category_relations"
        />
      <!-- </div> -->
      <!-- :table_category_name="category_relation.table_category_name" -->
    <!-- </template> -->

    <!-- <div class="container-beverage">
      <form class="grid grid-cols-5" @submit.prevent="createCategoryDrink(venue.id)">
          <h2 class="text-2xl col-span-5 font-bold text-center uppercase">beverage</h2>
          <div class="flex flex-col gap-2 col-span-4">
            <label for="inputCategoryDrink">Aggiungi categoria beverage</label>
            <input v-model="newCategoryDrink.name" type="text" placeholder="Nome categoria drink" id="inputCategoryDrink">
          </div>
          
          <button type="submit" class=" self-end col-span-1 justify-self-center">
              <svg xmlns="https://www.w3.org/2000/svg" width="35" height="35" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
              </svg>
          </button>
      </form>
      <CategoryDrink
        :category_enoteca="category_enoteca"
        :selectedVenueColor="selectedVenueColor"
        :deleteCategory="deleteCategory"
        :editCategory="editCategory"
        :updateIsShowStatus="updateIsShowStatus"
        :drink_enoteca_category="drink_enoteca_category"
        :addDishes="addDishes"
        :showAddDishesModal="showAddDishesModal"
        :componentKey="componentKey"
        @drinkAdded="handleNewDrink"
        @updateDrinks="addDrink"
        :allergens="allergens"
        :allergensDrinks="allergensDrinks"
        :categories="categories"
        :venue="venue"
        :drink_category="drink_category"
      />
    </div> -->

  </section>





</div>




</template>

<script>
import axios from 'axios';



export default {
    emits: ['dishAdded', 'drinkAdded'],
    components: {
        Modal,
        Category,
        ButtonCss,
    },
    props: {
        category_enoteca: Array,
        dish_enoteca_category: Array,
        venue: Object,
        categories: Object,
    },
    data() {
      return {
        componentKey: 0,
        newCategory: {
          name: '',
        },
        venues:  this.venues,
        showDeleteModal: false,
        showEditModal: false,
        showAddDishesModal: false,
        dishToCreateId: null,
        isVisible: false,
        newDrink: null,
        venue: this.venue,
        categories: this.categories,
        dish_category: this.dish_category,
        drink_category: this.drink_category,
        newCategory: [],
        category_relations: this.category_relations
      }
    },
    methods: {
        handleNewDrink(drinkEmit){
          this.newDrink = drinkEmit;
          return this.newDrink
        },
        // createCategory(venue_ids) {
        //   const venue_id = [venue_ids];
        //   const newCategory = { name: this.newCategory.name, is_drink: false};

        //   axios.post('/api/categories', newCategory)
        //   .then(response => {
        //       console.log('RESPONSE NEW CATEGORY PRIMA', this.newCategory);
        //       this.categories = response.data;
        //       this.newCategory.push(response.data);
        //       console.log('RESPONSE NEW CATEGORY DOPO', this.newCategory);

              
        //       axios.post(`/api/categories/${response.data.id}/venues`, {category_id: response.data.id, venue_id})
        //       .then(response => {
        //           venue_id.push(response.data);
        //       })
        //       .catch(error => {
        //           console.log(error);
        //       });

        //       this.newCategory.name = '';
        //   })
        //   .catch(error => {
        //       console.log(error);
        //   });
        // },
        // createCategoryDrink(venue_ids) {
        //   const venue_id = [venue_ids];
        //   const newCategoryDrink = { name: this.newCategoryDrink.name, is_drink: true};

        //   axios.post('/api/categories', newCategoryDrink)
        //   .then(response => {

        //       this.categories = response.data;
        //       this.newCategory.push(response.data);
              
        //       axios.post(`/api/categories/${response.data.id}/venues`, {category_id: response.data.id, venue_id})
        //       .then(response => {
        //           venue_id.push(response.data);
        //       })
        //       .catch(error => {
        //           console.log(error);
        //       });

        //       this.newCategory.name = '';
        //   })
        //   .catch(error => {
        //       console.log(error);
        //   });
        // },
        // toggleVisibility() {
        //   const buttonCategory = document.getElementById('button-categories');
        //   this.isVisible = !this.isVisible;
        //   if(this.isVisible) {
        //     if(buttonCategory.innerText === '❌') {
        //       buttonCategory.innerText = 'aggiungi categoria';
        //       buttonCategory.style.borderBottom = 'none';
        //       buttonCategory.style.paddingBottom = '0';
        //     } else {
        //       buttonCategory.innerText = '❌';
        //       buttonCategory.style.borderBottom = '3px solid black';
        //       buttonCategory.style.paddingBottom = '10px';
        //     }
        //   } else {
        //     if(buttonCategory.innerText === '❌') {
        //       buttonCategory.innerHTML = `<svg xmlns="https://www.w3.org/2000/svg" width="20" height="20" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16">
        //     <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
        //     <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        //   </svg> opzioni`;
        //       buttonCategory.style.borderBottom = 'none';
        //       buttonCategory.style.paddingBottom = '0';
        //     } else {
        //       buttonCategory.innerText = '❌';
        //       buttonCategory.style.borderBottom = '3px solid black';
        //       buttonCategory.style.paddingBottom = '10px';
        //     }
        //   }
        // },
        addDrink(newDrink) {
          this.drinks.push(newDrink);
        },
    },
    watch: {
        newCategory(newVal) {
          console.log('NEW CATEGORY', newVal);
            this.categories = newVal;
        },
        dish_enoteca_category(newVal) {
            this.dish_enoteca_category = newVal;
        },
    },
    created() {
        this.componentKey = 0;
        // console.log('LOCALE', this.category_relations);
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

