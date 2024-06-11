<template>
    <section class="accordion overflow-x-hidden mx-4" >
    <h2 class="p-3"  v-if="!category_enoteca.some(category => category.is_drink)">
  ⭐    Inizia <strong class="uppercase">aggiungendo</strong> una categoria beverage
    </h2>
     <div 
     v-for="category in category_enoteca" 
     :key="category.id">
     <div v-if="category.is_drink" class="tab drink border border-black category  bg-white" >
        <div class="flex max-h-14 bg-white justify-evenly items-center gap-3 p-2">
            <button @click="deleteCategory(category.id)">❌</button>
            <button @click="editCategory(category.id)">Edit</button>
            <Switch_button :value="category.is_active === 1" @switchChanged="value => updateIsShowStatus(category.id, value)" />
        </div>
       <div class="bg-yellow-500" :key="componentKeyli" >
            <input type="checkbox" name="accordion-1" :id="'cb' + category.id">
            <label :for="'cb'+ category.id" class="tab__label uppercase text-white text-center font-bold cursor-pointer">{{ category.name }}</label>
            <div class="tab__content bg-white" >
                <ul class="max-w-full" >
                  <li v-for="drink in category.drinks">
                        <div class="container-drinks px-3">
                          <div class="flex">
                            <img :src="drink.image = 'undefined' ? 'img/defaultDish.jpg' : drink.image" alt="drink image" class="sm:max-h-32 md:max-h-40 object-cover p-2">
                          </div>
                          <div class="flex flex-col name">
                            <span class="text-bold">Nome drink: </span><span class="first-letter:uppercase">{{ drink.name }}</span>
                          </div>
                          <div class="flex flex-col price">
                            <span class="text-bold">Prezzo: </span><span>{{ drink.price }} €</span>
                          </div>
                        </div>
                  </li>
                </ul>
           

              <div type="button" @click="addDrink(category.id)" class="p-4 flex justify-start items-center gap-2 cursor-pointer">
                <div class="font-bold text-lg">&#10133</div>
                <span>Aggiungi bevanda</span>
              </div>
            </div>
        </div>
    </div>
     </div>
   
  
  </section>


  <section class="section-create-drinks" v-if="showAddDrinksModal">
    <div class="modal-confirm">
        <h2 class="h-16 font-bold text-2xl text-center">
            Aggiungi nuovo drink
        </h2>
        <div class="flex flex-col gap-4 flex-wrap">
          <label for="name">Nome drink</label>
          <input type="text" 
          class="border-2 hover:border-black focus:border-black rounded" 
          v-model="drink_enoteca_category.name" 
          :placeholder="drink_enoteca_category.name ? drink_enoteca_category.name : 'nome drink'"
          >
          <label for="description">Consigli</label>
          <textarea 
          :placeholder="drink_enoteca_category.description ? drink_enoteca_category.description : 'consigli drink'"
          class="border-2 hover:border-black focus:border-black rounded"
          v-model="drink_enoteca_category.description"></textarea>
          <label for="price">Prezzo</label>
          <div>
            <input type="number" 
            :placeholder="drink_enoteca_category.price ? drink_enoteca_category.price : 'prezzo del drink'"
            class="border-2 hover:border-black focus:border-black rounded"
            v-model="drink_enoteca_category.price"><span> euro</span>
          </div>
          <label for="image">Immagine</label>
          <input type="file"
          v-on:change="onFileChange" ref="file" accept="image/*">


          <div class="flex gap-20 p-10">
            <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmAddDrinks()">conferma</button>
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
  name: 'CategoryDrink',
  props: {
    drinks: Array,
    category_enoteca: Array,
    selectedVenueColor: String,
    drink_enoteca_category: Array,
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
      showAddDrinksModal: false,
      drinkToCreateId: null,
      localCategory_enoteca: this.category_enoteca,
      localDrinkEnotecaCategory: [],
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
            vm.drink_enoteca_category.image = e.target.result;
          };
          reader.readAsDataURL(file);
        },
        addDrink(id) {
          this.showAddDrinksModal = true;
          this.drinkToCreateId = id;
        },
        confirmAddDrinks() {
          let formData = new FormData();
          formData.append('name', this.drink_enoteca_category.name);
          formData.append('description', this.drink_enoteca_category.description);
          formData.append('price', this.drink_enoteca_category.price);
          formData.append('image', this.drink_enoteca_category.image);
          formData.append('category_id', this.drinkToCreateId);
          formData.append('venue_id', 3);
        
          axios.post(`/api/drinks`, formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(response => {
            if (response.data && response.data.name && response.data.description && response.data.price && response.data.image) {
              let newDrink = response.data;
              let category = this.category_enoteca.find(category => category.id === this.drinkToCreateId);
              axios.post(`/api/categories/${this.drinkToCreateId}/drinks`, { drink_id: newDrink.id })
              .then(response => {
                this.componentKeyli++;
                if (category) {
                  category.drinks.push(newDrink);
                  this.$emit('updateDrinks', newDrink);
                  this.drinkToCreateId = '';
                }
              })
              .catch(error => {
                console.log(error);
              });
            } else {
              console.error("Server response does not contain expected data");
            }
          })
          .catch(error => {
            console.log(error);
          });
        
          this.showAddDrinksModal = false;
        },
  },
  watch: {
    category_enoteca(newVal) {
      this.localCategory_enoteca = newVal;
    },

  },
  created() {
          this.localDrinkEnotecaCategory = this.category_enoteca.map(category => {
              let drinks = this.drink_enoteca_category.filter(drink => drink.category_id === category.id);
              return {
                  ...category,
                  drinks: drinks
              };
          });

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

.section-delete, .section-edit, .section-create-drinks{
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