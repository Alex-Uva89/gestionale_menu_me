

<template>
    
    <div :key="componenetAllergen">
        <h2 class="text-2xl title text-blue-600 font-bold">Aggiungi, Modifica o Elimina un Allergene</h2>

        <nav>
            <ul class="table-allergens flex pb-5">
                <li @click="openModalAddAllergen()">
                    <ButtonCss tooltipText="Usa questo tasto per aggiungere un allergene" hoverColor="#20324E">
                        <div >
                            Aggiungi Allergene
                        </div>
                    </ButtonCss>
                </li>

                <li>
                    <ButtonCss @click="UnderCostruction()" tooltipText="Usa questo tasto per aggiungere un allergene" hoverColor="#444F1F">
                        <div>
                            Mostra Lista
                        </div>
                    </ButtonCss>
                </li>
            </ul>
        </nav>

        <section>
            <div class="border-2 border-black mx-6 rounded-2xl" v-if="allergens.length === 0">
                <h2 class="p-3 flex justify-center items-center">
                    ⭐ Inizia <strong class="uppercase mx-1">aggiungendo</strong> un allergene
                </h2>
            </div>
    
            <table class="table-auto table-allergens" v-if="allergens.length > 0">
                <thead class="bg-gray-200 text-gray-600 border border-gray-300">
                    <tr class="grid grid-cols-6">
                        <th class="border-2 border-black p-4">Icona</th>
                        <th class="border-2 border-black col-span-3  p-4">Nome</th>
                        <th class="border-2 border-black col-span-2 p-4">Azioni</th>
                    </tr>
                </thead>
                <div class="list-allergen"  id="allergenList">
                    <tbody>
                        <tr v-for="allergen in allergens" class="grid grid-cols-6">
                            <td class="flex items-center border border-4 p-5">
                                <div class="w-full  flex justify-center">
                                    <img v-if="allergen.icon" :src="'/storage/' + allergen.icon" :alt="'icona '+ allergen.name + ' non trovata' "  >
                                </div>
                            </td>
                            <td class="flex items-center gap-4 border border-4 border-s-0 p-4 col-span-3">
                                    {{ allergen.name }}
                            </td>
                            <td class="flex justify-center items-center border border-4 border-s-0 p-4 col-span-2">
                                <div class="flex gap-1">
                                    <ButtonCss tooltipText="Modifica l'icona" @click="editAllergen(allergen.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </ButtonCss>
        
                                    <ButtonCss tooltipText="Elimina allergene" hoverColor="#F08080" @click="deleteAllergen(allergen.id)">
                                        ❌
                                    </ButtonCss>
        
                                    <SwitchButton 
                                    :value="allergen.is_active === 1" 
                                    @switchChanged="value => updateIsShowStatus(allergen.id, value)" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </div>
            </table>
        </section>
    </div>


    <!-- MODALS -->
    <section class="section-create-allergen"  v-if="isOpenModalAllergen">
        <div class="modal-confirm relative">
            <ButtonCss tooltipText="chiudi" hoverColor="#F08080" class="w-full absolute right-2 top-4" @click="openModalAddAllergen()">
                        <div>
                            ❌
                        </div>
            </ButtonCss>
            <h2 class="h-20 font-bold text-2xl text-center">
                 Aggiungi allergene
            </h2>
            <form @submit.prevent="submitForm" class="w-full flex flex-col justify-between items-center gap-4 p-5">
                <div class="grid grid-cols-4 w-full">
                    <label for="name" class="leading-9">Nome</label>
                    <input id="name" 
                    v-model="form.name" 
                    type="text" 
                    required 
                    class="col-span-3"
                    oninvalid="this.setCustomValidity('Per favore, riempi questo campo')"
                    oninput="this.setCustomValidity('')">
                </div>
                <div class="grid grid-cols-4 w-full">
                    <label for="icon" class="leading-9">Icona</label>
                    <label class="custom-file-upload  col-span-3">
                        <input 
                        id="icon" 
                        @change="handleFileUpload" 
                        type="file" 
                        accept=".png, .svg" 
                        required 
                        class="hidden"
                        oninvalid="this.setCustomValidity('Per favore, riempi questo campo')"
                        oninput="this.setCustomValidity('')">
                        {{ form.icon ? form.icon.name : 'Seleziona un file dal tuo pc' }}
                    </label>
                </div>
                <ButtonCss type="submit" 
                           tooltipText="Conferma l'aggiunta dell'allergene" 
                           hoverColor="#4FDE10" 
                           @click="createAllergen(form.name)" 
                           v-bind:disabled="!isFormFilled">
                    <div class="w-96">
                        Conferma
                    </div>
                </ButtonCss>
            </form>
        </div>
    </section>

    <section class="section-delete-allergen" v-if="isOpenModalDelete">
        <div class="modal-confirm">
            <h2 class="h-20 font-bold text-2xl text-center">
                Sei sicuro di voler eliminare l'allergene <span class="h-20 font-bold text-2xl text-red-600 uppercase">"{{ allergens.find(allergen => allergen.id === allergenId).name }}"</span>?
                <p class="text-base">la cancellazione dell'allergene verrà effettuata anche per i piatti dove è presente</p>
            </h2>
            <div class="flex w-100 justify-between p-5">
                <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32" @click="confirmDelete()">Conferma</button>
                <button class="bg-white border-black border-2 rounded text-black p-3 w-32" @click="isOpenModalDelete = false">Annulla</button>
            </div>
        </div>
    </section>

    <section class="section-edit-allergen" v-if="isOpenModalEdit">
        <div class="modal-confirm relative">
            <ButtonCss tooltipText="chiudi" hoverColor="#F08080" class="w-full absolute right-2 top-4" @click="isOpenModalEdit = false">
                        <div>
                            ❌
                        </div>
            </ButtonCss>
            <h2 class="h-20 font-bold text-2xl text-center">
                Modifica allergene <span class="h-20 font-extrabold text-2xl uppercase text-red-600">{{ allergens.find(allergen => allergen.id === allergenId).name }}</span>
            </h2>
            <form @submit.prevent="submitForm" class="w-full flex flex-col justify-between items-center gap-4 p-5">
                <div class="grid grid-cols-4 w-full">
                    <label for="name" class="leading-9">Nome</label>
                    <input id="name" v-model="form.name" type="text" required class="col-span-3">
                </div>
                <div class="grid grid-cols-4 w-full">
                    <label for="icon" class="leading-9">Icona</label>
                    <label class="custom-file-upload  col-span-3">
                        <input 
                        id="icon" 
                        @change="handleFileUpload" 
                        type="file" 
                        accept=".png, .svg" 
                        required 
                        class="hidden">
                        {{ form.icon ? form.icon.name : 'Seleziona un file dal tuo pc' }}
                    </label>
                </div>
                <ButtonCss type="submit" tooltipText="Conferma l'aggiunta dell'allergene" hoverColor="#4FDE10" @click="confirmEditAllergen(form.name, form.icon)">
                    <div class="w-96">
                        Conferma
                    </div>
                </ButtonCss>
            </form>
        </div>
    </section>

    <ModalAction @click="UnderCostruction()" :showModal="showModalUnderCostruction"> 
        <div class="modal">
            <h2 class="text-2xl text-center m-4">Lista Allergeni</h2>
            <p class="text-center">Questa funzionalità sarà disponibile a breve</p>
        </div>
    </ModalAction>

    <!-- BUTTON SCROLL -->

    <div class="fixed bottom-5 right-5 p-4 "  v-show="isScrollable">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#1D4ED8" class="bi bi-arrow-down-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293z"/>
        </svg>
    </div>
 

