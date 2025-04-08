<template>
  <section class="flex gap-10 overflow-x-hidden mx-4">
    <h2 class="p-3"  v-if="!venue.categories">
  ⭐    Inizia <strong class="uppercase">aggiungendo</strong> una categoria {{ category_relation.table_category_name }}
    </h2>

    <template v-else>
      <!-- food -->
      <div v-for="relation1 in category_relations" class="container-category">
    
        
        <form class="grid grid-cols-5" @submit.prevent="createCategory(venue.id, relation1)">
            <h2 class="text-2xl col-span-5 font-bold text-center uppercase">{{ relation1.classification }}</h2>
            <div class="flex flex-col gap-2 col-span-4">
              <label for="inputCategory">Aggiungi categoria {{ relation1.classification }}</label>
              <input v-model="newCategory[relation1.table_category_name].name" type="text" placeholder="Nome categoria" :id="`input${relation1.table_category_name}`">
            </div>
            
            <button type="submit" class=" self-end col-span-1 justify-self-center">
                <svg xmlns="https://www.w3.org/2000/svg" width="35" height="35" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </button>
        </form>
    
        <!-- categorie -->
        <div v-for="category in venue.categories"  :key="keyComponentCategory">
          <!-- {{ console.log('RELATIONS',venue.categories) }} -->
          
          <div v-if="category.category_relations_id===relation1.id">
            <!-- {{ category.name }} -->

            <div class="last:border-b-2  border-l-2 border-r-2  border-black">
              <div class="tab category  bg-white" v-if="!category.deleted_at ">
                <div class="flex max-h-20 bg-white justify-evenly items-center gap-3 p-2">
                  <button @click="deleteCategory(category, relation1)">❌</button>
                  <button @click="editCategory(category)">Edit</button>
                  <Switch_button :value="category.is_active === 1 || category.is_active === true" @switchChanged="value => updateIsShowStatus(category.id, value)" />
                </div>
              <div class="p-2 bg-header-category" :style="{ backgroundColor: relation1.css.bg_color, color: relation1.css.color }" :key="componentKeyli">
                <input type="checkbox" name="accordion-1" :id="'cb' + category.id">
                <label :for="'cb'+ category.id" class="tab__label uppercase text-white font-bold cursor-pointer">
                  <span class="rounded-2xl text-black w-20 h-8 bg-white p-1 flex justify-center items-center">{{ activeDishesCount(category, relation1) }} / {{ category[relation1.table_category_name].length }}</span>            
                  <!-- {{ console.log(typeof(activeDishesCount(category.id, relation1))) }} -->
                  <span>
                    {{ category.name }}
                  </span>
                  <span class="tab__label__arrow">
                    <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                      <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                    </svg>
                  </span>
                </label>
                <div class="tab__content text-black bg-white" >
                    <ul class="max-w-full">
                      <li v-for="item in category[relation1.table_category_name]" :key="item.name" class="border-b-2 border-black p-2">
                        <div class="w-full h-full" :class="item.is_active ? 'opacity-100' : 'opacity-20'">
                          <div @click="openShow(item, relation1)" class="px-3 cursor-pointer" :class="`container-{{ relation1.table_category_name }}`">
                            <div class="flex">
                              <img :src="item.image == null ? 'img/defaultDish.jpg' : item.image "  alt="{{item.name}}" class="sm:max-h-32 md:max-h-40 object-cover p-1" >                    
                            </div>
                            <div class="flex flex-col name">
                              <span class="first-letter:uppercase text-bold">{{ item.name }}</span>
                            </div>
                            <div class="flex flex-col price">
                              <span class="text-bold">{{ item.price }} €</span>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                    <div type="button" @click="addItem(category, relation1)" class="p-4 flex justify-start items-center gap-2 cursor-pointer">
                      <div class="font-bold text-lg">&#10133;</div>
                      <span>Aggiungi {{ relation1.table_category_name }}</span>
                    </div>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </section>


