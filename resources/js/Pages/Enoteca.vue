<script setup>
import Modal from '@/Components/Modal.vue';
import Category from '@/Components/Sections/Category.vue';


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
    
    <div class=" bg-white p-2 border-2 border-black">
      <form class="flex justify-between items-center" @submit.prevent="createCategory(3)">
        <div class="flex gap-2 items-center">
          <label for="inputCategory">Aggiungi categoria</label>
          <input v-model="newCategory.name" type="text" placeholder="Nome categoria" id="inputCategory">
        </div>
        
        <div>
          <button type="submit">Salva</button>
          <span> | </span>
          <button type="reset">Annulla</button>
        </div>
      </form>
    </div>
    
  </section>

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

</div>




</template>

<script>
import axios from 'axios';



export default {
    components: {
        Modal,
        Category,
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
        venues: [],
        localCategory_enoteca: this.category_enoteca,
        showDeleteModal: false,
        showEditModal: false,
        showAddDishesModal: false,
        dishToCreateId: null,
        filterDishes: [],
      }
    },
    methods: {
        createCategory(venue_ids) {
          const venue_id = [venue_ids];
          const newCategory = { name: this.newCategory.name};

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
        deleteCategory(id) {
            this.categoryToDelete = id;
            this.showDeleteModal = true;
        },
        confirmDelete() {
            axios.delete(`/api/dishes/${this.categoryToDelete}`)
                .then(response => {
                console.log('Deleted corresponding dishes');
            
                axios.delete(`/api/categories/${this.categoryToDelete}`)
                .then(response => {
                const index = this.localCategory_enoteca.findIndex(category => category.id === this.categoryToDelete);
                if (index !== -1) {
                    this.localCategory_enoteca.splice(index, 1);
                }
                console.log('RESPONSE delete');
                console.log(this.localCategory_enoteca);
                this.$emit('update:category_enoteca', this.localCategory_enoteca);
                })
                .catch(error => {
                console.log(error);
                });
            })
            .catch(error => {
                console.log(error);
            });
            
            this.showDeleteModal = false;
        },
        editCategory(id) {
            this.categoryToEdit = id;
            this.categoryNameToEdit = this.localCategory_enoteca.find(category => category.id === id).name;
            this.showEditModal = true;
        },
        confirmEdit(value) {
            axios.put(`/api/categories/${this.categoryToEdit}`, { name: value })
            .then(response => {
                const index = this.localCategory_enoteca.findIndex(category => category.id === this.categoryToEdit)
                if (index !== -1) {
                    this.localCategory_enoteca[index].name = value;
                } 
                console.log('INDEX');
                console.log(index);
                this.category = response.data;
                })
            .catch(error => {
                console.log(error);
                });

                this.showEditModal = false;
        },
        updateIsShowStatus(categoryId, value) {
          axios.put(`/api/categories/${categoryId}`, { is_active: value })
          .then(response => {
              this.category = response.data;
            })
          .catch(error => {
              console.log(error);
            });
        }
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

