<template>
    <button class="absolute top-5 right-5" @click="showModalDish()">❌</button>
    <div class="container-dish-show">
        <h2 class="h-20 flex justify-between items-center font-bold text-2xl border border-3 border-black px-5">
            Scheda del piatto:
            <span class="text-4xl uppercase text-red-500">
            {{ selectedDish.name }}
            </span> 
        </h2>
        <div class="h-10 flex justify-between items-center font-bold text-xl border border-3 border-t-0 border-black px-5">
            ID Database: {{ selectedDish.id }}
        </div>
        <div class="grid-show-dish">
            <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: nome;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        nome:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ selectedDish.name }}
                    </span>
                </div>
                <ButtonCss @click="openInputName()">
                    Modifica
                </ButtonCss>
            </div>
            <div class="min-h-30 p-2 border-2 border-black" style="grid-area: immagine;">
                <div class="flex justify-between items-center">
                    <span class="font-black me-2 uppercase">
                        immagine
                    </span>
                    <ButtonCss>
                            Modifica
                    </ButtonCss>
                </div>
                <img :src="selectedDish.image? '/storage/' + selectedDish.image : 'img/defaultDish.jpg' " :alt="selectedDish.name + ' image'" class="h-image my-2 border border-3 border-black object-cover">
            </div>
            <div class="h-fit flex items-center p-2 border-2 border-black" style="grid-area: allergeni;">
                <span class="font-black me-2 uppercase">
                    Allergeni: 
                </span>
                <ul class="flex gap-2" v-if="activeAllergens.length">
        
                        <li 
                            v-for="allergen in activeAllergens" 
                            :key="allergen.id" 
                            class="rounded-full cursor-pointer"
                            :id="`${selectedDish.id}-${allergen.id}`"
                            @click="matchDish(selectedDish.id, allergen.id)" 
                            :class="{ 'bg-olive': isAllergenMatched(allergen.id) }"
                        >
                            <img :src="'/storage/' + allergen.icon" :alt="allergen.name + ' icon'" class="object-contain w-10 h-10 rounded-full border border-3 border-black">
                        </li>
                </ul>
                <div class="w-full ps-2 font-black uppercase text-red-600 underline decoration-4 underline-offset-4 text-center" v-else>
                            Non sono presenti allergeni attivi
                </div>


            </div>
            <div class="h-fit p-2 border-2 border-black" style="grid-area: consigli;">
                <div class="w-full flex justify-between items-center font-black uppercase">
                    Consigli:
                    <ButtonCss @click="openInputDescription()">
                        Modifica
                    </ButtonCss>
                </div>
                <span class="uppercase font-semibold text-red-500">
                    {{ selectedDish.description === 'undefined' ? 'Non ci sono consigli in questo piatto al momento' : selectedDish.description }}
                </span>
            </div>
            <div class="h-fit p-2 border-2 border-black flex items-center justify-between" style="grid-area: prezzo;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        prezzo:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ selectedDish.price }}
                    </span>
                </div>
                <ButtonCss @click="openInputPrice()">
                    Modifica
                </ButtonCss>
            </div>
            <div class="h-fit p-2 border-2 border-black" style="grid-area: abbinamenti;">
                <div class="flex gap-2 justify-between items-center">
                    <div class="font-black uppercase">
                        abbinamenti
                    </div>
                    <ButtonCss>
                        Modifica
                    </ButtonCss>
                </div>
                <ul class="flex gap-2">
    
                    <template v-for="dish in pairings" :key="localComponentAllergen">
                        <template v-for="drink in dish.drinks">
                            <li class="px-4 py-1 border border-3 border-black rounded-full" v-if="dish.id === selectedDish.id" >{{ drink.name }}</li>
                        </template>
                    </template>
                </ul>
            </div>
        </div>
        <div class="button_delete">
            <div @click="openDeleteModalDish( selectedDish.id )" class="p-2 rounded-2xl text-center text-white uppercase font-extrabold bg-red-600 cursor-pointer">
                Elimina piatto: {{ selectedDish.name }}
            </div>
        </div>
    </div>

    <!-- MODALS -->
     <div v-if="showModalDeleteDish" class="z-50">
         <ModalAction :showModal="showModalDeleteDish" :selectedDish="selectedDish">
             <h2 class="h-20 font-bold text-2xl text-center">
             Sei sicuro di voler eliminare il piatto: 
             {{ 
                 selectedDish.name
             }}?
             </h2>
             <div class="flex w-100 justify-between p-5">
             <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmDeleteDish( selectedDish.id )">Conferma</button>
             <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalDeleteDish = false">Annulla</button>
             </div>
         </ModalAction>
     </div>

     <div v-if="showModalEditName" class="z-50">
         <ModalAction :showModal="showModalEditName" :selectedDish="selectedDish">
                <h2 class="font-bold text-2xl text-center">
                Modifica il nome del piatto: 
                </h2>

                <div class="text-xl pb-4 first-letter:uppercase mb-8">
                    nome attuale: 
                    <span class="text-red-500 text-xl">
                        {{ selectedDish.name }}
                    </span>
                </div>

                <label for="name" class="font-bold text-xl">Nome:</label>
                <input type="text" class="w-full border-1 border-black rounded" v-model="copySelectedDish.name">


                <div class="flex w-full justify-between py-5">
                    <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEditName( copySelectedDish )">Conferma</button>
                    <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalEditName = false">Annulla</button>
                </div>
         </ModalAction>
     </div>

     <div v-if="showModalEditPrice" class="z-50">
         <ModalAction :showModal="showModalEditPrice" :selectedDish="selectedDish">
            <h2 class="font-bold text-2xl text-center pb-6">
                Modifica il prezzo del piatto: 
            </h2>

            <div class="text-xl pb-4 first-letter:uppercase mb-8">
                    prezzo attuale: 
                    <span class="text-red-500 text-xl">
                        {{ selectedDish.price }} €
                    </span>
                </div>

            <label for="name" class="font-bold text-xl">Nome:</label>
            <input type="number" class="w-full border-1 border-black rounded" v-model="copySelectedDish.price">


            <div class="flex w-full justify-between py-5">
                    <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEditPrice( copySelectedDish )">Conferma</button>
                    <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalEditPrice = false">Annulla</button>
                </div>
         </ModalAction>
     </div>

     <div v-if="showModalEditDescription" class="z-50">
        <ModalAction :showModal="showModalEditDescription" :selectedDish="selectedDish">
            <h2 class="font-bold text-2xl text-center pb-6">
                Modifica i consigli del piatto: 
            </h2>

            <div class="text-xl pb-4 first-letter:uppercase mb-8">
                    descrizione attuale: 
                    <span class="text-red-500 text-xl">
                        {{ selectedDish.description }}
                    </span>
            </div>

            <label for="name" class="font-bold text-xl">Consiglio:</label>
            <input type="text" class="w-full border-1 border-black rounded" v-model="copySelectedDish.description">


            <div class="flex w-full justify-between py-5">
                    <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEditDescription( copySelectedDish )">Conferma</button>
                    <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalEditDescription = false">Annulla</button>
            </div>
        </ModalAction>
     </div>

