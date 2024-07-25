<script setup>

const props = defineProps({
    selectedVenueName: String,
    pairingsEnoteca: Array,
    selectedVenueColor: String,
    category_venues: Array,
    drink_category: Array,
    allergens: Array,
    allergensDrinks: Array,
    drinks: Array,
    venue: Number,
});


</script>


<template>
    <section class="overflow-x-hidden" >
    <h2 class="p-3"  v-if="!category_venues.some(category => category.is_drink)">
  ⭐    Inizia <strong class="uppercase">aggiungendo</strong> una categoria beverage
    </h2>

     <div 
     v-for="category in category_venues" 
     class="last:mb-10 last:border-b-2  border-l-2 border-r-2  border-black"
     :key="category.id">
     <div v-if="category.is_drink" 
     class="tab category  bg-white" >
        <div class="flex max-h-14 bg-white justify-evenly items-center gap-3 p-2">
            <button @click="deleteCategory(category.id)">❌</button>
            <button @click="editCategory(category.id)">Edit</button>
            <Switch_button :value="category.is_active === 1 || category.is_active === true" @switchChanged="value => updateIsShowStatus(category.id, value)" />
          </div>
          
       <div class="bg-yellow-500" :key="componentKeyli" >
            <input type="checkbox" name="accordion-1" :id="'cb' + category.id">
            <label :for="'cb'+ category.id" class="tab__label uppercase text-white text-center font-bold cursor-pointer">
              <span class="rounded-2xl text-black w-20 h-8 bg-white p-1 flex justify-center items-center">{{ activeDrinksCount[category.id] }} / {{ category.drinks ? category.drinks.length : 0 }}</span>            <span>
                {{ category.name }}
              </span>
              <span class="tab__label__arrow">
                <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                  <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
              </span>
            </label>
            <div class="tab__content bg-white">
              <ul class="max-w-full">
                <li v-for="drink in category.drinks" 
                    :key="drink.id"
                    class="border-b-2 border-black p-2">
                <div class="w-full h-full" :class="drink.is_active ? 'opacity-100' : 'opacity-20'">
                  <div @click="openShowDrink(drink)" class="container-drinks px-3 cursor-pointer">
                    <div class="flex">
                      <img :src="drink.image == 'null' || drink.image === '' || drink.image === 'undefined' ? 'img/defaultDish.jpg' : drink.image "  alt="drink image" class="sm:max-h-32 md:max-h-40 object-cover p-1" >                    
                    </div>
                    <div class="flex flex-col name">
                      <span class="first-letter:uppercase text-bold">{{ drink.name }}</span>
                    </div>
                    <div class="flex flex-col price">
                      <span class="text-bold">{{ drink.price }} €</span>
                    </div>
                  </div>
                </div>
                </li>
              </ul>

              
              <div type="button" @click="addDrink(category.id)" class="p-4 flex justify-start items-center gap-2 cursor-pointer">
                <div class="font-bold text-lg">&#10133;</div>
                <span>Aggiungi bevanda</span>
              </div>
            </div>
          </div>
        </div>
     </div>
  
  </section>


  <ModalAction :showModal="showAddDrinksModal" :key="keyComponent">
    <div class="modal-confirm relative">
        <ButtonCss hoverColor="#DC2626" @click="showAddDrinksModal = false" style="position: absolute; right:-10px; top:-20px;">
                  ❌
        </ButtonCss>
        <h2 class="h-16 font-bold text-2xl text-center">
            Aggiungi nuova bevanda a {{ category_venues.find(category => category.id === drinkToCreateId).name }}
        </h2>
        <form  @submit.prevent="confirmAddDrinks">
          <div class="grid-show-drink">
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: nome;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          nome:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.name" :placeholder="drink_category.name">
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
                  <input class="w-full h-16" type="text" v-model="drink_category.instruction" :placeholder="drink_category.instruction">
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: ingredienti;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          ingredienti:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.description" :placeholder="drink_category.description">
                  </div>
                  
              </div>
              <div class="h-fit p-2 border-2 border-black flex items-center justify-between" style="grid-area: gradi;">
                  <div class="flex flex-col gap-2 w-full">
                      <div class="font-black uppercase">
                          gradi:
                      </div>
                      <input class="w-full h-8" type="number" v-model="drink_category.degrees" :placeholder="drink_category.degrees">
                  </div>
              </div>
              <div class="h-fit p-2 border-2 border-black flex items-center justify-between" style="grid-area: prezzo;">
                  <div class="flex flex-col gap-2 w-full">
                      <div class="font-black uppercase">
                          prezzo:
                      </div>
                      <input class="w-full h-8" type="number" v-model="drink_category.price" :placeholder="drink_category.price">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: origine;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          origine:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.origin" :placeholder="drink_category.origin">
                  </div>
                  
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: colore;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          colore:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.color" :placeholder="drink_category.color">
                  </div>
                  
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: produzione;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          metodo di produzione:
                      </div>
                      <select class="w-full h-8" v-model="drink_category.production_method" placeholder="Scegli un metodo">
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
                      <input class="w-full h-8" type="text" v-model="drink_category.flavour" :placeholder="drink_category.flavour">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: vitigno;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          vitigno:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.grape_variety" :placeholder="drink_category.grape_variety">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: produttore;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          produttore:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.producer" :placeholder="drink_category.producer">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: denominazione;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          denominazione:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.denomination" :placeholder="drink_category.denomination">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: annata;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          annata:
                      </div>
                      <input class="w-full h-8" type="number" v-model="drink_category.vintage" :placeholder="drink_category.vintage">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: allevamento;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          metodo di allevamento:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.breeding_method" :placeholder="drink_category.breeding_method">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: formato;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          formato:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.format" :placeholder="drink_category.format">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: temperatura;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          temperatura di servizio:
                      </div>
                      <input class="w-full h-8" type="number" v-model="drink_category.serving_temperature" :placeholder="drink_category.serving_temperature">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: olfatto;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          olfatto:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.nose" :placeholder="drink_category.nose">
                  </div>
              </div>
              <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: certificazioni;">
                  <div class="w-full flex flex-col gap-2">
                      <div class="font-black uppercase">
                          certificazioni:
                      </div>
                      <input class="w-full h-8" type="text" v-model="drink_category.certifications" :placeholder="drink_category.certifications">
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
          <input type="text" v-model="category_venues.name" :placeholder="category_venues.name">
          <div class="flex w-100 justify-between p-5">
              <button  @click="console.log('Button clicked'); confirmEdit(category_venues.name)">edit</button>              
              <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showEditModal = false">Annulla</button>
          </div>
      </div>
  </ModalAction>

  <ModalAction :showModal="showModalDrink">
    <ShowDish 
    :selectedDrink="selectedDrink" 
    :allergens="allergens"
    :allergensDrinks="allergensDrinks"
    :category_venues="category_venues"
    :drink_category="drink_category"
    :pairingsEnoteca="pairingsEnoteca"
    :pairings="pairings"
    :drinks="drinks"
    @showModalDrink="showModalDrink = false"
    @deleteDish="confirmDeleteDish"
    @matchDish="matchDish"
    />
  </ModalAction>

