<script setup>

const props = defineProps({
    selectedVenueName: String,
    pairingsEnoteca: Array,
    selectedVenueColor: String,
    category_enoteca: Array,
    dish_enoteca_category: Array,
    allergens: Array,
    allergensDishes: Array,
    drinks: Array,
    newDrink: Array,
});


</script>

<template>
    <section class="overflow-x-hidden mx-4" :key="keyComponentCategory">
      <h2 class="p-3"  v-if="!category_enoteca.some(category => !category.is_drink)">
  ⭐    Inizia <strong class="uppercase">aggiungendo</strong> una categoria food
      </h2>
      
     <div 
     v-for="category in categoryEnoteca" 
     class="last:mb-10 last:border-b-2  border-l-2 border-r-2  border-black"
     :key="category.id">
     <div 
     class="tab category  bg-white" 
     v-if="!category.is_drink">
      <div class="flex max-h-20 bg-white justify-evenly items-center gap-3 p-2">
          <button @click="deleteCategory(category.id)">❌</button>
          <button @click="editCategory(category.id)">Edit</button>
          <Switch_button :value="category.is_active === 1 || category.is_active === true" @switchChanged="value => updateIsShowStatus(category.id, value)" />
      </div>
      
      <div
      class="p-2"
      :class="{
        'bg-blue-700': selectedVenueColor === 'blue'|| selectedVenueColor === '',
        'bg-olive': selectedVenueColor === 'green',
        'bg-stone-500': selectedVenueColor === 'gray',
        'bg-enoteca': selectedVenueColor === 'red',
        'text-orange-500': selectedVenueColor === 'gray',
      }" :key="componentKeyli">
          <input type="checkbox" name="accordion-1" :id="'cb' + category.id">
          <label :for="'cb'+ category.id" class="tab__label uppercase text-white font-bold cursor-pointer">
            <span class="rounded-2xl text-black w-20 h-8 bg-white p-1 flex justify-center items-center">{{ activeDishesCount[category.id] }} / {{ category.dishes ? category.dishes.length : 0 }}</span>            <span>
              {{ category.name }}
            </span>
            <span class="tab__label__arrow">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
              </svg>
            </span>
          </label>
          <div class="tab__content bg-white" >
              <ul class="max-w-full">
                <li v-for="dish in category.dishes" :key="dish.id" class="border-b-2 border-black p-2">
                  <div class="w-full h-full" :class="dish.is_active ? 'opacity-100' : 'opacity-20'">
                    <div @click="openShowDish(dish)" class="container-dishes px-3 cursor-pointer">
                      <div class="flex">
                        <img :src="dish.image == 'null' ? 'img/defaultDish.jpg' : '/storage/' + dish.image "  alt="dish image" class="sm:max-h-32 md:max-h-40 object-cover p-1" >                    
                      </div>
                      <div class="flex flex-col name">
                        <span class="first-letter:uppercase text-bold">{{ dish.name }}</span>
                      </div>
                      <div class="flex flex-col price">
                        <span class="text-bold">{{ dish.price }} €</span>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
         
 
            <div type="button" @click="addDishes(category.id)" class="p-4 flex justify-start items-center gap-2 cursor-pointer">
              <div class="font-bold text-lg">&#10133;</div>
              <span>Aggiungi piatto</span>
            </div>
 
          </div>
      </div>
     </div>
     </div>
  </section>

