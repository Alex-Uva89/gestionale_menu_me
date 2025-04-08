<script setup>
import { defineProps } from 'vue';

const { selectedVenue, selectedValueButton, components, default_id } = defineProps({
  selectedVenue: Object,
  selectedValueButton: Object,
  components: Object,
  default_id: Number
});

// ad apertura app ci mostra il component con il default_id che ci arriva da DB a 1, assegnato dal BE 
// (il cliente che vorrà una pagina default diversa inserirà invece di 0, 1 al componente richiesto)
// domattina è da completare il passaggio di click della sidebar, attualmente solo i ristoranti sono cliccabili
</script>

<template>
  <!-- {{ console.log('DEBUG HEADER', components) }} -->
  <header class="header">
    <div v-if="selectedVenue" class="flex h-full items-center" 
      :style="{ backgroundColor: selectedVenue.css.brand.bg_color }">
      <h1 class="ms-2">{{ selectedVenue.name }}</h1>
    </div>
    <div v-else class="flex h-full items-center"
      :style="{ backgroundColor: components[default_id]?.css?.bg_color || '' }">
      <h1 class="ms-2">{{ components[default_id]?.name || '' }}</h1>
    </div>
  </header>
</template>




<style scoped>
.header {
    height: 7rem;
    color: white;
    h1 {
        font-size: 3.5rem;
    }
}


.bg-olive {
    background-color: #6b7238;
}

.bg-enoteca {
    background-color: #a51a1a;
}




</style>