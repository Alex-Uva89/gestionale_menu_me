<script>

export default {
  props: {
    selectedVenueName: String,
    selectedVenueColor: String, 
    selectedValueButton: String
  }
};


</script>

<template>
    <header class="header">
      <div class="flex h-full items-center"
      :class="{
        'bg-blue-700': selectedVenueColor === 'blue'|| selectedVenueColor === '',
        'bg-olive': selectedVenueColor === 'green',
        'bg-stone-500': selectedVenueColor === 'gray',
        'bg-enoteca': selectedVenueColor === 'red',
        'text-orange-500': selectedVenueColor === 'gray',
      }">
        <h1 v-if="selectedVenueName" class="ms-2">{{ selectedVenueName }}</h1>
        <h1 v-else class="ms-2">{{ selectedValueButton }}</h1>
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