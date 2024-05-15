<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';

const props = defineProps({
    selectedVenueName: String,
    selectedVenueColor: String,
    categories: Array,
});

</script>

<template>
<div class="section_accordion">
  <section class="accordion overflow-x-hidden">
    <div class="tab border border-black" 
    :class="{
          'bg-blue-700': selectedVenueColor === 'blue'|| selectedVenueColor === '',
          'bg-olive': selectedVenueColor === 'green',
          'bg-stone-500': selectedVenueColor === 'grey',
          'bg-enoteca': selectedVenueColor === 'red',
          'text-orange-500': selectedVenueColor === 'grey',
        }" v-for="category in categories">
      <input type="checkbox" name="accordion-1" :id="'cb' + category.id">
      <label :for="'cb'+ category.id" class="tab__label uppercase text-white text-center font-bold cursor-pointer">{{ category.name }}</label>
      <div class="tab__content bg-white">
        <p>Pure CSS accordion based on the "input:checked + label" style trick.</p>
      </div>
    </div>
  
  </section>
  <section class="add_category" >
    <div class="p-5 border-2 border-black rounded-t-2xl uppercase text-white text-center font-bold cursor-pointer" 
    :class="{
          'bg-blue-700': selectedVenueColor === 'blue'|| selectedVenueColor === '',
          'bg-olive': selectedVenueColor === 'green',
          'bg-stone-500': selectedVenueColor === 'grey',
          'bg-enoteca': selectedVenueColor === 'red',
          'text-orange-500': selectedVenueColor === 'grey',
        }">aggiungi categorie</div>
    
    <div class="flex justify-between items-center bg-white p-5 border-2 border-black rounded-b-2xl">
      <form @submit.prevent="createCategory(category)">
      <input v-model="category.name" type="text" placeholder="Nome categoria">
      <button type="submit">Salva</button>
      <button type="reset">Annulla</button>
    </form>
    </div>
  
  </section>
</div>

    
</template>

<script>
import axios from 'axios';

export default {
  data() {
  return {
    category: {
      name: ''
    }
  }
},
methods: {
    async createCategory(category) {
      try {
        await axios.post('/api/categories', category);
        this.category.name = ''; // Reset the input field
        this.getCategories(); // Fetch the updated list
      } catch (error) {
        console.error(error);
      }
    },
    async getCategories() {
      try {
        const response = await axios.get('/api/categories');
        this.categories = response.data;
      } catch (error) {
        console.error(error);
      }
    }
  },
  created() {
    this.getCategories(); // Fetch the list when the component is created
  }
};
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

</style>

