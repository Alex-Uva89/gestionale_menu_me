<template>
    <button class="absolute top-5 right-5" @click="showModalDrink()">❌</button>
    <div class="container-drink-show" :key="localComponentAllergen">
        <h2 class="h-20 flex justify-between items-center font-bold text-2xl border border-3 border-black px-5">
            Scheda del drink:
            <span class="text-4xl uppercase text-red-500">
                {{ selectedDrink.name }}
            </span> 
            <SwitchButton :value="selectedDrink.is_active === 1 || selectedDrink.is_active === true" @switchChanged="value => updateIsShowStatus(selectedDrink.id, value)"  />
        </h2>
        <div class="h-10 flex justify-between items-center border border-3 border-t-0 border-black px-5">
            <span class="font-bold text-xl">ID Database: {{ selectedDrink.id }}</span>
        </div>
        <div class="grid-show-drink">
            
            <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: nome;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        nome:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ selectedDrink.name }}
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
                    <ButtonCss @click="openInputImg()">
                            Modifica
                    </ButtonCss>
                </div>
                <img :src="selectedDrink.image === 'null' || selectedDrink.image === 'undefined' ? 'img/defaultDish.jpg' : '/storage/' + selectedDrink.image" :alt="selectedDrink.name + ' image'" class="h-image my-2 border border-3 border-black object-cover">
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
                            :id="`${selectedDrink.id}-${allergen.id}`"
                            @click="matchDish(selectedDrink.id, allergen.id)" 
                            :class="{ 'opacity-100': isAllergenMatched(allergen.id), 'opacity-20': !isAllergenMatched(allergen.id) }"
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
                    {{ selectedDrink.description === 'undefined' ? 'Non ci sono consigli in questo drink al momento' : selectedDrink.description }}
                </span>
            </div>
            <div class="h-fit p-2 border-2 border-black flex items-center justify-between" style="grid-area: prezzo;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        prezzo:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ selectedDrink.price }}
                    </span>
                </div>
                <ButtonCss @click="openInputPrice()">
                    Modifica
                </ButtonCss>
            </div>
            <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: gradi;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        gradi:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ selectedDrink.degrees }}
                    </span>
                </div>
                <ButtonCss @click="openInputName()">
                    Modifica
                </ButtonCss>
            </div>
            <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: colore;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        colore:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ selectedDrink.color }}
                    </span>
                </div>
                <ButtonCss @click="openInputName()">
                    Modifica
                </ButtonCss>
            </div>
            <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: produzione;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        metodo di produzione:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ selectedDrink.production_method }}
                    </span>
                </div>
                <ButtonCss @click="openInputName()">
                    Modifica
                </ButtonCss>
            </div>
            <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: sapore;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        sapore:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ selectedDrink.flavour }}
                    </span>
                </div>
                <ButtonCss @click="openInputName()">
                    Modifica
                </ButtonCss>
            </div>
            <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: ingredienti;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        ingredienti:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ selectedDrink.description }}
                    </span>
                </div>
                <ButtonCss @click="openInputName()">
                    Modifica
                </ButtonCss>
            </div>   
            <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: origine;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        origine:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ selectedDrink.origin }}
                    </span>
                </div>
                <ButtonCss @click="openInputName()">
                    Modifica
                </ButtonCss>
            </div>  
        </div>
        <div class="button_delete">
            <div @click="openDeleteModalDish( selectedDrink.id )" class="p-2 rounded-2xl text-center text-white uppercase font-extrabold bg-red-600 cursor-pointer">
                Elimina drink: {{ selectedDrink.name }}
            </div>
        </div>
    </div>

    <!-- MODALS -->
     <div v-if="showModalDeleteDish" class="z-50">
         <ModalAction :showModal="showModalDeleteDish" :selectedDrink="selectedDrink">
             <h2 class="h-20 font-bold text-2xl text-center">
             Sei sicuro di voler eliminare il drink: 
             {{ 
                 selectedDrink.name
             }}?
             </h2>
             <div class="flex w-100 justify-between p-5">
             <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmDeleteDish( selectedDrink.id )">Conferma</button>
             <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalDeleteDish = false">Annulla</button>
             </div>
         </ModalAction>
     </div>

     <div v-if="showModalEditName" class="z-50">
         <ModalAction :showModal="showModalEditName" :selectedDrink="selectedDrink">
                <h2 class="font-bold text-2xl text-center">
                Modifica il nome del drink: 
                </h2>

                <div class="text-xl pb-4 first-letter:uppercase mb-8">
                    nome attuale: 
                    <span class="text-red-500 text-xl">
                        {{ selectedDrink.name }}
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
         <ModalAction :showModal="showModalEditPrice" :selectedDrink="selectedDrink">
            <h2 class="font-bold text-2xl text-center pb-6">
                Modifica il prezzo del drink: 
            </h2>

            <div class="text-xl pb-4 first-letter:uppercase mb-8">
                    prezzo attuale: 
                    <span class="text-red-500 text-xl">
                        {{ selectedDrink.price }} €
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
        <ModalAction :showModal="showModalEditDescription" :selectedDrink="selectedDrink">
            <h2 class="font-bold text-2xl text-center pb-6">
                Modifica i consigli del drink: 
            </h2>

            <div class="text-xl pb-4 first-letter:uppercase mb-8">
                    descrizione attuale: 
                    <span class="text-red-500 text-xl">
                        {{ selectedDrink.description }}
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

     <div v-if="showModalEditImg" class="z-50">
        <ModalAction :showModal="showModalEditImg" :selectedDrink="selectedDrink">
            <h2 class="font-bold text-2xl text-center pb-6">
                Modifica l'immagine del drink: 
            </h2>

            <div class="text-xl pb-4 first-letter:uppercase mb-8">
                <span v-if="imagePreview === null">
                    Immagine attuale: 
                </span>
                <span v-else>
                    Anteprima Immagine:
                </span>
                <span class="container-edit-img">
                        <img :src="imagePreview != null ? imagePreview : 'img/defaultDish.jpg'" :alt="selectedDrink.name + ' image'" class="object-img my-2 border border-3 border-black object-cover">                    
                    </span>
            </div>

            <label for="name" class="font-bold text-xl">Immagine:</label>
            <input id="editImg" type="file" @change="previewImage" class="w-full border-1 border-black rounded">

            <div class="flex w-full justify-between py-5">
                    <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEditImg( copySelectedDish )">Conferma</button>
                    <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalEditImg = false">Annulla</button>
            </div>
        </ModalAction>
     </div>

     <div v-if="showModalEditPairings" class="z-50">
        <ModalAction :showModal="showModalEditPairings" :selectedDrink="selectedDrink">
            <h2 class="font-bold text-2xl text-center pb-6">
                Modifica Gli abbinamenti del drink: 
            </h2>

            <div class="text-xl pb-4 first-letter:uppercase mb-8">
                <span>
                    Abbinamenti attuali: 
                </span>
                <ul class="flex gap-2">
                    <template v-for="drink in pairings">
                        <template v-for="drink in drink.drinks">
                            <li class="px-4 py-1 border border-3 border-black rounded-full" v-if="drink.id === selectedDrink.id" >{{ drink.name }}</li>
                        </template>
                    </template>
                    
                </ul>
            </div>

            <label for="name" class="font-bold text-xl">Abbinamenti:</label>
            <SelectMultiple ref="selectMultiple" :options="drinks" :selected="selectedDishDrinks" @updateComponent="toggleDrink" defaultLabel="Abbinamenti" style="text-transform: uppercase" />
            <div class="flex w-full justify-between py-5">
                    <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEditPairings( copySelectedDish )">Conferma</button>
                    <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalEditPairings = false">Annulla</button>
            </div>
        </ModalAction>
     </div>


