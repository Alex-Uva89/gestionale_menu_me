<script setup>

const props = defineProps({
    selectedVenueName: String,
    selectedVenueColor: String,
    category_enoteca: Array,
    dish_enoteca_category: Array,
    allergens: Array,
    allergensDishes: Array,
    drinks: Array,
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
     class="tab category  bg-white" 
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
              <ul class="max-w-full">
                <li v-for="dish in category.dishes" 
                class="border-b-2 border-black p-2"
                >
                  <div @click="openShowDish(dish)" class="container-dishes px-3 cursor-pointer">
                    <div class="flex">
                      <img :src="dish.image = 'undefined' ? 'img/defaultDish.jpg' : dish.image" alt="dish image" class="sm:max-h-32 md:max-h-40 object-cover p-1">
                    </div>
                    <div class="flex flex-col name">
                      <span class="text-bold">Nome piatto: </span><span class="first-letter:uppercase">{{ dish.name }}</span>
                    </div>
                    <div class="flex flex-col price">
                      <span class="text-bold">Prezzo: </span><span>{{ dish.price }} €</span>
                    </div>
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

<!-- MODALS -->

  <ModalAction :showModal="showAddDishesModal" :key="keyComponent">
    <div class="modal-confirm">
        <h2 class="h-16 font-bold text-2xl text-center">
            Aggiungi nuovo piatto
        </h2>
        <form  @submit.prevent="addDish">
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
                  <img :src="imagePreview" class="h-image my-2 border border-3 border-black object-cover">
              </div>            <div class="h-fit flex items-center p-2 border-2 border-black" style="grid-area: allergeni;">
                  <span class="font-black me-2 uppercase">
                      Allergeni: 
                  </span>
                  <ul class="flex gap-2">
                    <li class="rounded-full cursor-pointer">
                        <!-- <img :src="'/storage/' + allergen.icon" :alt="allergen.name + ' icon'" class="object-scale-down w-10 h-10 rounded-full border border-3 border-black"> -->
                           <p class="p-2 rounded-full border border-3 border-black">allergene 1</p>
                      </li>
                      <li class="rounded-full cursor-pointer">
                           <p class="p-2 rounded-full border border-3 border-black">allergene 1</p>
                      </li>
                      <li class="rounded-full cursor-pointer">
                           <p class="p-2 rounded-full border border-3 border-black">allergene 1</p>
                      </li>
                  </ul>
                  <!-- <div class="w-full ps-2 font-black uppercase text-red-600 underline decoration-4 underline-offset-4 text-center" v-else>
                              Non sono presenti allergeni attivi
                  </div> -->
  
  
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
                      <input class="w-full h-8" type="text" v-model="dish_enoteca_category.price" :placeholder="dish_enoteca_category.price">
                  </div>
              </div>
              <SelectMultiple :options="drinks" @updateComponent="addDrink" defaultLabel="Il mio testo personalizzato" style="grid-area: abbinamenti;" />
              {{ drinks }}
          </div>
  
          <div class="flex justify-evenly">
                <ButtonCss hoverColor='#00FF00' type="submit">
                  <p class="w-96">
                    Aggiungi piatto
                  </p>
                </ButtonCss>
                <ButtonCss hoverColor="#DC2626" @click="showAddDishesModal = false">
                  <p class="w-96">
                    Annulla
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
              <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEdit(category_enoteca.name)">edit</button>
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
    @showModalDish="showModalDish = false"
    @deleteDish="confirmDeleteDish"
    @matchDish="matchDish"
    />
  </ModalAction>

</template>


<script>
import axios from 'axios';
import Switch_button from '@/Components/Switch_button.vue';
import ModalAction from '@/Components/ModalAction.vue';
import ShowDish from '@/Components/Sections/ShowEditDish.vue';
import ButtonCss from '@/Components/ButtonCss.vue';
import SelectMultiple from '@/Components/SelectMultiple.vue';

export default {
  components: {
    Switch_button,
    ModalAction,
    ShowDish,
    ButtonCss
  },
  name: 'Category',
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
  },
  data() {
    return {
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
            vm.imagePreview = e.target.result;
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
              console.log('CATEGORY');
              console.log(category);
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
            keyComponent++;
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
      }
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
        "abbinamenti abbinamenti immagine"
        "allergeni allergeni immagine"
        "consigli consigli consigli";
    grid-template-columns: 2fr 1fr 1fr;
    grid-template-rows: 1fr 1fr 1fr 2fr 2fr;
    gap: 10px;
    overflow-y: scroll;
    scrollbar-width: none;
    .h-image{
        width: 100%;
        height: 80%;
    }
}


</style>