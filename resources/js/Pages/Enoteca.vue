<script setup>
import Modal from '@/Components/Modal.vue';
import Switch_button from '@/Components/Switch_button.vue';


const props = defineProps({
    selectedVenueName: String,
    selectedVenueColor: String,
    category_enoteca: Array,
});

</script>

<template>
<div class="section_accordion relative">
  <section class="accordion overflow-x-hidden">
    <h2 class="p-3"  v-if="category_enoteca.length === 0">
      ⭐ Inizia <strong class="uppercase">aggiungendo</strong> una categoria
    </h2>
   
    <div 
    class="tab border border-black flex justify-between" 
    v-for="category in category_enoteca" :key="category.id">
        <div class="flex max-h-14 bg-white items-center gap-3 p-2">
            <button @click="deleteCategory(category.id)">❌</button>
            <button @click="editCategory(category.id)">Edit</button>
            <Switch_button @switchChanged="value => updateIsShowStatus(category.id, value)" />
        </div>
        <div class="box-accordion columns-7xl"
        :class="{
          'bg-blue-700': selectedVenueColor === 'blue'|| selectedVenueColor === '',
          'bg-olive': selectedVenueColor === 'green',
          'bg-stone-500': selectedVenueColor === 'gray',
          'bg-enoteca': selectedVenueColor === 'red',
          'text-orange-500': selectedVenueColor === 'gray',
        }" >
            <input type="checkbox" name="accordion-1" :id="'cb' + category.id">
            <label :for="'cb'+ category.id" class="tab__label uppercase text-white text-center font-bold cursor-pointer">{{ category.name }}</label>
            <div class="tab__content bg-white">
              <div type class="p-4 flex justify-start items-center gap-2">
                <div class="font-bold text-lg">&#10133</div>
                <span>Aggiungi piatto</span>
              </div>

            </div>
        </div>
    </div>
  
  </section>
  <section class="add_category fixed bottom-5 left-80 right-72" >
    <div class="p-5 w-4/5 border-2 border-black rounded-t-2xl uppercase text-white text-center font-bold cursor-pointer" 
    :class="{
          'bg-blue-700': selectedVenueColor === 'blue'|| selectedVenueColor === '',
          'bg-olive': selectedVenueColor === 'green',
          'bg-stone-500': selectedVenueColor === 'gray',
          'bg-enoteca': selectedVenueColor === 'red',
          'text-orange-500': selectedVenueColor === 'gray',
        }">aggiungi categorie</div>
    
    <div class="w-4/5 bg-white p-5 border-2 border-black rounded-b-2xl">
      <form class="flex justify-between items-center" @submit.prevent="createCategory(3)">
        <input v-model="newCategory.name" type="text" placeholder="Nome categoria" id="inputCategory">
        <div>
          <button type="submit">Salva</button>
          <span> | </span>
          <button type="reset">Annulla</button>
        </div>
      </form>
    </div>
  
  </section>
</div>

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

export default {
    components: {
        Modal,
        Switch_button,

    },
    props: {
        category_enoteca: Array,
    },
  data() {
  return {
    newCategory: {
      name: '',
    },
    venues: [],
    localCategory_enoteca: this.category_enoteca,
    showDeleteModal: false,
    showEditModal: false,
  }
},
methods: {
    createCategory(venue_ids) {
        const venue_id = [venue_ids];
        const newCategory = { name: this.newCategory.name};

        axios.post('/api/categories', newCategory)
        .then(response => {
            console.log('RESPONSE category');
            console.log(response.data);
            this.category = response.data;
            this.localCategory_enoteca.push(response.data);
            
            axios.post(`/api/categories/${response.data.id}/venues`, {category_id: response.data.id, venue_id})
            .then(response => {
                console.log('RESPONSE venue');
                console.log(response.data);
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
    watch: {
        category_enoteca(newVal) {
        this.localCategory_enoteca = newVal;
        },
    },
    deleteCategory(id) {
      this.categoryToDelete = id;
      this.showDeleteModal = true;
    },
    confirmDelete() {
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
    showCategory(id) {
      axios.get(`/api/categories/${id}`)
       .then(response => {
          console.log('RESPONSE show');
          console.log(response.data);
          this.category = response.data;
        })
       .catch(error => {
          console.log(error);
        });
    },
    updateIsShowStatus(categoryId, value) {
      axios.put(`/api/categories/${categoryId}`, { is_active: value })
      .then(response => {
          console.log('RESPONSE update');
          console.log(response.data);
          this.category = response.data;
        })
      .catch(error => {
          console.log(error);
        });
    },
},

}
</script>

<style scoped>

.section_accordion{
  overflow: scroll;
  overflow-x: hidden;
  min-height: calc(100vh - 7rem);
  scrollbar-width: thin;
}

.bg-olive {
    background-color: #6b7238;
}

.bg-enoteca {
    background-color: #a51a1a;
}

section.accordion{
  width: 90%;
  margin: 10px auto;
}

.add_category{
  margin: 10px auto;
  width: 90%;
}

.section-delete, .section-edit{
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

