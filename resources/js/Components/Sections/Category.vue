<script setup>

const props = defineProps({
    selectedVenueName: String,
    selectedVenueColor: String,
    category_enoteca: Array,
    dish_enoteca_category: Array,
    allergens: Array,
    allergensDishes: Array,
});


</script>

<template>
    <section class="accordion overflow-x-hidden mx-4" >
      <h2 class="p-3"  v-if="!category_enoteca.some(category => !category.is_drink)">
  ⭐    Inizia <strong class="uppercase">aggiungendo</strong> una categoria food
      </h2>
      
     <div 
     v-for="category in category_enoteca" 
     :key="category.id">
     <div 
     class="tab border border-black category  bg-white" 
     v-if="!category.is_drink">
      <div class="flex max-h-14 bg-white justify-evenly items-center gap-3 p-2">
          <button @click="deleteCategory(category.id)">❌</button>
          <button @click="editCategory(category.id)">Edit</button>
          <Switch_button :value="category.is_active === 1" @switchChanged="value => updateIsShowStatus(category.id, value)" />
      </div>
      <div
      :class="{
        'bg-blue-700': selectedVenueColor === 'blue'|| selectedVenueColor === '',
        'bg-olive': selectedVenueColor === 'green',
        'bg-stone-500': selectedVenueColor === 'gray',
        'bg-enoteca': selectedVenueColor === 'red',
        'text-orange-500': selectedVenueColor === 'gray',
      }" :key="componentKeyli" >
          <input type="checkbox" name="accordion-1" :id="'cb' + category.id">
          <label :for="'cb'+ category.id" class="tab__label uppercase text-white text-center font-bold cursor-pointer">{{ category.name }}</label>
          <div class="tab__content bg-white" >
              <ul class="max-w-full" >
                <li v-for="dish in category.dishes" 
                class="border-b-2 border-black p-2"
                >
                  <div class="container-dishes flex items-center">
                    <div class="flex items-center">
                      <img :src="dish.image = 'undefined' ? 'img/defaultDish.jpg' : dish.image" alt="dish image" class="w-44 h-44 object-cover p-2">
                    </div>
                    <div class="flex flex-col name">
                      <span>Nome piatto: </span><span>{{ dish.name }}</span>
                    </div>
                    <div class="flex flex-col price">
                      <span>Prezzo: </span><span>{{ dish.price }} €</span>
                    </div>
                    <div  class="flex flex-col description">
                      <div>Descrizione: </div><div> {{ dish.description }}</div>
                    </div>
                    <div class="flex flex-col gap-2 buttons">
                      <button class="border p-1">edit</button>
                      <button class="border p-1">delete</button>
                    </div>
                  </div>
                  <div class="flex items-center ps-6 py-3">
                    Allergeni:
                    <ul class="flex gap-2">
                      <li 
                        v-for="allergen in allergens" 
                        class="border border-black rounded-full p-2 ms-2 cursor-pointer hover:bg-gray-300"
                        @click="matchDish(dish.id, allergen.id)" 
                        :id="`${dish.id}-${allergen.id}`"
                        :class="{'bg-green-500': allergensDishes.some(allergenDish => allergenDish.id === allergen.id && allergenDish.dishes.some(dishAbb => dishAbb.pivot.dish_id === dish.id))}">
                        <button>
                          {{ allergen.name }}
                        </button>
                      </li>    
                  </ul>
                  </div>
                </li>
              </ul>
         
 
            <div type="button" @click="addDishes(category.id)" class="p-4 flex justify-start items-center gap-2 cursor-pointer">
              <div class="font-bold text-lg">&#10133</div>
              <span>Aggiungi piatto</span>
              
            </div>
 
          </div>
      </div>
     </div>
     
     </div>
  </section>


  <section class="section-create-dishes" v-if="showAddDishesModal">
    <div class="modal-confirm">
        <h2 class="h-16 font-bold text-2xl text-center">
            Aggiungi nuovo piatto
        </h2>
        <div class="flex flex-col gap-4 flex-wrap">
          <label for="name">Nome piatto</label>
          <input type="text" 
          class="border-2 hover:border-black focus:border-black rounded" 
          v-model="dish_enoteca_category.name" 
          :placeholder="dish_enoteca_category.name ? dish_enoteca_category.name : 'nome piatto'"
          >
          <!-- devo aggiungere anche descpription price, image -->
          <label for="description">Descrizione</label>
          <textarea 
          :placeholder="dish_enoteca_category.description ? dish_enoteca_category.description : 'descrizione piatto'"
          class="border-2 hover:border-black focus:border-black rounded"
          v-model="dish_enoteca_category.description"></textarea>
          <label for="price">Prezzo</label>
          <div>
            <input type="number" 
            :placeholder="dish_enoteca_category.price ? dish_enoteca_category.price : 'prezzo del piatto'"
            class="border-2 hover:border-black focus:border-black rounded"
            v-model="dish_enoteca_category.price"><span> euro</span>
          </div>
          <label for="image">Immagine</label>
          <input type="file"
          v-on:change="onFileChange" ref="file" accept="image/*">


          <div class="flex gap-20 p-10">
            <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmAddDishes()">conferma</button>
            <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showAddDishesModal = false">Annulla</button>
          </div>
        </div>
    </div>
</section>

<section class="section-delete" v-if="showDeleteModal">
    <div class="modal-confirm">
        <h2 class="h-20 font-bold text-2xl text-center">
            Sei sicuro di voler eliminare questa categoria?
            <p class="text-base">la cancellazione della categoria provvederà a cancellare TUTTI i piatti abbinati</p>
        </h2>
        <div class="flex w-100 justify-between p-5">
            <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmDelete()">Conferma</button>
            <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showDeleteModal = false">Annulla</button>
        </div>
    </div>