</template>


<script>
import axios from 'axios';
import Switch_button from '@/Components/Switch_button.vue';
import ModalAction from '@/Components/ModalAction.vue';
import ShowDish from '@/Components/Sections/ShowEditDrink.vue';
import ButtonCss from '../ButtonCss.vue';
import defaultImgDish from '../../../../public/img/defaultDish.jpg';

export default {
  components: {
    Switch_button,
    ModalAction,
    ShowDish,
    ButtonCss
  },
  name: 'CategoryDrink',
  props: {
    drinks: Array,
    allergens: Array,
    allergensDrinks: Array,
    category_venues: Array,
    selectedVenueColor: String,
    drink_category: Array,
    is_drink: {
        type: Boolean,
        required: true
    }
  },
  data() {
    return {
      defaultImgDish,
      file: null,
      imagePreview: null,
      componentKeyli: 0,
      showDeleteModal: false,
      categoryToDelete: null,
      showEditModal: false,
      categoryToEdit: null,
      showModalDrink: false,
      categoryNameToEdit: null,
      showAddDrinksModal: false,
      drinkToCreateId: null,
      localcategory_venues: this.category_venues,
      localDrinkEnotecaCategory: [],
      allergensDrinks : this.allergensDrinks,
      selectedAllergens: [],
      venueId: this.venue,
    };
  },
  methods: {
        deleteCategory(id) {
            this.categoryToDelete = id;
            this.showDeleteModal = true;
        },
        confirmDelete() {
            axios.delete(`/api/drinks?category_id=${this.categoryToDelete}`)
                .then(response => {
                console.log('Deleted corresponding drinks');
            
                axios.delete(`/api/categories/${this.categoryToDelete}`)
                .then(response => {
                const index = this.localcategory_venues.findIndex(category => category.id === this.categoryToDelete);
                if (index !== -1) {
                    this.localcategory_venues.splice(index, 1);
                }
                console.log('RESPONSE delete');
                console.log(this.localcategory_venues);
                this.$emit('update:category_venues', this.localcategory_venues);
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
            this.categoryNameToEdit = this.localcategory_venues.find(category => category.id === id).name;
        },
        confirmEdit(value) {
            axios.put(`/api/categories/${this.categoryToEdit}`, { name: value })
            .then(response => {
                const index = this.localcategory_venues.findIndex(category => category.id === this.categoryToEdit)
                if (index !== -1) {
                    this.localcategory_venues[index].name = value;
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
        addDrink(id) {
          this.showAddDrinksModal = true;
          this.drinkToCreateId = id;
          console.log(this.venueId)
        },
        confirmAddDrinks() {
            let formData = new FormData();

            const addFieldToFormData = (key, value) => {
                if (value !== undefined && value !== null) {
                    formData.append(key, value);
                }
            };

            addFieldToFormData('name', this.drink_category.name);
            addFieldToFormData('description', this.drink_category.description);
            addFieldToFormData('price', this.drink_category.price);
            addFieldToFormData('instructions', this.drink_category.instructions); // corrected name
            addFieldToFormData('degrees', this.drink_category.degrees);
            addFieldToFormData('origin', this.drink_category.origin);
            addFieldToFormData('color', this.drink_category.color);
            addFieldToFormData('production_method', this.drink_category.production_method);
            addFieldToFormData('flavour', this.drink_category.flavour);
            addFieldToFormData('category_id', this.drinkToCreateId);
            addFieldToFormData('venue_id', this.venueId);
            addFieldToFormData('grape_variety', this.drink_category.grape_variety);
            addFieldToFormData('producer', this.drink_category.producer);
            addFieldToFormData('denomination', this.drink_category.denomination);
            addFieldToFormData('vintage', this.drink_category.vintage);
            addFieldToFormData('breeding_method', this.drink_category.breeding_method);
            addFieldToFormData('format', this.drink_category.format);
            addFieldToFormData('serving_temperature', this.drink_category.serving_temperature);
            addFieldToFormData('nose', this.drink_category.nose);
            addFieldToFormData('certifications', this.drink_category.certifications);

            const submitForm = (imageURL) => {
                if (imageURL === null) {
                    formData.append('image', imageURL);
                }

                axios.post(`/api/drinks/${this.drinkToCreateId}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    console.log('Response data:', response.data);
                    let newDrink;
                    if (typeof response.data === 'string') {
                        let data = response.data;
                        data = data.substring(data.indexOf('{'));
                        newDrink = JSON.parse(data);
                    } else {
                        newDrink = response.data;
                    }

                    let category = this.category_venues.find(category => category.id === this.drinkToCreateId);

                    if (category) {
                        if (!category.drinks) {
                            category.drinks = [];
                        }
                        category.drinks.push(newDrink);
                        this.drinkToCreateId = '';
                    }
                    this.componentKeyli++;
                    this.showAddDrinksModal = false;

                    this.$emit('drinkAdded', newDrink);

                    this.selectedAllergens.forEach(allergenId => {
                        this.matchAllergens(newDrink.id, allergenId);
                    });

                    this.selectedAllergens = [];

                    this.resetForm();
                })
                .catch(error => {
                    console.log('Error response:', error.response);
                    console.log('ERRORE AHI AHI AHI: ' + error);
                });
            };

            if (this.file === null || this.file === undefined) {
              submitForm(null);
            } else {
              this.uploadImage(this.file)
                  .then(response => {
                      submitForm(response.data.data.url);
                  })
                  .catch(error => {
                      console.log('ERRORE NELL\'UPLOAD DELL\'IMMAGINE: ' + error);
                      // Puoi scegliere di inviare il form anche se c'è un errore di upload
                      submitForm('null');
                  });
            }
        },
        matchAllergens(drinkId, allergenId) {

          const isMatched = this.allergensDrinks.some(allergenDrink => allergenDrink.id === allergenId && allergenDrink.drinks.some(drinkAbb => drinkAbb.pivot.drink_id === drinkId));

          if (isMatched) {
            axios.delete(`/api/allergens/${allergenId}/drinks/${drinkId}`)
            .then(() => {
              const index = this.allergensDrinks.findIndex(allergenDrink => allergenDrink.id === allergenId);
              const drinkIndex = this.allergensDrinks[index].drinks.findIndex(drinkAbb => drinkAbb.pivot.drink_id === drinkId);
              this.allergensDrinks[index].drinks.splice(drinkIndex, 1);
            })
            .catch(error => {
              console.log(error);
            });
          } else {
            axios.post(`/api/allergens/${allergenId}/drinks`, {
              drink_id: drinkId
            })
            .then(() => {
              
              const index = this.allergensDrinks.findIndex(allergenDrink => allergenDrink.id === allergenId);
              this.allergensDrinks[index].drinks.push({pivot: {drink_id: drinkId}});
            })
            .catch(error => {
              console.log(error);
            });
          }
        },
        openShowDrink(drink) {
          this.selectedDrink = drink;
          this.showModalDrink = !this.showModalDrink;
        },
  },
  watch: {
    category_venues(newVal) {
      this.localcategory_venues = newVal;
    },

  },
  created() {
          this.localDrinkEnotecaCategory = this.category_venues.map(category => {
              let drinks = this.drink_category.filter(drink => drink.category_id === category.id);
              return {
                  ...category,
                  drinks: drinks
              };
          });

          this.allergenDrinks = this.allergensDrinks
  },
  computed: {
    isFormFilled() {
            return this.drink_category.name && this.drink_category.price;
        },
        activeDrinksCount() {
          let activeDrinksCount = {};
          this.category_venues.forEach(category => {
            let activeDrinks = category.drinks ? category.drinks.filter(drink => drink.is_active) : [];
            activeDrinksCount[category.id] = activeDrinks.length;
          });
          return activeDrinksCount;
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
  width: 80vw;
}

.grid-show-drink{
  display: grid;
    margin: 20px 0;
    height: 62vh;
    grid-template-areas: 
        "nome nome immagine immagine"
        "prezzo prezzo immagine immagine"
        "allergeni allergeni immagine immagine"
        "abbinamenti abbinamenti immagine immagine"
        "consigli consigli immagine immagine"
        "gradi gradi origine origine"
        "colore colore produzione produzione"
        "sapore sapore ingredienti ingredienti"
        "vitigno vitigno produttore produttore"
        "denominazione denominazione annata annata"
        "allevamento allevamento formato formato"
        "temperatura temperatura olfatto olfatto"
        "certificazioni certificazioni . .";
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-template-rows: repeat(8, 1fr); /* Usa 8 righe di altezza uguale, adatta se necessario */
    gap: 10px;
    overflow-y: scroll;
    scrollbar-width: none;
  }
  .h-image{
      width: 100%;
      height: 80%;
  }
  
</style>