<!-- MODALS -->

  <ModalAction :showModal="showAddDishesModal" :key="keyComponent">
    <div class="modal-confirm relative">
        <ButtonCss hoverColor="#DC2626" @click="showAddDishesModal = false" style="position: absolute; right:-10px; top:-20px;">
                  ❌
        </ButtonCss>
        <h2 class="h-16 font-bold text-2xl text-center">
            Aggiungi nuovo piatto
        </h2>
        <form  @submit.prevent="confirmAddDishes">
          <div class="grid-show-dish">
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: nome;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          nome:
                      </div>
                      <input class="w-full h-8" type="text" v-model="dish_enoteca_category.name" :placeholder="dish_enoteca_category.name">
                  </div>
                  
              </div>
              <div class="min-h-30 p-2 border-2 border-black" style="grid-area: immagine;">
                  <div class="flex flex-col justify-between items-start">
                      <span class="font-black me-2 uppercase">
                          immagine
                      </span>
                      <input type="file" @change="onFileChange" accept="image/*">
                  </div>
                  <img :src="imagePreview === null? defaultImgDish : imagePreview" class="h-image my-2 border border-3 border-black object-cover">
              </div>            
              <div class="h-fit flex items-center p-2 border-2 border-black" style="grid-area: allergeni;">
                  <span class="font-black me-2 uppercase">
                      Allergeni: 
                  </span>
                  <ul class="flex gap-2">
                      <template v-for="allergen in allergens">
                        <li v-if="allergen.is_active" class="rounded-full cursor-pointer" @click="toggleAllergen(allergen.id)" :key="allergen.id">
                          <img 
                            :src="'/storage/' + allergen.icon" 
                            :alt="allergen.name + ' icon'" 
                            :id="allergen.id"
                            class="object-scale-down w-10 h-10 rounded-full border border-3 border-black">
                        </li>
                      </template>
                      <li v-if="!allergens.some(allergen => allergen.is_active)" class="w-full ps-2 font-black uppercase text-red-600 underline decoration-4 underline-offset-4 text-center">
                        Non sono presenti allergeni attivi
                      </li>
                  </ul>

              </div>
              <div class="h-fit p-2 border-2 border-black" style="grid-area: consigli;">
                  <div class="w-full flex justify-between items-center font-black uppercase">
                      Consigli:
                  </div>
                  <input class="w-full h-16" type="text" v-model="dish_enoteca_category.description" :placeholder="dish_enoteca_category.description">
              </div>
              <div class="h-fit p-2 border-2 border-black flex items-center justify-between" style="grid-area: prezzo;">
                  <div class="flex flex-col gap-2 w-full">
                      <div class="font-black uppercase">
                          prezzo:
                      </div>
                      <input class="w-full h-8" type="number" v-model="dish_enoteca_category.price" :placeholder="dish_enoteca_category.price">
                  </div>
              </div>
              <div style="grid-area: abbinamenti">
                <p>Aggiungi abbinamenti:</p>
                <SelectMultiple :options="drinks && newDrinkPairings" @updateComponent="addDrink" defaultLabel="Abbinamenti" style="text-transform: uppercase" />
              </div>
          </div>
  
          <div class="flex w-full justify-center">
                <ButtonCss v-bind:disabled="!isFormFilled" hoverColor='#00FF00' type="submit" style="width: 100%;">
                  <p>
                    Aggiungi piatto
                  </p>
                </ButtonCss>
          </div>
        </form>
    </div>
  </ModalAction>

  <ModalAction :showModal="showDeleteModal">
      <div class="modal">
          <h2 class="h-20 font-bold text-2xl text-center">
              Sei sicuro di voler eliminare questa categoria?
              <p class="text-base">la cancellazione della categoria provvederà a cancellare TUTTI i piatti abbinati</p>
          </h2>
          <div class="flex w-100 justify-between p-5">
              <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmDelete()">Conferma</button>
              <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showDeleteModal = false">Annulla</button>
          </div>
      </div>
  </ModalAction>

  <ModalAction :showModal="showEditModal">
      <div class="modal">
          <h2 class="h-20 font-bold text-2xl text-center">
              Modifica categoria
          </h2>
          <input type="text" v-model="category_enoteca.name" :placeholder="category_enoteca.name">
          <div class="flex w-100 justify-between p-5">
              <button  @click="console.log('Button clicked'); confirmEdit(category_enoteca.name)">edit</button>              
              <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showEditModal = false">Annulla</button>
          </div>
      </div>
  </ModalAction>
  
  <ModalAction :showModal="showModalDish">
    <ShowDish 
    :selectedDish="selectedDish" 
    :allergens="allergens"
    :allergensDishes="allergensDishes"
    :category_enoteca="category_enoteca"
    :dish_enoteca_category="dish_enoteca_category"
    :pairingsEnoteca="pairingsEnoteca"
    :pairings="pairings"
    :drinks="drinks"
    :newDrinko="newDrinko"
    @showModalDish="showModalDish = false"
    @deleteDish="confirmDeleteDish"
    @matchAllergens="matchAllergens"
    />
  </ModalAction>

