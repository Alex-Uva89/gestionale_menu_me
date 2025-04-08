<template>
    
    <div class="px-7 py-4 bg-gray-100">
        <h2 class="text-2xl title text-blue-600 font-bold">Aggiungi, Modifica o Elimina Ricette</h2>
    </div>

    <nav  class="ps-4 bg-gray-100">
        <ul>
            <li>
                <ButtonCss tooltipText="Aggiungi ricetta" @click="toggleModalAddRecipes()" hoverColor="#20324E">Aggiungi Ricetta</ButtonCss>
            </li>
        </ul>
    </nav>

    <section id="receips" class="container-recipes flex p-4 gap-2 flex-wrap" :key="keyComponent">
        <div v-if="receips.length === 0" >
            <h2 class="p-3">
                ⭐ Inizia <strong class="uppercase">aggiungendo</strong> una ricetta
            </h2>
        </div>
        <div v-else v-for="recipe in receips" class="card border-2 shadow-xl p-8 h-fit flex flex-col justify-between gap-4">
        
                <div>
                    <h2 class="text-xl font-bold uppercase text-wrap truncate">{{ recipe.name }}</h2>
                    <p class="container-process text-wrap text-ellipsis h-40 border-2 border-gray-400 p-2 my-2 overflow-auto" maxlength="1500">{{ recipe.process }}</p>
                    <div class="flex justify-between">
                        <p class="text-wrap text-ellipsis flex ">Collegata al piatto?
                            <span v-if="recipe.dish_id" class="text-green-600 ms-2">SI</span>
                            <span v-else class="text-red-600 ms-2">NO</span>
                        </p>
                         <div class="cursor-pointer" @click="toggleModalAddPairings( recipe.id )" >
                             <svg xmlns="https://www.w3.org/2000/svg" width="20" height="20" stroke="green" class="bi bi-plus-circle" viewBox="0 0 18 16">
                                     <path stroke-width="1" d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                     <path stroke-width="1" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                             </svg>
                         </div>  
                    </div>
                        
                    
                </div>

                <div >
                    <ButtonCss @click="toggleModalEditRecipe(recipe.id)" tooltipText="Modifica la ricetta">
                            <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                    </ButtonCss>
                    <ButtonCss tooltipText="Elimina ricetta" @click="toggleModalDeleteRecipe(recipe.id)" hoverColor="#F08080">
                            ❌
                    </ButtonCss>
                </div>

        </div>
        
    </section>

    <!-- MODALS -->

    <ModalAction  :showModal="showModalAddRecipes"> 
        <div class="modal-recipes-add relative pt-10 w-96">

            <ButtonCss class="absolute top-0 right-0" tooltipText="chiudi" hoverColor="#F08080" @click="toggleModalAddRecipes()">
                <div>
                    ❌
                </div>
            </ButtonCss>
            <h2 class="text-2xl text-center m-4 uppercase" >Aggiungi Ricetta</h2>
            <form @submit.prevent="submitForm" class="flex flex-col gap-4" id="formAdd">
                <div class="flex flex-col gap-2">
                    <label for="name">Nome Ricetta</label>
                    <input
                     id="name" 
                     v-model="form.name"
                     type="text" 
                     required
                     name="name" 
                     class="p-2 border border-gray-300 rounded-lg" 
                     placeholder="Nome Ricetta"
                     ref="nameInput">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="process">Procedimento</label>
                    <div class="flex flex-col">
                        <textarea 
                        id="process" 
                        required
                        v-model="form.process"
                        name="process" 
                        class="p-2 border border-gray-300 rounded-lg" 
                        placeholder="Procedimento"
                        ref="processInput"
                         ></textarea>
                        <span class="text-gray-600 self-end">{{ countLetters() }}</span>
                    </div>
                </div>
                
        
                <div class="flex justify-end">
                    <ButtonCss 
                    @click="validateForm()"
                    tooltipText="Conferma l'aggiunta della ricetta"
                    type="submit" 
                    hoverColor="#4FDE10">Aggiungi</ButtonCss>
                </div>
            </form>

        </div>
    </ModalAction>

    <ModalAction :showModal="showModalDeleteRecipes">
        <div class="modal-recipes relative pt-10">
            <h2 class="text-2xl text-center uppercase" >Elimina la ricetta <div class="h-20 font-bold text-2xl text-red-600 uppercase text-wrap truncate">"{{ receips.find(recipe => recipe.id === recipeId).name }}"</div></h2>
            <div class="flex flex-col gap-4">
                <p class="text-center">Sei sicuro di voler eliminare la ricetta?</p>
                <div class="flex justify-center gap-4">
                    <ButtonCss @click="deleteRecipe()" tooltipText="Conferma l'eliminazione della ricetta" hoverColor="#4FDE10" >Conferma</ButtonCss>
                    <ButtonCss @click="toggleModalDeleteRecipe()" tooltipText="Annulla l'eliminazione della ricetta"  hoverColor="#F08080">Annulla</ButtonCss>
                </div>
            </div>
        </div>
    </ModalAction>

    <ModalAction :showModal="showModalEditRecipe">
        <h2 class="text-2xl text-center uppercase" >Modifica la ricetta <div class="h-20 font-bold text-2xl text-red-600 uppercase text-wrap truncate">"{{ receips.find(recipe => recipe.id === recipeId).name }}"</div></h2>

        <form @submit.prevent="submitForm" class="flex flex-col gap-4" id="formEdit">
            <div class="modal-recipes flex flex-col gap-2">
                <label for="name">Nome Ricetta</label>
                <input
                 id="name" 
                 v-model="receips.find(recipe => recipe.id === recipeId).name"
                 type="text" 
                 required
                 name="name" 
                 class="p-2 border border-gray-300 rounded-lg" 
                 placeholder="Nome Ricetta"
                 ref="nameInput">
            </div>
            <div class="flex flex-col gap-2">
                <label for="process">Procedimento</label>
                <div class="flex flex-col">
                    <textarea 
                    id="process" 
                    required
                    name="process" 
                    class="p-2 border border-gray-300 rounded-lg" 
                    ref="processInput"
                    v-model="receips.find(recipe => recipe.id === recipeId).process"
                     >
                    </textarea>
                    <span class="text-gray-600 self-end">{{ countLetters() }}</span>
                </div>
            </div>
            <div class="flex justify-between">
                <ButtonCss @click="toggleModalEditRecipe()" tooltipText="Annulla la modifica della ricetta" hoverColor="#F08080">Annulla</ButtonCss>
                <ButtonCss 
                @click="validateForm()"
                tooltipText="Conferma la modifica della ricetta"
                type="submit" 
                hoverColor="#4FDE10">Modifica</ButtonCss>
            </div>
        </form>
    </ModalAction>

    <ModalAction :showModal="showAddPairings">
        <div class="modal-recipes relative py-5">
            <h2 class="text-2xl text-center uppercase" >Aggiungi Abbinamenti</h2>
            <div class="flex flex-col gap-4">
                <div class="py-10">
                    <p>Seleziona la ricetta</p>
                    <SelectMultiple :options="dishes" defaultLabel="Ricette" @changeOption="changeOption"  />                
                </div>
                <div v-show="showConfirmButton" id="allertRecipe">
                            <div class="allertRecipe flex justify-center items-center"  @click="removeClassHidden()">
                                ATTENZIONE!! è possibile abbinare un solo piatto ad ogni ricetta
                            </div>
                </div>
                <div class="flex justify-center gap-4">
                    <ButtonCss @click="addPairings(selectedOption)" :tooltipText="tooltipText" hoverColor="#4FDE10" >
                        Conferma
                    </ButtonCss>                    
                    <ButtonCss @click="toggleModalAddPairings()" tooltipText="Annulla l'aggiunta degli abbinamenti"  hoverColor="#F08080">Annulla</ButtonCss>
                </div>
            </div>
        </div>
    </ModalAction>

       