</template>

<script>

import ButtonCss from '@/Components/ButtonCss.vue';
import SwitchButton from '@/Components/Switch_button.vue';
import ModalAction from '@/Components/ModalAction.vue';
import axios from 'axios';

var consoleStyling = 'background: green; color: yellow; font-weight: bold;';

export default {
    components: {
        ButtonCss,
        SwitchButton,
        ModalAction
    },
    props: {
        allergens: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            localAllergens: [...this.allergens],
            isOpenModalAllergen: false,
            isOpenModalDelete: false,
            isOpenModalEdit: false,
            form: {
                name: '',
                icon: null
            },
            componenetAllergen: 0,
            isScrollable: false,
            allergenId: null,
            showModalUnderCostruction: false
        }
    },
    methods: {
        UnderCostruction() {
            this.showModalUnderCostruction = !this.showModalUnderCostruction;
        },
        openModalAddAllergen() {
            this.isOpenModalAllergen = !this.isOpenModalAllergen;
        },
        handleFileUpload(e) {
            this.form.icon = e.target.files[0];
        },
        createAllergen(name) {
            const formData = new FormData();
            formData.append('name', name);
            formData.append('icon', this.form.icon);

            console.log('FORM DATA');
            console.log(formData);

            console.log('ICON');
            console.log(this.form.icon);
        
            axios.post('/api/allergens', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                const data = response.data.split('\n').pop();
                const newAllergen = JSON.parse(data);
        
                const checkFile = () => {
                    axios.get('/storage/' + newAllergen.icon)
                    .then(response => {
                        this.allergens.push(newAllergen);
                        this.componenetAllergen++;
                    })
                    .catch(error => {
                        setTimeout(checkFile, 1000);
                    });
                };
        
                
                checkFile();
            })
            .catch(error => {
                console.log('ERROR');
                console.log(error);
             });
        
            this.isOpenModalAllergen = false;
        },
        isListScrollable() {
            const list = document.getElementById('allergenList');
            const button = document.querySelector('.bi-arrow-down-circle');
            if (list) {
                if (list.scrollHeight > list.clientHeight) {
                    this.isScrollable = true;
                    
                } 
                // voglio controllare se lo scroll è arrivato alla fine per poter rotare il bottone 
                list.addEventListener('scroll', () => {
                    if (list.scrollTop + list.clientHeight >= list.scrollHeight) {
                        button.style.transform = 'rotate(180deg)';
                        button.style.transition = 'transform 0.5s';
                    } else {
                        button.style.transform = 'rotate(0deg)';
                    }
                });
            }

            setTimeout(this.isListScrollable, 1000);
        },
        deleteAllergen(id) {
            this.allergenId = id;
            this.isOpenModalDelete = true;
        },
        confirmDelete() {
            axios.delete('/api/allergens/' + this.allergenId)
            .then(response => {
                const index = this.allergens.findIndex(allergen => allergen.id === this.allergenId);
                if (index !== -1) {
                    this.allergens.splice(index, 1);
                }
            })
            .catch(error => {
                console.log('ERROR');
                console.log(error);
            });

            this.isOpenModalDelete = false;
        },
        editAllergen(id) {
            this.allergenId = id;
            this.isOpenModalEdit = true;
        },
        confirmEditAllergen(value, valueIcon) {
            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name', value);
            formData.append('icon', valueIcon);

            axios.post(`/api/allergens/${this.allergenId}`, formData)
            .then(response => {
                const data = response.data.split('\n').pop();
                const editedAllergen = JSON.parse(data);

                const index = this.allergens.findIndex(allergen => allergen.id === this.allergenId)
                if (index !== -1) {
                    const checkFile = () => {
                        axios.get('/storage/' + editedAllergen.icon)
                        .then(response => {
                            this.allergens[index] = editedAllergen; 
                            this.componenetAllergen++;
                        })
                        .catch(error => {
                            setTimeout(checkFile, 1000);
                        });
                    };

                    checkFile();
                } 
            })
            .catch(error => {
                console.log(error);
            });

            this.isOpenModalEdit = false;
        },
        updateIsShowStatus(valueAllergenId, value) {
          axios.put(`/api/allergens/${valueAllergenId}`, { is_active: value })
          .then(response => {
              this.allergen = response.data;
            })
          .catch(error => {
              console.log(error);
            });
        },
    },
    watch: {
        allergens() {
            this.localAllergens = [...this.allergens];
        }
    },
    computed: {
        isFormFilled() {
            return this.form.name && this.form.icon;
        },
        
    },
    mounted() {
        this.isListScrollable();
    }
};


</script>


<style scoped>
.title{
    width: 95%;
    margin: 30px auto;
    cursor: none;
}
.table-allergens{
    width: 80%;
    margin: 0 auto;
}
.list-allergen{
    min-height: 0;
    max-height: 400px;
    overflow-y: scroll;
    scrollbar-width: none;
}

.section-create-allergen, .section-delete-allergen, .section-edit-allergen{
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

.custom-file-upload {
    padding: 10px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    cursor: pointer;
}

</style>