</template>


<script>
import axios from 'axios';
import Switch_button from '@/Components/Switch_button.vue';
import ModalAction from '@/Components/ModalAction.vue';
import ShowDish from '@/Components/Sections/ShowEditDish.vue';
import ButtonCss from '@/Components/ButtonCss.vue';
import defaultImgDish from '../../../../public/img/defaultDish.jpg';

export default {
  components: {
    Switch_button,
    ModalAction,
    ShowDish,
    ButtonCss
  },
  name: 'Category',
  emits: ['update:category_enoteca'],
  props: {
    category_enoteca: Array,
    selectedVenueColor: String,
    dish_enoteca_category: Array,
    allergens: Array,
    drinks: Array,
    allergensDishes: Array,
    is_drink: {
      type: Boolean,
      required: true
    },
    pairingsEnoteca: Array,
  },
  data() {
    return {
      categoryEnoteca: this.category_enoteca,
      keyComponentCategory: 0,
      defaultImgDish,
      selectedAllergens: [],
      selectedDrinks: [],
      file: null,
      componentKeyli: 0,
      showModalDish: false,
      showDeleteModal: false,
      showModalDeleteDish: false,
      categoryToDelete: null,
      showEditModal: false,
      categoryToEdit: null,
      categoryNameToEdit: null,
      showAddDishesModal: false,
      dishToCreateId: null,
      dishTodeleteId: null,
      localCategory_enoteca: this.category_enoteca,
      localDishEnotecaCategory: [],
      allergensDishes: this.allergensDishes,
      isMatch: false,
      imagePreview: null,
      arrayPairings: this.pairingsEnoteca,
      pairings: [],
      dishActive: [],
      newDrinko: this.newDrink,
    };
  },
  methods: {

        deleteCategory(id) {
            this.categoryToDelete = id;
            this.showDeleteModal = true;
        },
        confirmDelete() {
          axios.delete(`/api/categories/${this.categoryToDelete}/dishes`)
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
              this.categoryEnoteca = this.categoryEnoteca.map(category => {
                  if (category.id === categoryId) {
                      category.is_active = value;
                  }
                  return category;
              });
            })
          .catch(error => {
              console.log(error);
            });
        },
        onFileChange(e) {
          this.files = e.target.files || e.dataTransfer.files;
          if (!this.files.length)
            return;
          this.file = this.files[0];
          this.createImage(this.files[0]);
        },
        createImage(file) {
          let reader = new FileReader();
          let vm = this;
          reader.onload = (e) => {
            vm.imagePreview = e.target.result;
          };
          reader.readAsDataURL(file);
        },
        toggleAllergen(allergenId) {
          const specificAllergen = document.getElementById(allergenId);
          const index = this.selectedAllergens.indexOf(allergenId);
          if (index === -1) {
            specificAllergen.classList.add('bg-olive');
            this.selectedAllergens.push(allergenId);
          } else {
            specificAllergen.classList.remove('bg-olive');
            this.selectedAllergens.splice(index, 1);
          }
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
          formData.append('image', this.file);
          formData.append('category_id', this.dishToCreateId);
          formData.append('venue_id', 3); 
        
          axios.post(`/api/dishes/${this.dishToCreateId}`, formData, { 
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(response => {
            let newDish;
            if (typeof response.data === 'string') {
                let data = response.data;
                data = data.substring(data.indexOf('{'));
                newDish = JSON.parse(data);
            } else {
                newDish = response.data;
            }
            let category = this.category_enoteca.find(category => category.id === this.dishToCreateId);
            

            if (category) {
              if (!category.dishes) {
                category.dishes = [];
              }
              category.dishes.push(newDish);
              this.dishToCreateId = '';
            }
            this.$emit('dishAdded');
            this.componentKeyli++;
            this.showAddDishesModal = false;
        
            this.selectedAllergens.forEach(allergenId => {
              this.matchAllergens(newDish.id, allergenId);
            });
            this.selectedAllergens = [];
        
            
            this.selectedDrinks.forEach(drinkId => {
              
              this.matchDrink(newDish.id, drinkId);
            });
            this.selectedDrinks = [];


            this.dish_enoteca_category.name = '';
            this.dish_enoteca_category.description = '';
            this.dish_enoteca_category.price = null;
            this.file = null;
            this.imagePreview = null;
          })
        
          .catch(error => {
            console.log('ERRORE AHI AHI AHI: '+ error);
          });

        },
        matchAllergens(dishId, allergenId) {

          const isMatched = this.allergensDishes.some(allergenDish => allergenDish.id === allergenId && allergenDish.dishes.some(dishAbb => dishAbb.pivot.dish_id === dishId));
        
          if (isMatched) {
            axios.delete(`/api/allergens/${allergenId}/dishes/${dishId}`)
            .then(() => {
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
              
              const index = this.allergensDishes.findIndex(allergenDish => allergenDish.id === allergenId);
              this.allergensDishes[index].dishes.push({pivot: {dish_id: dishId}});
            })
            .catch(error => {
              console.log(error);
            });
          }
        },
        matchDrink(dishId, drinkId) {
          
          axios.post(`/api/dishes/${dishId}/drinks`, { drink_id: drinkId.id })
            .then(response => {
              this.pairings.push(response.data);
            })
            .catch(error => {
              console.log(error);
            });
        },
        getDishName(dishId) {
          for (let category of this.localDishEnotecaCategory) {
            let foundDish = category.dishes.find(dish => dish.id === dishId);
            if (foundDish) {
              return foundDish.name;
            }
          }
          return 'Non trovato';
        },
        confirmDeleteDish(dishIdToDelete) {
          axios.delete(`/api/dishes/${dishIdToDelete}`)
          .then(() => {
            for (let category of this.category_enoteca) {
              let index = category.dishes.findIndex(dish => dish.id === dishIdToDelete);
              if (index !== -1) {
                category.dishes.splice(index, 1);
              }
            }
            this.showModalDish = false;
          })
          .catch(error => {
            console.log(error);
          });
        },
        openShowDish(dishId) {
          this.selectedDish = dishId;
          this.showModalDish = !this.showModalDish;
        },
        addDrink(newDrink) {
          if(newDrink) {
            let index = this.selectedDrinks.indexOf(newDrink);
            if (index === -1) {
              this.selectedDrinks.push(newDrink);
            } else {
              this.selectedDrinks.splice(index, 1);
            }
          }

        },
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
  computed: {
        isFormFilled() {
            return this.dish_enoteca_category.name && this.dish_enoteca_category.price;
        },

        activeDishesCount() {
          let activeDishesCount = {};
          this.category_enoteca.forEach(category => {
            let activeDishes = category.dishes ? category.dishes.filter(dish => dish.is_active) : [];
            activeDishesCount[category.id] = activeDishes.length;
          });
          return activeDishesCount;
        }
  },
  mounted() {
    console.log(this.newDrink)
  },
  watch: {
    newDrink(newVal) {
      this.newDrinko = newVal // Dovrebbe loggare ogni volta che newDrink cambia
    }
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

.modal-confirm{
    width: calc(100vw - 140px);
    height: calc(100vh - 110px);
    padding: 5px;
}

.grid-show-dish{
    display: grid;
    margin: 20px 0;
    height: 62vh;
    grid-template-areas: 
        "nome nome immagine"
        "prezzo prezzo immagine"
        "allergeni allergeni immagine"
        "abbinamenti abbinamenti immagine"
        "consigli consigli consigli";
    grid-template-columns: 2fr 1fr 1fr;
    grid-template-rows: 1fr 1fr 1fr 2fr 2fr;
    gap: 10px;
    overflow-y: scroll;
    scrollbar-width: none;
  }
  .h-image{
      width: 100%;
      height: 80%;
  }


</style>