<!-- MODALS -->

  <ModalAction :showModal="showAddsubjectModal" :key="keyComponent">
    <div class="modal-confirm relative">
        <ButtonCss hoverColor="#DC2626" @click="showAddsubjectModal = false" style="position: absolute; right:-10px; top:-20px;">
                  ❌
        </ButtonCss>
        <h2 class="h-16 font-bold text-2xl text-center">
            Aggiungi nuovo piatto
        </h2>
        <!-- {{ console.log('DEBUG MODALE', newItem) }} -->
        <form @submit.prevent="confirmAddDishes">
          <div class="grid-show-dish">
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: nome;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          nome:
                      </div>
                      <input class="w-full h-8" type="text" v-model="newItem.name" :placeholder="newItem.name">
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
                            :src="allergen.icon" 
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
                  <input class="w-full h-16" type="text" v-model="newItem.description" :placeholder="newItem.description">
              </div>
              <div class="h-fit p-2 border-2 border-black flex items-center justify-between" style="grid-area: prezzo;">
                  <div class="flex flex-col gap-2 w-full">
                      <div class="font-black uppercase">
                          prezzo:
                      </div>
                      <input class="w-full h-8" type="number" v-model="newItem.price" :placeholder="newItem.price">
                      <input type="hidden"  value="{{ this.subjectModal }}" v-model="newItem.relation">
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

        <!-- <form v-else @submit.prevent="confirmAddDrinks">
          <input type="hidden"  value="drinks" v-model="newItem.relation">
          <div class="grid-show-drink">
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: nome;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          nome:
                      </div>
                      <input class="w-full h-8" type="text" v-model="newItem.name" :placeholder="newItem.name">
                  </div>
                  
              </div>
              <div class="min-h-30 p-2 border-2 border-black" style="grid-area: immagine;">
                  <div class="flex flex-col justify-between items-start">
                      <span class="font-black me-2 uppercase">
                          immagine
                      </span>
                      <input type="file" @change="onFileChange" accept="image/*">
                  </div>
                  <img :src="imagePreview == null? defaultImgDish : imagePreview" class="h-image my-2 border border-3 border-black object-cover">
              </div>            
              <div class="h-fit flex items-center p-2 border-2 border-black" style="grid-area: allergeni;">
                  <span class="font-black me-2 uppercase">
                      Allergeni: 
                  </span>
                  <ul class="flex gap-2">
                      <template v-for="allergen in allergens">
                        <li v-if="allergen.is_active" class="rounded-full cursor-pointer" @click="toggleAllergen(allergen.id)" :key="allergen.id">
                          <img 
                            :src="allergen.icon" 
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
                  <input class="w-full h-16" type="text" v-model="newItem.instruction" :placeholder="newItem.instruction">
                </div>
                <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: ingredienti;">
                  <div class="w-full flex flex-col gap-2">
                    <div class="font-black uppercase">
                      ingredienti:
                      </div>
                      <input class="w-full h-8" type="text" v-model="newItem.description" :placeholder="newItem.description">
                  </div>
                  
              </div>
              <div class="h-fit p-2 border-2 border-black flex items-center justify-between" style="grid-area: gradi;">
                  <div class="flex flex-col gap-2 w-full">
                      <div class="font-black uppercase">
                          gradi:
                      </div>
                      <input class="w-full h-8" type="number" v-model="newItem.degrees" :placeholder="newItem.degrees">
                  </div>
              </div>
              <div class="h-fit p-2 border-2 border-black flex items-center justify-between" style="grid-area: prezzo;">
                  <div class="flex flex-col gap-2 w-full">
                      <div class="font-black uppercase">
                          prezzo:
                      </div>
                      <input class="w-full h-8" type="number" v-model="newItem.price" :placeholder="newItem.price">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: origine;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          origine:
                      </div>
                      <input class="w-full h-8" type="text" v-model="newItem.origin" :placeholder="newItem.origin">
                  </div>
                  
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: colore;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          colore:
                      </div>
                      <input class="w-full h-8" type="text" v-model="newItem.color" :placeholder="newItem.color">
                  </div>
                  
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: produzione;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          metodo di produzione:
                      </div>
                      <select class="w-full h-8" v-model="newItem.production_method" placeholder="Scegli un metodo">
                          <option value="distillazione">Distillazione</option>
                          <option value="aFreddo">A freddo</option>
                          <option value="infusione">Infusione</option>
                          <option value="macerazione">Macerazione</option>
                          <option value="percolazione">Percolazione</option>
                      </select>
                  </div>
                  
                </div>
                <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: sapore;">
                  <div class="w-full flex flex-col gap-2">
                    <div class="font-black uppercase">
                      sapore:
                      </div>
                      <input class="w-full h-8" type="text" v-model="newItem.flavour" :placeholder="newItem.flavour">
                  </div>
              </div>
          </div>
  
          <div class="flex w-full justify-center">
                <ButtonCss v-bind:disabled="!isFormFilled" hoverColor='#00FF00' type="submit" style="width: 100%;">
                  <p>
                    Aggiungi bevanda
                  </p>
                </ButtonCss>
              </div>
        </form> -->
    </div>
  </ModalAction>

  <ModalAction :showModal="showDeleteModal">

      <div class="modal">
          <h2 class="font-bold text-center">
              <p class="pb-5 text-xl">
                Sei sicuro di voler eliminare la categoria {{ subjectModal.name }}
              </p>
              <p class="border border-red-600 border-2 p-2 mb-5 bg-red-200 w-98">
                <strong>Attenzione:</strong>
                l'azione è <strong class="uppercase">irreversibile</strong>
              </p>
          </h2>
          <div class="flex w-100 justify-between p-5">
              <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmDelete(subjectModal)">Conferma</button>
              <button class="bg-green border-black border-2 rounded text-black p-3 w-32" @click="showDeleteModal = false">Annulla</button>
          </div>
      </div>
  </ModalAction>

  <ModalAction :showModal="showEditModal">
      <div class="modal">
          <h2 class="h-20 font-bold text-2xl text-center">
              Modifica categoria {{ subjectModal.name }}
          </h2>
          <input type="text" v-model="subjectModal.name" :placeholder="subjectModal.name" class="w-full">
          <div class="flex w-full justify-between py-5">
            <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEdit(subjectModal.name)">Modifica</button>              
            <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showEditModal = false">Annulla</button>
          </div>
      </div>
  </ModalAction>
  
  <ModalAction :showModal="showModalItem">
    <ShowItem 
    :subjectModal="subjectModal"
    :allergens="allergens"
    :allergensDishes="allergensDishes"
    :pairingsEnoteca="pairingsEnoteca"
    :pairings="pairings"
    :drinks="drinks"
    :newDrinko="newDrinko"
    @showModalItem="showModalItem = false"
    @deleteDish="confirmDeleteDish"
    @matchAllergens="matchAllergens"
    />
  </ModalAction>

