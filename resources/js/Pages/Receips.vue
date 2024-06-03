<template>
    
    <div class="mx-7 my-4">
        <h2 class="text-2xl title text-blue-600 font-bold">Aggiungi, Modifica o Elimina Ricette</h2>
    </div>

    <nav  class="ms-4">
        <ul>
            <li>
                <ButtonCss tooltipText="Aggiungi Allergene" @click="toggleModalAddRecipes()" hoverColor="#20324E">Aggiungi Ricetta</ButtonCss>
            </li>
        </ul>
    </nav>

    <section id="receips" class=" container-recipes flex flex-wrap m-4">
        <div v-for="recipe in receips" class="w-full md:w-1/2 lg:w-1/3 p-2">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center justify-center w-60 h-32 border rounded-2xl p-2">
                        <img class="object-cover h-full" src="/img/defaultDish.jpg" alt="immagine ricetta">
                    </div>
                    <div class="flex gap-2 self-start">
                        <ButtonCss tooltipText="Modifica l'icona">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </ButtonCss>
                        <ButtonCss tooltipText="Elimina allergene" hoverColor="#F08080">
                            ❌
                        </ButtonCss>
                    </div>
                </div>
                <div class="mt-4 ">
                    <h2 class="text-xl font-semibold text-gray-800">{{ recipe.name }}</h2>
                    <p class="mt-2 text-gray-600 container-process" >{{ recipe.process }}</p>
                </div>
            </div>
        </div>

        
    </section>

    <!-- MODALS -->

    <ModalAction  :showModal="showModalAddRecipes"> 
        <div class="modal-recipes-add relative pt-10">

            <ButtonCss class="absolute top-0 right-0" tooltipText="chiudi" hoverColor="#F08080" @click="toggleModalAddRecipes()">
                <div>
                    ❌
                </div>
            </ButtonCss>
            <h2 class="text-2xl text-center m-4 uppercase" >Aggiungi Ricetta</h2>
            <form class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name">Nome Ricetta</label>
                    <input type="text" id="name" name="name" class="p-2 border border-gray-300 rounded-lg" placeholder="Nome Ricetta">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="process">Procedimento</label>
                    <textarea id="process" name="process" class="p-2 border border-gray-300 rounded-lg" placeholder="Procedimento"></textarea>
                </div>
                <div class="flex justify-end">
                    <ButtonCss type="submit" hoverColor="#20324E">Aggiungi</ButtonCss>
                </div>
            </form>

        </div>
    </ModalAction>
       


</template>

<script>

import ButtonCss from '@/Components/ButtonCss.vue';
import ModalAction from '@/Components/ModalAction.vue';

    export default {
        props: {
            receips: {
                type: Array,
                required: true,
            },
        },
        components: {
            ButtonCss,
            ModalAction,
        },
        data() {
            return {
                receips: this.receips,
                showModalAddRecipes: false,
            }
        },
        methods: {
            addIconScroll() {
                const container = document.querySelectorAll('.container-process');
                container.forEach((element) => {
                    element.addEventListener('scroll', () => {
                        if (element.scrollTop === 0) {
                            element.style.cursor = 'url("/img/cursor/down.svg"), auto';
                        } else if (element.scrollHeight - element.scrollTop === element.clientHeight) {
                            element.style.cursor = 'url("/img/cursor/up.svg"), auto';
                        } else {
                        }
                    });
                    element.style.cursor = 'url("/img/cursor/down.svg"), auto';
                });
            },
            toggleModalAddRecipes() {
                this.showModalAddRecipes = !this.showModalAddRecipes;
            },
        },
        mounted() {
            this.addIconScroll();
        },
    }

</script>

<style scoped>
    .container-recipes {
        max-height: 70%;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #1100ff #f5f5f5;
        .container-process {
            height: 200px;
            max-height: 200px;
            overflow-y: auto;
            scrollbar-width: none;
        }

    }

    .modal-recipes-add{
        width: 400px;
    }
</style>