</template>


<script>
import ButtonCss from '../ButtonCss.vue';
import ModalAction from '../ModalAction.vue';


export default {
    
    props: ['selectedDish', 'showModalDish', 'allergens','allergensDishes', 'pairingsEnoteca', 'componentAllergen'],
    components: {
        ButtonCss,
        ModalAction
    },
    data() {
        return {
            showModalEditName: false,
            showModalDeleteDish: false,
            showModalEditPrice: false,
            showModalEditDescription: false,
            dishIdToDelete: null,
            copySelectedDish: null,
            arrayAllergens: this.allergensDishes,
            pairings: this.pairingsEnoteca,
            localComponentAllergen: this.componentAllergen
        }
    },
    methods: {
        showModalDish(){
            this.$emit('showModalDish');
        },
        openDeleteModalDish(dishId){
            this.dishIdToDelete = dishId;
            this.showModalDeleteDish = true;
        },
        confirmDeleteDish(id){
            this.$emit('deleteDish', id);
            this.showModalDeleteDish = false;
        },
        matchDish(dishId, allergenId){
            const allergenSpecific = document.getElementById(`${dishId}-${allergenId}`)
            this.$emit('matchDish', dishId, allergenId);
            allergenSpecific.classList.toggle('bg-olive')
        },
        isAllergenMatched(allergenId) {
            const allergenDish = this.allergensDishes.find(allergenDish => allergenDish.id === allergenId);
            if (!allergenDish) {
                return false;
            }
            return allergenDish.dishes.some(dish => dish.pivot.dish_id === this.selectedDish.id);
        },
        openInputName(){
            this.showModalEditName = true;
        },
        confirmEditName(dishNew){
            this.selectedDish.name = dishNew.name
            this.showModalEditName = false;
        },
        openInputPrice(){
            this.showModalEditPrice = true;
        },
        confirmEditPrice(dishNew){
            this.selectedDish.price = dishNew.price
            this.showModalEditPrice = false;
        },
        openInputDescription(){
            this.showModalEditDescription = true;
        },
        confirmEditDescription(dishNew){
            this.selectedDish.description = dishNew.description
            this.showModalEditDescription = false;
        }
    },
    computed: {
        activeAllergens() {
          return this.allergens.filter(allergen => allergen.is_active);
        }
    },
    mounted() {
        this.copySelectedDish = Object.assign({}, this.selectedDish);
    },
    watch: {
    componentAllergen(newVal) {
      this.localComponentAllergen = newVal;
    }
  }
}

</script>

<style scoped>

.bg-olive{
    background-color: #6b7238;
}

.container-dish-show{
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
        "consigli consigli immagine"
        "abbinamenti abbinamenti abbinamenti";
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

.button-delete{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 10vh;
}

</style>