</template>

<script>

import ButtonCss from '@/Components/ButtonCss.vue';
import ModalAction from '@/Components/ModalAction.vue';
import SelectMultiple from '@/Components/SelectMultiple.vue';
import axios from 'axios';

    export default {
        props: {
            receips: {
                type: Array,
                required: true,
            },
            drinks: Array,
            dishes: Array,
        },
        components: {
            ButtonCss,
            ModalAction,
            SelectMultiple,
        },
        data() {
            return {
                keyComponent: 0,
                receips: this.receips,
                showModalAddRecipes: false,
                showModalDeleteRecipes: false,
                showModalEditRecipe: false,
                showAddPairings: false,
                showConfirmButton: false,
                tooltipText: "Conferma l'aggiunta degli abbinamenti",
                selectedOption: [],
                dishes: [],
                form: {
                    name: '',
                    process: '',
                },
            }
        },
        methods: {
            addIconScroll() {
                const container = document.querySelectorAll('.container-process');
                container.forEach((element) => {
                    // control if the element has a scrollbar
                    if (element.scrollHeight <= element.clientHeight) {
                        element.style.cursor = 'pointer';
                    } else {
                        element.addEventListener('scroll', () => {
                            if (element.scrollTop === 0) {
                                element.style.cursor = 'url("/img/cursor/down.svg"), auto';
                            } else if (element.scrollHeight - element.scrollTop === element.clientHeight) {
                                element.style.cursor = 'url("/img/cursor/up.svg"), auto';
                            }
                        });
                        element.style.cursor = 'url("/img/cursor/down.svg"), auto';
                    }
                });
            },
            toggleModalAddRecipes() {
                this.showModalAddRecipes = !this.showModalAddRecipes;
            },
            toggleModalDeleteRecipe(id) {
                this.recipeId = id;
                this.showModalDeleteRecipes = !this.showModalDeleteRecipes;
            },
            toggleModalEditRecipe(id) {
                this.recipeId = id;
                this.showModalEditRecipe = !this.showModalEditRecipe;
            },
            toggleModalAddPairings(id) {
                this.recipeId = id;
                this.showAddPairings = !this.showAddPairings;
            },
            validateForm() {
                let isValid = true;
                const formAddRecipe = document.getElementById('formAdd');
                const formEditRecipe = document.getElementById('formEdit');
            
                if (formAddRecipe) {
                    if (!this.form.name) {
                        isValid = false;
                        this.$refs.nameInput.setCustomValidity('Il campo non può essere vuoto');
                    } else {
                        this.$refs.nameInput.setCustomValidity('');
                    }
            
                    if (this.form.process.length > 1500 || this.form.process.length === 0) {
                        isValid = false;
                        this.$refs.processInput.setCustomValidity('Il testo deve essere massimo di 1500 caratteri');
                    } else {
                        this.$refs.processInput.setCustomValidity('');
                    }
            
                    if (isValid) {
                        this.addRecipes();
                    }
                } else if (formEditRecipe) {
                    if (this.form.process.length > 1500) {
                        isValid = false;
                        this.$refs.processInput.setCustomValidity('Il testo deve essere massimo di 1500 caratteri');
                    } else {
                        this.$refs.processInput.setCustomValidity('');
                    }
            
                    if (isValid) {
                        this.editRecipe();
                    }
                }
            },
            countLetters() {
                const process = this.form.process;
                const count = this.form.process.length;
                return `${count}/1500`;
            },
            addRecipes() {
                axios.post('/api/recipes', this.form)
                    .then((response) => {
                        this.receips.push(response.data);
                        this.keyComponent++;
                        this.form.name = '';
                        this.form.process = '';
                    })
                    .catch((error) => {
                        console.log(error);
                    });

                    this.showModalAddRecipes = false;
            },
            deleteRecipe() {
                axios.delete(`/api/recipes/${this.recipeId}`)
                    .then(() => {
                        const index = this.receips.findIndex(recipe => recipe.id === this.recipeId);
                        if (index !== -1) {
                            this.receips.splice(index, 1);
                            this.keyComponent++;
                        }

                        this.showModalDeleteRecipes = false;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

                    this.showModalDeleteRecipes = false;

            },
            editRecipe() {
                let formData = {};
                if (this.form.name){
                    formData.name = this.form.name;
                } else {
                    formData.name = this.receips.find(recipe => recipe.id === this.recipeId).name;
                }

                if (this.form.process) {
                    formData.process = this.form.process;
                } else {
                    formData.process = this.receips.find(recipe => recipe.id === this.recipeId).process;
                }
            
                axios.put(`/api/recipes/${this.recipeId}`, formData)
                    .then((response) => {
                        const index = this.receips.findIndex(recipe => recipe.id === this.recipeId);
                        if (index !== -1) {
                            this.receips[index] = { ...this.receips[index], ...response.data };
                            this.keyComponent++;
                            this.form.name = '';
                            this.form.process = '';
                        }
                        this.showModalEditRecipe = false;
                        this.keyComponent++;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            
                this.showModalEditRecipe = false;
            },
            addPairings(selectedDish) {
                console.log(selectedDish)
                if (selectedDish.length > 1) {
                    this.showConfirmButton = true;
                    return;
                } else {
                    axios.put(`/api/recipes/${this.recipeId}`, { dish_id: selectedDish[0]['id'] })
                        .then(() => {
                            this.keyComponent++;
                            this.showAddPairings = false;
                            const index = this.receips.findIndex(recipe => recipe.id === this.recipeId);
                            if (index !== -1) {
                                this.receips[index].dish_id = selectedDish[0]['id'];
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                    }
                    
                    this.selectedOption = [];
            },
            changeOption(option) {

                const existingOptionIndex = this.selectedOption.findIndex(o => o.id === option.id);
                if (existingOptionIndex > -1) {
                    this.selectedOption.splice(existingOptionIndex, 1);
                    if (this.selectedOption.length < 2){
                        this.showConfirmButton = false;
                    }
                } else {
                    this.selectedOption.push(option);
                }
            },
            removeClassHidden(){
                const allertMessage = document.getElementById('allertRecipe');
                allertMessage.classList.add('none');
            },
            async fetchDishes() {
                const response = await axios.get('/api/dishes');
                this.dishes = response.data['dishes'];
            },
        },
        mounted() {
            this.addIconScroll();
            this.countLetters();
        },
        updated() {
            this.addIconScroll();
        },
        watch: {
            showAddPairings(newVal) {
                if (newVal) {
                    this.fetchDishes();
                }
            },
        }
    }

</script>

<style scoped>
    .container-recipes {
        height: calc(100vh - 220px);
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #1100ff #f5f5f5;
        .container-process {
            scrollbar-width: thin;
            scrollbar-color: #1100ff #f5f5f5;
        }
        .card {
            width: 300px;
        }
    }

    .allertRecipe {
        height: 50px;
       
        color: red;
        border: 1px solid red;
        padding: 10px;
        background-color: #f5f5f5;
        bottom: 40px;
        left: -100px;
        font-size: .7rem;
        font-weight: bold;
    }

    .modal-recipes{
        width: 400px;
    }
</style>