</section>

<section class="section-edit" v-if="showEditModal">
    <div class="modal-confirm">
        <h2 class="h-20 font-bold text-2xl text-center">
            Modifica categoria
        </h2>
        <input type="text" v-model="category_enoteca.name" :placeholder="category_enoteca.name">
        <div class="flex w-100 justify-between p-5">
            <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEdit(category_enoteca.name)">edit</button>
            <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showEditModal = false">Annulla</button>
        </div>
    </div>
</section>

</template>


<script>
import axios from 'axios';
import Switch_button from '@/Components/Switch_button.vue';


export default {
  components: {
    Switch_button,
  },
  name: 'Category',
  props: {
    category_enoteca: Array,
    selectedVenueColor: String,
    dish_enoteca_category: Array,
    allergens: Array,
    allergensDishes: Array,
    is_drink: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      componentKeyli: 0,
      showDeleteModal: false,
      categoryToDelete: null,
      showEditModal: false,
      categoryToEdit: null,
      categoryNameToEdit: null,
      showAddDishesModal: false,
      dishToCreateId: null,
      localCategory_enoteca: this.category_enoteca,
      localDishEnotecaCategory: [],
      allergensDishes: this.allergensDishes,
      isMatch: false,
    };
  },
  methods: {
        deleteCategory(id) {
            this.categoryToDelete = id;
            this.showDeleteModal = true;
        },
        confirmDelete() {
            axios.delete(`/api/dishes/${this.categoryToDelete}`)
                .then(response => {
            
                axios.delete(`/api/categories/${this.categoryToDelete}`)
                .then(response => {
                const index = this.localCategory_enoteca.findIndex(category => category.id === this.categoryToDelete);
                if (index !== -1) {
                    this.localCategory_enoteca.splice(index, 1);
                }
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
            this.showEditModal = true;  
            this.categoryToEdit = id;
            this.categoryNameToEdit = this.localCategory_enoteca.find(category => category.id === id).name;

        },
        confirmEdit(value) {
            axios.put(`/api/categories/${this.categoryToEdit}`, { name: value })
            .then(response => {
                const index = this.localCategory_enoteca.findIndex(category => category.id === this.categoryToEdit)
                if (index !== -1) {
                    this.localCategory_enoteca[index].name = value;
                } 
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
        },
        onFileChange(e) {
        let files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createImage(files[0]);
        },
        createImage(file) {
          let reader = new FileReader();
          let vm = this;
          reader.onload = (e) => {
            vm.dish_enoteca_category.image = e.target.result;
          };
          reader.readAsDataURL(file);
        },
        addDishes(id) {
          this.showAddDishesModal = true;
          this.dishToCreateId = id;
        },
        confirmAddDishes() {
          let formData = new FormData();
          formData.append('name', this.dish_enoteca_category.name);
          formData.append('description', this.dish_enoteca_category.description);
          formData.append('price', this.dish_enoteca_category.price);
          formData.append('image', this.dish_enoteca_category.image);
          formData.append('category_id', this.dishToCreateId);
          formData.append('venue_id', 3);

          axios.post(`/api/dishes/${this.dishToCreateId}`, formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(response => {
            if (response.data && response.data.name && response.data.description && response.data.price && response.data.image) {
              let newDish = response.data;
              let category = this.category_enoteca.find(category => category.id === this.dishToCreateId);
              if (category) {
                category.dishes.push(newDish);
                this.dishToCreateId = '';
              }
              this.$emit('dishAdded');
              this.componentKeyli++;
            } else {
              console.error("Server response does not contain expected data");
            }
          })
          .catch(error => {
            console.log(error);
          });
          this.showAddDishesModal = false;
        },
        matchDish(dishId, allergenId) {
          const allergenSpecific = document.getElementById(`${dishId}-${allergenId}`);
          const isMatched = this.allergensDishes.some(allergenDish => allergenDish.id === allergenId && allergenDish.dishes.some(dishAbb => dishAbb.pivot.dish_id === dishId));
        
          if (isMatched) {
            axios.delete(`/api/allergens/${allergenId}/dishes/${dishId}`)
            .then(() => {
              allergenSpecific.classList.remove('bg-green-500');
              const index = this.allergensDishes.findIndex(allergenDish => allergenDish.id === allergenId);
              const dishIndex = this.allergensDishes[index].dishes.findIndex(dishAbb => dishAbb.pivot.dish_id === dishId);
              this.allergensDishes[index].dishes.splice(dishIndex, 1);
            })
            .catch(error => {
              console.log(error);
            });
          } else {
            axios.post(`/api/allergens/${allergenId}/dishes`, {
              dish_id: dishId
            })
            .then(() => {
              allergenSpecific.classList.add('bg-green-500');
              const index = this.allergensDishes.findIndex(allergenDish => allergenDish.id === allergenId);
              this.allergensDishes[index].dishes.push({pivot: {dish_id: dishId}});
            })
            .catch(error => {
              console.log(error);
            });
          }
        },
        created() {
            this.localDishEnotecaCategory = this.category_enoteca.map(category => {
                let dishes = this.dish_enoteca_category.filter(dish => dish.category_id === category.id);
                return {
                    ...category,
                    dishes: dishes
                };
            });

            this.allergenDishes = this.allergensDishes;
        },
      },
};
</script>


<style scoped>
  .bg-olive {
    background-color: #6b7238;
}
.bg-enoteca {
    background-color: #a51a1a;
}
.border-red{
  border-color: #a51a1a;
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