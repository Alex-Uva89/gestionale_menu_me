<script setup>
import Modal from '@/Components/Modal.vue';
import Category from '@/Components/Sections/Category.vue';
import CategoryDrink from '@/Components/Sections/CategoryDrink.vue';


const props = defineProps({
    selectedVenueName: String,
    selectedVenueColor: String,
    category_enoteca: Array,
    dish_enoteca_category: Array,
});


</script>

<template>
<div class="section_accordion relative h-full" >

  <section class="sticky w-full top-0 z-10" >
    
    <div class=" bg-white p-2 border-2 border-black flex justify-between items-center gap-2">
      <form class="flex justify-between items-center" @submit.prevent="createCategory(3)">
        <div class="flex gap-2 items-center">
          <label for="inputCategory">Aggiungi categoria food</label>
          <input v-model="newCategory.name" type="text" placeholder="Nome categoria" id="inputCategory">
        </div>
        
        <div>
          <button type="submit">Salva</button>
          <span> | </span>
          <button type="reset">Annulla</button>
        </div>
      </form>

      <form class="flex justify-between items-center" @submit.prevent="createCategoryDrink(3)">
        <div class="flex gap-2 items-center">
          <label for="inputCategoryDrink">Aggiungi categoria beverage</label>
          <input v-model="newCategoryDrink.name" type="text" placeholder="Nome categoria drink" id="inputCategoryDrink">
          <!-- newCategoryDrink.name -->
        </div>
        
        <div class="flex gap-2 items-center">
          <button type="submit">Salva</button>
          <span> | </span>
          <button type="reset">Annulla</button>
        </div>
      </form>
    </div>
    
  </section>

  <section class="flex flex-col justify-between">
    <h2 class="text-2xl font-bold text-center uppercase m-5">food</h2>
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
    />
  
    <h2 class="text-2xl font-bold text-center uppercase m-5">beverage</h2>
    <CategoryDrink
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
    />
  </section>





</div>




</template>

<script>
import axios from 'axios';



export default {
    components: {
        Modal,
        Category,
        CategoryDrink,
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


</style>