</template>


<script>
import axios from 'axios';
import Switch_button from '@/Components/Switch_button.vue';
import ModalAction from '@/Components/ModalAction.vue';
import ShowItem from '@/Components/Sections/ShowEditDish.vue';
import ButtonCss from '@/Components/ButtonCss.vue';
import defaultImgDish from '../../../../public/img/defaultDish.jpg';
import {ref} from 'vue';

export default { 
  components: {
    Switch_button,
    ModalAction,
    ShowItem,
    ButtonCss
  },
  name: 'Category',
  emits: ['update:venue.categories'],
  props: {
    selectedVenueColor: String,
    allergens: Array,
    drinks: Array,
    allergensDishes: Array,
    is_drink: {
      type: Boolean,
      required: true
    },
    pairingsEnoteca: Array,
    venue: Array,
    categories: Object,
    category_relation: Object,
    category_relations: Array,
    table_category_name: String,
  },
  data() {
    return {
      keyComponentCategory: 0,
      defaultImgDish,
      selectedAllergens: [],
      selectedDrinks: [],
      file: null,
      componentKeyli: 0,
      showModalItem: false,
      showDeleteModal: false,
      // showModalDeleteDish: false,
      categoryToDelete: null,
      showEditModal: false,
      categoryToEdit: null,
      // categoryNameToEdit: null,
      showAddsubjectModal: false,
      categoryItemId: null,
      dishTodeleteId: null,
      localDishCategory: [],
      allergensDishes: this.allergensDishes,
      isMatch: false,
      imagePreview: null,
      arrayPairings: this.pairingsEnoteca,
      pairings: [],
      dishActive: [],
      newDrinko: this.newDrink,
      venue: this.venue,
      categories: [],
      newItem: {},
      newCategory: {
        dishes :{},
        drinks :{}
      },
      category_relation :this.category_relation,
      table_category_name: this.table_category_name,
      category_relations :this.category_relations,
      subjectModal: {},
    };
  },
  methods: {

        deleteCategory(_category, _relation) {
            this.subjectModal = {
              selectedCategory: _category,
              relation: _relation
            }
            this.categoryToDelete = _category.id;
            this.showDeleteModal = true;
        },
        confirmDelete(_subjectModal) {
          axios.delete(`/api/categories/${this.categoryToDelete}/${_subjectModal.relation.table_category_name}`)
                .then(response => {
            
                axios.delete(`/api/categories/${this.categoryToDelete}`)
                .then(response => {
                const index = this.venue.categories.findIndex(category => category.id === this.categoryToDelete);
                if (index !== -1) {
                    this.venue.categories.splice(index, 1);
                }
                this.$emit('update:venue.categories', this.venue.categories);
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
        editCategory(category) {
            this.subjectModal = category;
            this.showEditModal = true;  
            this.categoryIdToEdit = category.id;
            // this.categoryNameToEdit = this.venue.categories.find(category => category.id === id).name;
            // console.log('DEBUG CATEGORY NAME TO EDIT', this.categoryNameToEdit);
            // console.log('DEBUG VALUE CONFIRM EDIT', this.subjectModal);
        },
        confirmEdit(value) {
            axios.put(`/api/categories/${this.categoryIdToEdit}`, { name: value })
            .then(response => {
                // per aggiornare categoria a FE
                // if (index !== -1) {
                  //     this.venue.categories[index] = response.data;
                  // } 
                  // TODO: si può riutilizzare per aggiornare qualunque dato?
                  // console.log('venue.categories', this.venue.categories);
                  // console.log('venue.categories response', response.data);
                  // this.venue.categories = response.data;
                  // console.log('DEBUG RESPONSE', response);
                  if(response.headers['content-type'] === 'application/json'){
                    if(response.data.id == this.categoryIdToEdit){
                      // const index = this.venue.categories.findIndex(category => category.id === this.categoryIdToEdit)
                      // console.log(response.data, this.venue.categories[index], index, this.venue.categories);
                      // this.venue.categories[index] = response.data;
                      // console.log('DEBUG responsedata', response.data)
                      this.subjectModal['name'] = response.data.name;
                    } else {
                      throw new Error('ID RESPONSE NON CORRISPONDENTE');
                    }
                  } else {
                    throw new Error('CONTENT-TYPE ERRATO');
                  }
                })
                .catch(error => {
                  console.error(error);
                  // TODO: creare modale errore globale per mostrare errore 
                });

                this.showEditModal = false;
        },
        updateIsShowStatus(categoryId, value) {
          // console.log('DEBUG UPDATE IS SHOW STATUS', categoryId, value);
          axios.put(`/api/categories/${categoryId}`, { is_active: value })
          .then(response => {
            // console.log('DEBUG RESPONSE', response);
            // this.venue.categories = response.data
            if(response.data.id != categoryId){
              console.log('AGGIORNAMENTO NON RIUSCITO');
              // TODO: creare modale errore globale per mostrare errore 
            }
          })
          .catch(error => console.log(error));
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
        addItem(_category, _relation) {
          this.showAddsubjectModal = true;
          this.subjectModal = _relation
          this.categoryItemId = _category.id;
          console.log('_CATEGORY', _category, _relation)
        },
        confirmAddDishes() {
          console.log('NEW ITEM', this.newItem)
          let formData = new FormData();
          formData.append('name', this.newItem.name);
          formData.append('description', this.newItem.description ? this.newItem.description : ''); // laravel grazie al kernel.php inviando una stringa vuota lo interpreta come null
          formData.append('price', this.newItem.price);
          formData.append('image', this.file ? this.file : ''); // laravel grazie al kernel.php inviando una stringa vuota lo interpreta come null
          formData.append('category_id', this.categoryItemId);
          formData.append('venue_id', this.venue.id);

          if(this.subjectModal.table_category_name == 'drinks'){
            // formData.append('description', this.newItem.description);
            formData.append('instructions', this.newItem.instructions ? this.newItem.instructions : '');
            formData.append('color' , this.newItem.color ? this.newItem.color : '');
            formData.append('degrees' , this.newItem.degrees ? this.newItem.degrees :'');
            formData.append('origin' , this.newItem.origin ? this.newItem.origin : '');
            formData.append('production_method' , this.newItem.production_method ? this.newItem.production_method : '');
            formData.append('flavour' , this.newItem.flavour ? this.newItem.flavour : '');
          }

          // const newItemSerializedObject = JSON.stringify(this.newItem);

          // console.log('DEBUG FORM NEW ITEM', this.newItem.description);
          // console.log('DEBUG FORM DATA IMAGE', formData.get('image'));
        
          axios.post(`/api/${this.subjectModal.table_category_name}/${this.categoryItemId}`, formData, { 
            headers: {
              'Content-Type': 'application/json'
            }
          })
          .then(response => {
            // console.log('DEBUG RESPONSE NEW ITEM', response);

            let newItem;
            if (typeof response.data === 'string') {
                let data = response.data;
                data = data.substring(data.indexOf('{'));
                newItem = JSON.parse(data);
            } else {
                newItem = response.data;
            }

            let category = this.venue.categories.find(category => category.id === this.categoryItemId);
            

            if (category) {
              if (!category[this.subjectModal.table_category_name]) {
                category[this.subjectModal.table_category_name] = [];
              }
              category[this.subjectModal.table_category_name].push(newItem);
              this.categoryItemId = '';
            }
            this.$emit(`'${this.subjectModal.table_category_name}Added'`);
            this.componentKeyli++;
            this.showAddsubjectModal = false;
        
            this.selectedAllergens.forEach(allergenId => {
              this.matchAllergens(newDish.id, allergenId);
            });
            this.selectedAllergens = [];
        
            
            this.selectedDrinks.forEach(drinkId => {
              
              this.matchDrink(newDish.id, drinkId);
            });
            this.selectedDrinks = [];


            this.newItem.name = '';
            this.newItem.description = '';
            this.newItem.price = null;
            this.file = null;
            this.imagePreview = null;
            // drink
            this.newItem.instructions ? this.newItem.instructions = null : undefined;
            this.newItem.color ? this.newItem.color = null : undefined;
            this.newItem.degrees ? this.newItem.degrees = null : undefined;
            this.newItem.origin ? this.newItem.origin = null : undefined;
            this.newItem.production_method ? this.newItem.production_method = null : undefined;
            this.newItem.flavour ? this.newItem.production_method = null : undefined;
          })
        
          .catch(error => {
            console.log('ERRORE AHI AHI AHI: '+ error);
          });

        },
        // confirmAddDrinks() {
        //   let formData = new FormData();
        //   formData.append('name', this.newItem.name);
        //   formData.append('description', this.newItem.description ? this.newItem.description : ''); // laravel grazie al kernel.php inviando una stringa vuota lo interpreta come null
        //   formData.append('price', this.newItem.price);
        //   formData.append('image', this.file? this.file : ''); // laravel grazie al kernel.php inviando una stringa vuota lo interpreta come null
        //   formData.append('category_id', this.categoryItemId);
        //   formData.append('venue_id', this.venue.id);
        //   formData.append('instructions', this.newItem.instructions);
        //   formData.append('color' , this.newItem.color);
        //   formData.append('degrees' , this.newItem.degrees);
        //   formData.append('origin' , this.newItem.origin);
        //   formData.append('production_method' , this.newItem.production_method);
        //   formData.append('flavour' , this.newItem.flavour);

        //   // const newItemSerializedObject = JSON.stringify(this.newItem);

        //   // console.log('DEBUG FORM NEW ITEM', this.newItem.description);
        //   // console.log('DEBUG FORM DATA IMAGE', formData.get('image'));
        
        //   axios.post(`/api/drinks/${this.categoryItemId}`, formData, { 
        //     headers: {
        //       'Content-Type': 'application/json'
        //     }
        //   })
        //   .then(response => {
        //     // console.log('DEBUG RESPONSE NEW ITEM', response);

        //     let newDish;
        //     if (typeof response.data === 'string') {
        //         let data = response.data;
        //         data = data.substring(data.indexOf('{'));
        //         newDish = JSON.parse(data);
        //     } else {
        //         newDish = response.data;
        //     }

        //     let category = this.venue.categories.find(category => category.id === this.categoryItemId);
            

        //     if (category) {
        //       if (!category.dishes) {
        //         category.dishes = [];
        //       }
        //       category.dishes.push(newDish);
        //       this.categoryItemId = '';
        //     }
        //     this.$emit('dishAdded');
        //     this.componentKeyli++;
        //     this.showAddsubjectModal = false;
        
        //     this.selectedAllergens.forEach(allergenId => {
        //       this.matchAllergens(newDish.id, allergenId);
        //     });
        //     this.selectedAllergens = [];
        
            
        //     this.selectedDrinks.forEach(drinkId => {
              
        //       this.matchDrink(newDish.id, drinkId);
        //     });
        //     this.selectedDrinks = [];


        //     this.newItem.name = '';
        //     this.newItem.description = '';
        //     this.newItem.price = null;
        //     this.file = null;
        //     this.imagePreview = null;
        //   })
        
        //   .catch(error => {
        //     console.log('ERRORE AHI AHI AHI: '+ error);
        //   });

        // },
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
        confirmDeleteDish(_subjectModal) {
          console.log('SELECTED DRINK', _subjectModal)
          axios.delete(`/api/${_subjectModal.relation.table_category_name}/${_subjectModal.selectedItem.id}`)
          .then(() => {
            for (let category of this.venue.categories) {
              let index = category[_subjectModal.relation.table_category_name].findIndex(item => item.id === _subjectModal.selectedItem.id);
              if (index !== -1) {
                category[_subjectModal.relation.table_category_name].splice(index, 1);
              }
            }
            this.showModalItem = false;
          })
          .catch(error => {
            console.log(error);
          });
        },
        // openShowDish(dishId) {
        //   console.log('dishId', dishId)
        //   this.selectedDish = dishId;
        //   this.showModalitem = !this.showModalitem;
        // },
        openShow(item, relation ) {
          console.log('item', item)
          console.log('relation', relation)
          this.selectedItem = item;
          this.subjectModal = {
            selectedItem : this.selectedItem,
            relation: relation
          }
          this.showModalItem = !this.showModalItem;
        },
        // addDrink(newDrink) {
        //   if(newDrink) {
        //     let index = this.selectedDrinks.indexOf(newDrink);
        //     if (index === -1) {
        //       this.selectedDrinks.push(newDrink);
        //     } else {
        //       this.selectedDrinks.splice(index, 1);
        //     }
        //   }

        // },
        createCategory(_venue_id, relation) {
          const newCategory =  {
              name: this.newCategory[relation.table_category_name].name,
              category_relations_id: relation.id,
              venue_id: _venue_id
            };
          // console.log('DEBUG NEW CATEGORIES', newCategory)
          axios.post('/api/categories', newCategory)
          .then(response => {
            response.data[relation.table_category_name] = [];
              this.venue.categories.push(response.data)

              this.newCategory[relation.table_category_name].name = '';
              this.keyComponentCategory++
          })
          .catch(error => {
              console.log(error);
          });
        },

        activeDishesCount(category, relation) {
          // console.log(category, relation);
          let typeRelation = relation.table_category_name;
          // console.log('DEBUG TYPE',typeRelation);
          // console.log(category[typeRelation].filter(item => item.is_active).length)

          return category[typeRelation].filter(item => item.is_active).length;

          // if (this.venue.categories) {
          //   this.venue.categories.forEach(category => {
          //     // let activeDishes = category[typeP].filter(dish => dish.is_active);
          //     let activeDishes = category[typeP].filter(dish => {
          //       console.log('Checking dish:', dish); // 🔍 Vedi ogni piatto elaborato
          //       return dish.is_active;
          //     });
          //     activeDishesCount[category.id] = activeDishes.length;
          //   });

          //   // console.log('CATEGORY REF', activeDishesCount);
          //   return activeDishesCount;
          // }
        }
  },
  created() {
    // dal venue prendiamo il orderView che coincide con l'indice di category[],dish_category[], etc...
    // e così otteniamo le categorie corrette rispetto al nostro id
    // attenzione: facciamo riferimento sempre all'id di orderview e non id della primary key.
    
    this.categories = forEach(this.venue, (venue) => {
      if (venue.orderView === this.category_relation.id) {
        this.category = venue.categories;
        this.dish_category = venue.dish_categories;
        this.drink_category = venue.drink_categories;
      }
    });
    
    this.localDishCategory = this.category[this.venue.id];
    this.dish_venue.categories = this.dish_category;
    // console.error('CATEGORY',this.venue.css);
    // console.log('VENUE',this.venue);
    // console.log('LOCAL DISH ENOTECA CATEGORY',this.localDishCategory);
            

          // console.log(this.localDishCategory);

          this.allergenDishes = this.allergensDishes;
  },
  computed: {
        isFormFilled() {
            return this.newItem.name && this.newItem.price;
        },
  },
  mounted() {
    // console.log(this.newDrink)
  },
  watch: {
    newDrink(newVal) {
      this.newDrinko = newVal // Dovrebbe loggare ogni volta che newDrink cambia
    }
    // newCategory(newVal) {
    //   this.xmlns
    // }
  },
  created() {
    // console.log('THIS VENUE IN CATEGORY',this.venue);
    this.venue.categories = this.venue.categories;
  }
};
</script>


<style scoped>
.container-category{
  margin-bottom: 50px;
  form{
    margin: 20px auto 0px;
    border-bottom: none;
    padding: 10px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    background-color: rgba(0, 0, 0, 0.060);
  }
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