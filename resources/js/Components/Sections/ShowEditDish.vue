<template>
    <button class="absolute top-5 right-5" @click="showModalItem()">❌</button>
    <div class="container-dish-show" >
        <h2 class="h-20 flex justify-between items-center font-bold text-2xl border border-3 border-black px-5">
            Scheda del {{ subjectModal.relation.table_category_name }}:
            <span class="text-4xl uppercase text-red-500">
                {{ subjectModal.selectedItem.name }}
            </span>  
            <SwitchButton :value="subjectModal.selectedItem.is_active === 1 || subjectModal.selectedItem.is_active === true" @switchChanged="value => updateIsShowStatus(subjectModal, value)"  />
        </h2>
        <div class="h-10 flex justify-between items-center border border-3 border-t-0 border-black px-5">
            <span class="font-bold text-xl">Categoria n°: {{ subjectModal.selectedItem.id }}</span>
        </div>
        <div class="grid-show-dish">
            <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: nome;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        nome:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ subjectModal.selectedItem.name }}
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
                    <!-- {{ console.log('PROVA', subjectModal.relation) }} -->
                    <ButtonCss @click="openInputImg()">
                            Modifica
                    </ButtonCss>
                </div>
                <img :src="subjectModal.selectedItem.image === 'null' ? 'img/defaultDish.jpg' : subjectModal.selectedItem.image" :alt="subjectModal.selectedItem.name + ' image'" class="h-image my-2 border border-3 border-black object-cover">
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
                            :id="`${subjectModal.selectedItem.id}-${allergen.id}`"
                            @click="matchAllergens(subjectModal.selectedItem.id, allergen.id)" 
                            :class="{ 'opacity-100': isAllergenMatched(allergen.id), 'opacity-20': !isAllergenMatched(allergen.id) }"
                        >
                            <img :src="allergen.icon" :alt="allergen.name + ' icon'" class="object-contain w-10 h-10 rounded-full border border-3 border-black">
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
                    {{ subjectModal.selectedItem.description === 'undefined' ? `Non ci sono consigli in questo ${ subjectModal.relation.table_category_name } al momento` : subjectModal.selectedItem.description }}
                </span>
            </div>
            <div class="h-fit p-2 border-2 border-black flex items-center justify-between" style="grid-area: prezzo;">
                <div class="flex gap-2">
                    <div class="font-black uppercase">
                        prezzo:
                    </div>
                    <span class="font-bold uppercase text-red-500">
                        {{ subjectModal.selectedItem.price }}
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
                    <ButtonCss @click="openEditPairings()">
                        Modifica
                    </ButtonCss>
                </div>
                <ul class="flex gap-2">
                    <template v-for="dish in pairings">
                        <template v-for="drink in dish.drinks">
                            <li class="px-4 py-1 border border-3 border-black rounded-full" v-if="dish.id === subjectModal.selectedItem.id && (drink.is_active === true || drink.is_active === 1)" >{{ drink.name }}</li>
                        </template>
                    </template>
                </ul>
            </div>
        </div>
        <div class="button_delete">
            <div @click="openDeleteModalDish( subjectModal )" class="p-2 rounded-2xl text-center text-white uppercase font-extrabold bg-red-600 cursor-pointer">
                Elimina {{ subjectModal.relation.table_category_name }}: {{ subjectModal.selectedItem.name }}
            </div>
        </div>
    </div>

    <!-- MODALS -->
     <div v-if="showModalDeleteDish" class="z-50">
         <ModalAction :showModal="showModalDeleteDish" :subjectModal.selectedItem="subjectModal.selectedItem">
             <h2 class="h-20 font-bold text-2xl text-center">
             Sei sicuro di voler eliminare il {{ subjectModal.relation.table_category_name }}: 
             {{ 
                 subjectModal.selectedItem.name
             }}?
             </h2>
             <div class="flex w-100 justify-between p-5">
             <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmDeleteDish( subjectModal )">Conferma</button>
             <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalDeleteDish = false">Annulla</button>
             </div>
         </ModalAction>
     </div>

     <div v-if="showModalEditName" class="z-50">
         <ModalAction :showModal="showModalEditName" :subjectModal.selectedItem="subjectModal.selectedItem">
                <h2 class="font-bold text-2xl text-center">
                Modifica il nome del {{ subjectModal.relation.table_category_name }}: 
                </h2>

                <div class="text-xl pb-4 first-letter:uppercase mb-8">
                    nome attuale: 
                    <span class="text-red-500 text-xl">
                        {{ subjectModal.selectedItem.name }}
                    </span>
                </div>

                <label for="name" class="font-bold text-xl">Nome:</label>
                <input type="text" class="w-full border-1 border-black rounded" v-model="copyselectedItem.name">


                <div class="flex w-full justify-between py-5">
                    <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEditName( subjectModal, copyselectedItem )">Conferma</button>
                    <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalEditName = false">Annulla</button>
                </div>
         </ModalAction>
     </div>

     <div v-if="showModalEditPrice" class="z-50">
         <ModalAction :showModal="showModalEditPrice" :subjectModal.selectedItem="subjectModal.selectedItem">
            <h2 class="font-bold text-2xl text-center pb-6">
                Modifica il prezzo del {{ subjectModal.relation.table_category_name }}: 
            </h2>

            <div class="text-xl pb-4 first-letter:uppercase mb-8">
                    prezzo attuale: 
                    <span class="text-red-500 text-xl">
                        {{ subjectModal.selectedItem.price }} €
                    </span>
                </div>

            <label for="name" class="font-bold text-xl">Nome:</label>
            <input type="number" class="w-full border-1 border-black rounded" v-model="copyselectedItem.price" step="0.01">


            <div class="flex w-full justify-between py-5">
                    <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEditPrice( subjectModal, copyselectedItem )">Conferma</button>
                    <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalEditPrice = false">Annulla</button>
                </div>
         </ModalAction>
     </div>

     <div v-if="showModalEditDescription" class="z-50">
        <ModalAction :showModal="showModalEditDescription" :subjectModal.selectedItem="subjectModal.selectedItem">
            <h2 class="font-bold text-2xl text-center pb-6">
                Modifica i consigli del {{ subjectModal.relation.table_category_name }}: 
            </h2>

            <div class="text-xl pb-4 first-letter:uppercase mb-8">
                    descrizione attuale: 
                    <span class="text-red-500 text-xl">
                        {{ subjectModal.selectedItem.description }}
                    </span>
            </div>

            <label for="name" class="font-bold text-xl">Consiglio:</label>
            <input type="text" class="w-full border-1 border-black rounded" v-model="copyselectedItem.description">


            <div class="flex w-full justify-between py-5">
                    <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEditDescription( subjectModal, copyselectedItem )">Conferma</button>
                    <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalEditDescription = false">Annulla</button>
            </div>
        </ModalAction>
     </div>

     <div v-if="showModalEditImg" class="z-50">
        <ModalAction :showModal="showModalEditImg" :subjectModal.selectedItem="subjectModal.selectedItem">
            <h2 class="font-bold text-2xl text-center pb-6">
                Modifica l'immagine del {{ subjectModal.relation.table_category_name }}: 
            </h2>

            <div class="text-xl pb-4 first-letter:uppercase mb-8">
                <span v-if="imagePreview === null">
                    Immagine attuale: 
                </span>
                <span v-else>
                    Anteprima Immagine:
                </span>
                <span class="container-edit-img">
                        <img :src="imagePreview != null ? imagePreview : 'img/defaultDish.jpg'" :alt="subjectModal.selectedItem.name + ' image'" class="object-img my-2 border border-3 border-black object-cover">                    
                    </span>
            </div>

            <label for="name" class="font-bold text-xl">Immagine:</label>
            <input id="editImg" type="file" @change="previewImage" class="w-full border-1 border-black rounded">

            <div class="flex w-full justify-between py-5">
                    <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEditImg( copyselectedItem )">Conferma</button>
                    <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="showModalEditImg = false">Annulla</button>
            </div>
        </ModalAction>
     </div>

     <div v-if="showModalEditPairings" class="z-50 container-editing-parings">
        <ModalAction :showModal="showModalEditPairings" :subjectModal.selectedItem="subjectModal.selectedItem">
                <h2 class="font-bold text-2xl text-center pb-6">
                    Modifica Gli abbinamenti del {{ subjectModal.relation.table_category_name }}: 
                </h2>

                <div class="text-xl pb-4 first-letter:uppercase mb-8">
                    <span>
                        Abbinamenti attuali: 
                    </span>
                    <ul class="flex gap-2">
                        <template v-for="dish in pairings">
                            <template v-for="drink in dish.drinks">
                                <li class="px-4 py-1 border border-3 border-black rounded-full" v-if="dish.id === subjectModal.selectedItem.id" >{{ drink.name }}</li>
                            </template>
                        </template>
                        
                    </ul>
                </div>

                <label for="name" class="font-bold text-xl">Abbinamenti:</label>
                <SelectMultiple ref="selectMultiple" :options="newPairings" :selected="selectedItemDrinks" @updateComponent="toggleDrink" defaultLabel="Abbinamenti" style="text-transform: uppercase" />
            <div class="flex w-full justify-between py-5">
                    <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmEditPairings( copyselectedItem )">Conferma</button>
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
        props: ['subjectModal', 'showModalItem', 'allergens','allergensDishes', 'pairingsEnoteca', 'drinks','newDrinko'],
        components: {
            ButtonCss,
            ModalAction,
            SwitchButton,
            SelectMultiple
        },
        emits: ['showModalItem', 'deleteDish', 'matchAllergens'],
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
                copyselectedItem: null,
                arrayAllergens: this.allergensDishes,
                pairings: [],
                localComponentAllergen: 0,
                selectedItemDrinks: [],
                newPairings: null,
            }
        },
        methods: {
            showModalItem(){
                console.log('CLICCATA X')
                this.$emit('showModalItem');
            },
            openDeleteModalDish(_subjectModal){
                console.log('OPEN MODAL DISH', _subjectModal)
                this.dishIdToDelete = _subjectModal.selectedItem.id;
                this.showModalDeleteDish = true;
            },
            confirmDeleteDish(_subjectModal){
                this.$emit('deleteDish', _subjectModal);
                this.showModalDeleteDish = false;
            },
            matchAllergens(dishId, allergenId){
                this.$emit('matchAllergens', dishId, allergenId);
            },
            isAllergenMatched(allergenId) {
                const allergenDish = this.allergensDishes.find(allergenDish => allergenDish.id === allergenId);
                if (!allergenDish) {
                    return false;
                    }

                return allergenDish.dishes.some(dish => dish.pivot.dish_id === this.subjectModal.selectedItem.id);
            },
            openInputName(){
                this.showModalEditName = true;
            },
            confirmEditName(_subjectModal, _copySelectedItem){

                axios.put(`/api/${_subjectModal.relation.table_category_name}/${_subjectModal.selectedItem.id}`, {
                    name: _copySelectedItem.name
                })
                .then(response => {
                    this.subjectModal.selectedItem.name = response.data.name
                })
                .catch(error => {
                    console.error(error);
                });


                this.showModalEditName = false;

                // :NOTE quello che abbiamo fatto (modificare la chiamata axios passando come argomento del confirm subjectModal 
                // che contiene sia la categoria e i suoi dati, sia la relation) con confirm edit name deve essere ripetuto 
                // con tutti i campi edit di showEditDish
            },
            openInputPrice(){
                this.showModalEditPrice = true;
            },
            confirmEditPrice(_subjectModal, _copySelectedItem){
                
                axios.put(`/api/${_subjectModal.relation.table_category_name}/${this.subjectModal.selectedItem.id}`, {
                    price: _copySelectedItem.price
                })
                .then(response => {
                    this.subjectModal.selectedItem.price = response.data.price
                })
                .catch(error => {
                    console.error(error);
                });

                // FIXME: a db il prezzo deve essere float/decimal e non int attualmente invia un intero (vale solo per mammaelvira questo ragionamento) 
                this.showModalEditPrice = false;
            },
            openInputDescription(){
                this.showModalEditDescription = true;
            },
            confirmEditDescription(_subjectModal, _copySelectedItem){

                axios.put(`/api/${_subjectModal.relation.table_category_name}/${this.subjectModal.selectedItem.id}`, {
                    description: _copySelectedItem.description
                })
                .then(response => {
                    this.subjectModal.selectedItem.description = response.data.description
                })
                .catch(error => {
                    console.error(error);
                });

                this.showModalEditDescription = false;
            },
            openInputImg(){
                this.showModalEditImg = true;
            },
            confirmEditImg(dishNew){
                let newDish = null;
                const formData = new FormData();
                const fileInput = document.querySelector('#editImg');

                console.log(fileInput.files[0])

                if (fileInput.files[0]) {
                    formData.append('image', fileInput.files[0]);
                }

                formData.append('_method', 'PUT');

                axios.post(`/api/dishes/${this.subjectModal.selectedItem.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    let data = response.data;
                    data = data.substring(data.indexOf('{'));
                    newDish = JSON.parse(data);

                    this.subjectModal.selectedItem.image = newDish.image;
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
            updateIsShowStatus(_subjectModal, value) {
            axios.put(`/api/${_subjectModal.relation.table_category_name}/${_subjectModal.selectedItem.id}`, { is_active: value })
            .then(response => {
                    this.subjectModal.selectedItem.is_active = response.data.is_active
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
                    if (pairing.id === this.subjectModal.selectedItem.id) {
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
            },
            updateDrinks(){
                axios.get('/api/drinks')
                    .then(response => {
                        this.newPairings = response.data
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
        },
        computed: {
            activeAllergens() {
            return this.allergens.filter(allergen => allergen.is_active);
            },
            selectedItemDrinks() {
                const dish = this.pairings.find(d => d.id === this.subjectModal.selectedItem.id);
                if (!dish || !dish.drinks) {
                    return [];
                }
            
                const drinkIds = dish.drinks.map(drink => drink.id);

                return drinkIds;
            }
        },
        mounted() {
            this.copyselectedItem = Object.assign({}, this.subjectModal.selectedItem);
            this.updatePairings(this.copyselectedItem.id);
            this.updateDrinks();
        },
        watch: {
            componentAllergen(newVal) {
                this.localComponentAllergen = newVal;
            },
        }
    }
    

</script>

<style scoped>

.container-editing-parings{
    max-height: 100%;
    overflow-y: scroll;
}

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