</template>


<script>
import axios from 'axios';
import ButtonCss from '../ButtonCss.vue';
import ModalAction from '../ModalAction.vue';
import SwitchButton from '../Switch_button.vue';
import SelectMultiple from '../SelectMultiple.vue';


export default {
    
    name: 'ShowEditDish',
    props: ['selectedDrink', 'showModalDrink', 'allergens','allergensDrinks', 'pairingsEnoteca', 'drinks'],
    components: {
        ButtonCss,
        ModalAction,
        SwitchButton,
        SelectMultiple
    },
    emits: ['showModalDrink', 'deleteDish', 'matchDish'],
    data() {
        return {
            imagePreview: null,
            showModalEditName: false,
            showModalDeleteDish: false,
            showModalEditPrice: false,
            showModalEditDescription: false,
            showModalEditImg: false,
            showModalEditPairings: false,
            dishIdToDelete: null,
            copySelectedDish: null,
            arrayAllergens: this.allergensDrinks,
            pairings: [],
            localComponentAllergen: 0,
            selectedDishDrinks: []
        }
    },
    methods: {
        showModalDrink(){
            this.$emit('showModalDrink');
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
            this.$emit('matchDish', dishId, allergenId);
        },
        isAllergenMatched(allergenId) {
            const allergenDrink = this.allergensDrinks.find(allergenDrink => allergenDrink.id === allergenId)
            
            if (!allergenDrink) {
                return false;
                }

            return allergenDrink.drinks.some(drink => drink.pivot.drink_id === this.selectedDrink.id);
        },
        openInputName(){
            this.showModalEditName = true;
        },
        confirmEditName(dishNew){
            this.selectedDrink.name = dishNew.name

            axios.put(`/api/dishes/${this.selectedDrink.id}`, {
                name: dishNew.name
            })


            this.showModalEditName = false;


        },
        openInputPrice(){
            this.showModalEditPrice = true;
        },
        confirmEditPrice(dishNew){
            this.selectedDrink.price = dishNew.price

            axios.put(`/api/dishes/${this.selectedDrink.id}`, {
                price: dishNew.price
            })

            this.showModalEditPrice = false;
        },
        openInputDescription(){
            this.showModalEditDescription = true;
        },
        confirmEditDescription(dishNew){
            this.selectedDrink.description = dishNew.description

            axios.put(`/api/dishes/${this.selectedDrink.id}`, {
                description: dishNew.description
            })

            this.showModalEditDescription = false;
        },
        openInputImg(){
            this.showModalEditImg = true;
        },
        confirmEditImg(drinkNew){
            let newDrink = null;
            const formData = new FormData();
            const fileInput = document.querySelector('#editImg');

            console.log(fileInput.files[0])

            if (fileInput.files[0]) {
                formData.append('image', fileInput.files[0]);
            }

            formData.append('_method', 'PUT');

            axios.post(`/api/drinks/${this.selectedDrink.id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                let data = response.data;
                data = data.substring(data.indexOf('{'));
                newDrink = JSON.parse(data);

                this.selectedDrink.image = newDrink.image;
            })
            .catch(error => {
                console.error(error);
            });

            this.showModalEditImg = false;
        },
        updatePairings(dishId) {
            axios.get(`/api/dishes/${dishId}/drinks`)
                .then(response => {
                    this.pairings = response.data.pairingsEnoteca
                })
                .catch(error => {
                    console.error(error);
                });
        },
        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        updateIsShowStatus(id, value) {
          axios.put(`/api/drinks/${id}`, { is_active: value })
          .then(response => {
                this.selectedDrink.is_active = response.data.is_active
            })
          .catch(error => {
              console.log(error);
            });
        },
        openEditPairings(){
            this.showModalEditPairings = true;
        },
        toggleDrink(drink) {
            this.pairings = this.pairings.map(pairing => {
                if (pairing.id === this.selectedDrink.id) {
                    const drinkIndex = pairing.drinks.findIndex(d => d.id === drink.id);
                    if (drinkIndex !== -1) {
                        pairing.drinks.splice(drinkIndex, 1);
                    } else {
                        pairing.drinks.push(drink);
                    }
                }
                return pairing;
            });
        },
        confirmEditPairings(dishId){
            const drinkIds = this.pairings
                .filter(pairing => pairing.id === dishId.id)
                .map(pairing => pairing.drinks.map(drink => drink.id))
                .flat();

            axios.put(`/api/dishes/${dishId.id}/drinks`, { drink_id: drinkIds })                
                .then(response => {
                    this.updatePairings(dishId.id);
                })
                .catch(error => {
                    console.error(error);
                });

            this.showModalEditPairings = false;
        }
    },
    computed: {
        activeAllergens() {
          return this.allergens.filter(allergen => allergen.is_active);
        },
        selectedDishDrinks() {
            const drink = this.pairings.find(d => d.id === this.selectedDrink.id);
            if (!drink || !drink.drinks) {
                return [];
            }
        
            const drinkIds = drink.drinks.map(drink => drink.id);

            return drinkIds;
        }
    },
    mounted() {
        this.copySelectedDish = Object.assign({}, this.selectedDrink);
        this.updatePairings(this.copySelectedDish.id);
    },
    watch: {
        componentAllergen(newVal) {
            this.localComponentAllergen = newVal;
        },
    },
}

</script>

<style scoped>

.container-edit-img{
    width: 400px;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    .object-img{
        width: 100%;
        height: 100%;
    }
}

.bg-olive{
    background-color: #6b7238;
}

.container-drink-show{
    width: calc(100vw - 140px);
    height: calc(100vh - 110px);
    padding: 5px;
}

.grid-show-drink{
    display: grid;
    margin: 20px 0;
    height: 62vh;
    grid-template-areas: 
        "nome nome immagine immagine"
        "prezzo prezzo immagine immagine"
        "allergeni allergeni immagine immagine"
        "consigli consigli immagine immagine"
        "ingredienti ingredienti colore colore"
        "gradi gradi origine origine"
        "produzione produzione sapore sapore";
    grid-template-columns: 1fr 1fr 1fr 1fr;
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