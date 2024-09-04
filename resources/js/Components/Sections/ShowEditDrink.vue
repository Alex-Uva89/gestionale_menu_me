<template>
    <button class="absolute top-5 right-5" @click="showModalDrink()">❌</button>
    <div class="container-drink-show" :key="localComponentAllergen">
            <h2 class="h-20 flex justify-between items-center font-bold text-2xl border border-3 border-black px-5">
                Scheda del drink:
                <span class="text-4xl uppercase text-red-500">
                    {{ selectedDrink.name }}
                </span>
                <SwitchButton :value="selectedDrink.is_active === 1 || selectedDrink.is_active === true"
                    @switchChanged="value => updateIsShowStatus(selectedDrink.id, value)" />
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
                    <img :src="selectedDrink.image === 'null' || selectedDrink.image === 'undefined' ? 'img/defaultDish.jpg' : selectedDrink.image"
                        :alt="selectedDrink.name + ' image'" class="h-image my-2 border border-3 border-black object-cover">
                </div>
                <div class="h-fit flex items-center p-2 border-2 border-black" style="grid-area: allergeni;">
                    <span class="font-black me-2 uppercase">
                        Allergeni:
                    </span>

                    <ul class="flex gap-2" v-if="activeAllergens.length">

                        <li v-for="allergen in activeAllergens" :key="allergen.id" class="rounded-full cursor-pointer"
                            :id="`${selectedDrink.id}-${allergen.id}`" @click="matchDish(selectedDrink.id, allergen.id)"
                            :class="{ 'opacity-100': isAllergenMatched(allergen.id), 'opacity-20': !isAllergenMatched(allergen.id) }">
                            <img :src="allergen.icon" :alt="allergen.name + ' icon'"
                                class="object-contain w-10 h-10 rounded-full border border-3 border-black">
                        </li>
                    </ul>
                    <div class="w-full ps-2 font-black uppercase text-red-600 underline decoration-4 underline-offset-4 text-center"
                        v-else>
                        Non sono presenti allergeni attivi
                    </div>


                </div>
                <!-- <div class="h-fit p-2 border-2 border-black" style="grid-area: consigli;">
                    <div class="w-full flex justify-between items-center font-black uppercase">
                        Consigli:
                        <ButtonCss @click="openInputInstruction()">
                            Modifica
                        </ButtonCss>
                    </div>
                    <span class="uppercase font-semibold text-red-500">
                        {{ selectedDrink.instructions === 'undefined' ? 'Non ci sono consigli in questo drink al momento' :
                        selectedDrink.instructions }}
                    </span>
                </div> -->
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
                    <ButtonCss @click="openInputGrades()">
                        Modifica
                    </ButtonCss>
                </div>
                <div class="h-fit px-1  py-2 border-2 border-black flex items-center justify-between" style="grid-area: colore;">
                    <div class="flex gap-2">
                        <div class="font-black uppercase">
                            colore:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.color }}
                        </span>
                    </div>
                    <div>
                        <ButtonCss @click="openTraductionColor()">
                            Traduci
                        </ButtonCss>
                        <ButtonCss @click="openInputColor()">
                            Modifica
                        </ButtonCss>
                    </div>
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
                    <div>
                        <ButtonCss @click="openTraductionProd()">
                            Traduci
                        </ButtonCss>
                        <ButtonCss @click="openInputProd()">
                            Modifica
                        </ButtonCss>
                    </div>
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
                    <div>
                        <ButtonCss @click="openTraductionFlavour()">
                            Traduci
                        </ButtonCss>
                        <ButtonCss @click="openInputFlavour()">
                            Modifica
                        </ButtonCss>
                    </div>
                </div>
                <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: olfatto;">
                    <div class="flex gap-2">
                        <div class="font-black uppercase">
                            olfatto:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.nose }}
                        </span>
                    </div>
                    <div>
                        <ButtonCss @click="openTraductionNose()">
                            Traduci
                        </ButtonCss>
                        <ButtonCss @click="openInputNose()">
                            Modifica
                        </ButtonCss>
                    </div>
                </div>
                <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: temperatura;">
                    <div class="flex gap-2">
                        <div class="font-black uppercase">
                            Temperatura di servizio:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.serving_temperature }}
                        </span>
                    </div>
                        <ButtonCss @click="openInputTemperature()">
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
                    <ButtonCss @click="openInputDescription()">
                        Modifica
                    </ButtonCss>
                </div>
                <div class="h-fit px-1 py-2 border-2 border-black flex items-center justify-between" style="grid-area: origine;">
                    <div class="flex gap-2">
                        <div class="font-black uppercase">
                            origine:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.origin }}
                        </span>
                    </div>
                    <div>
                        <ButtonCss @click="openTraductionOrigin()">
                            Traduci
                        </ButtonCss>

                        <ButtonCss @click="openInputOrigin()">
                            Modifica
                        </ButtonCss>
                    </div>
                </div>
                <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: vitigno;">
                    <div class="flex gap-2">
                        <div class="font-black uppercase">
                            vitigno:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.grape_variety }}
                        </span>
                    </div>
                    <ButtonCss @click="openInputGrape()">
                        Modifica
                    </ButtonCss>
                </div>
                <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: produttore;">
                    <div class="flex gap-2">
                        <div class="font-black uppercase">
                            produttore:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.producer }}
                        </span>
                    </div>
                    <ButtonCss @click="openInputProducer()">
                        Modifica
                    </ButtonCss>
                </div>
                <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: denominazione;">
                    <div class="flex gap-2">
                        <div class="font-black uppercase">
                            denominazione:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.denomination }}
                        </span>
                    </div>
                    <ButtonCss @click="openInputDenomination()">
                        Modifica
                    </ButtonCss>
                </div>
                <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: annata;">
                    <div class="flex gap-2">
                        <div class="font-black uppercase">
                            annata:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.vintage }}
                        </span>
                    </div>
                    <ButtonCss @click="openInputVintage()">
                        Modifica
                    </ButtonCss>
                </div>
                <div class="h-fit px-1 py-2 border-2 border-black flex items-center justify-between" style="grid-area: allevamento;">
                    <div class="flex gap-2 flex-nowrap">
                        <div class="font-black uppercase">
                            metodo di allevamento:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.breeding_method }}
                        </span>
                    </div>
                    <div class="flex">
                        <ButtonCss @click="openTraductionBreeding()">
                            Traduci
                        </ButtonCss>
                        <ButtonCss @click="openInputBreeding()">
                            Modifica
                        </ButtonCss>
                    </div>
                </div>
                <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: formato;">
                    <div class="flex gap-2">
                        <div class="font-black uppercase">
                            formato:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.format }}
                        </span>
                    </div>
                    <ButtonCss @click="openInputFormat()">
                        Modifica
                    </ButtonCss>
                </div>
                <div class="h-fit  p-2 border-2 border-black flex items-center justify-between" style="grid-area: certificazioni;">
                    <div class="flex gap-2">
                        <div class="font-black uppercase">
                            certificazioni:
                        </div>
                        <span class="font-bold uppercase text-red-500">
                            {{ selectedDrink.certifications }}
                        </span>
                    </div>
                    <ButtonCss @click="openInputCertification()">
                        Modifica
                    </ButtonCss>
                </div>
            </div>
            <div class="button_delete">
                <div @click="openDeleteModalDish(selectedDrink.id)"
                    class="p-2 rounded-2xl text-center text-white uppercase font-extrabold bg-red-600 cursor-pointer">
                    Elimina drink: {{ selectedDrink.name }}
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
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmDeleteDish(selectedDrink.id)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalDeleteDish = false">Annulla</button>
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
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditName(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditName = false">Annulla</button>
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
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditPrice(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditPrice = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <!-- <div v-if="showModalEditInstruction" class="z-50">
                <ModalAction :showModal="showModalEditInstruction" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica i consigli del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        descrizione attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.instructions }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Consiglio:</label>
                    <input type="text" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.instructions">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditInstruction(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditInstruction = false">Annulla</button>
                    </div>
                </ModalAction>
            </div> -->

            <div v-if="showModalEditDescription" class="z-50">
                <ModalAction :showModal="showModalEditDescription" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica gli ingredienti del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        ingredienti attuali:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.description }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Ingredienti:</label>
                    <input type="text" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.description">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditDescription(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditDescription = false">Annulla</button>
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
                            <img :src="imagePreview != null ? imagePreview : 'img/defaultDish.jpg'"
                                :alt="selectedDrink.name + ' image'"
                                class="object-img my-2 border border-3 border-black object-cover">
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Immagine:</label>
                    <input id="editImg" type="file" @change="previewImage" class="w-full border-1 border-black rounded">

                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditImg(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditImg = false">Annulla</button>
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
                                    <li class="px-4 py-1 border border-3 border-black rounded-full" v-if="drink.id === selectedDrink.id">
                                        {{ drink.name }}
                                    </li>
                                </template>
                            </template>

                        </ul>
                    </div>

                    <label for="name" class="font-bold text-xl">Abbinamenti:</label>
                    <SelectMultiple ref="selectMultiple" :options="drinks" :selected="selectedDishDrinks"
                        @updateComponent="toggleDrink" defaultLabel="Abbinamenti" style="text-transform: uppercase" />
                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditPairings(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditPairings = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditGrades" class="z-50">
                <ModalAction :showModal="showModalEditGrades" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica i gradi del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        gradi attuali:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.degrees }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Gradi:</label>
                    <input type="number" class="w-full border-1 border-black rounded" v-model="copySelectedDish.degrees">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditDegrees(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditGrades = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditColor" class="z-50">
                <ModalAction :showModal="showModalEditColor" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica il colore del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        colore attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.color }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Colore:</label>
                    <input type="text" class="w-full border-1 border-black rounded" v-model="copySelectedDish.color">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditColor(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditColor = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalTraductionColor" class="z-50">
                <ModalAction :showModal="showModalTraductionColor" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Inserisci la traduzione del colore:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Italiano:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.color }}
                        </span>
                    </div>

                    <label for="color_en" class="font-bold text-xl">Inglese:</label>
                    <input type="text" id="color_en" class="w-full border-1 border-black rounded" v-model="copySelectedDish.color_en">

                    <label for="color_fr" class="font-bold text-xl">Francese:</label>
                    <input type="text" id="color_fr" class="w-full border-1 border-black rounded" v-model="copySelectedDish.color_fr">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmTraductionColor(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalTraductionColor = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditProd" class="z-50">
                <ModalAction :showModal="showModalEditProd" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica il metodo di produzione del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        metodo di produzione attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.production_method }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Metodo di produzione:</label>
                    <input type="text" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.production_method">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditProd(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditProd = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalTraductiontProd" class="z-50">
                <ModalAction :showModal="showModalTraductiontProd" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Traduci il metodo di produzione del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Italiano:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.production_method }}
                        </span>
                    </div>

                    <label for="production_method_en" class="font-bold text-xl">Inglese:</label>
                    <input type="text" id="production_method_en" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.production_method_en">

                    <label for="production_method_fr" class="font-bold text-xl">Francese:</label>
                    <input type="text" id="production_method_fr" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.production_method_fr">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmTraductionProd(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalTraductiontProd = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditFlavour" class="z-50">
                <ModalAction :showModal="showModalEditFlavour" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica il gusto del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        gusto attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.flavour }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Gusto:</label>
                    <input type="text" class="w-full border-1 border-black rounded" v-model="copySelectedDish.flavour">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditFlavour(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditFlavour = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalTraductionFlavour" class="z-50">
                <ModalAction :showModal="showModalTraductionFlavour" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Traduci il gusto del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Italiano:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.flavour }}
                        </span>
                    </div>

                    <label for="flavour_en" class="font-bold text-xl">Inglese:</label>
                    <input type="text" id="flavour_en" class="w-full border-1 border-black rounded" v-model="copySelectedDish.flavour_en">

                    <label for="flavour_fr" class="font-bold text-xl">Francese:</label>
                    <input type="text" id="flavour_fr" class="w-full border-1 border-black rounded" v-model="copySelectedDish.flavour_fr">

                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmTraductionFlavour(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalTraductionFlavour = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditOrigin" class="z-50">
                <ModalAction :showModal="showModalEditOrigin" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica l'origine del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        origine attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.origin }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Origine:</label>
                    <input type="text" class="w-full border-1 border-black rounded" v-model="copySelectedDish.origin">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditOrigin(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditOrigin = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalTraductionOrigin" class="z-50">
                <ModalAction :showModal="showModalTraductionOrigin" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Traduci l'origine del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Italiano:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.origin }}
                        </span>
                    </div>

                    <label for="origin_en" class="font-bold text-xl">Inglese:</label>
                    <input type="text" id="origin_en" class="w-full border-1 border-black rounded" v-model="copySelectedDish.origin_en">

                    <label for="origin_fr" class="font-bold text-xl">Francese:</label>
                    <input type="text" id="origin_fr" class="w-full border-1 border-black rounded" v-model="copySelectedDish.origin_fr">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmTraductionOrigin(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalTraductionOrigin = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditGrape" class="z-50">
                <ModalAction :showModal="showModalEditGrape" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica il vitigno del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Vitigno attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.grape_variety }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Vitigno:</label>
                    <input type="text" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.grape_variety">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditGrape(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditGrape = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditProducer" class="z-50">
                <ModalAction :showModal="showModalEditProducer" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica il produttore del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Produttore attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.producer }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Produttore:</label>
                    <input type="text" class="w-full border-1 border-black rounded" v-model="copySelectedDish.producer">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditProducer(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditProducer = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditDenomination" class="z-50">
                <ModalAction :showModal="showModalEditDenomination" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica la denominazione del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        denominazione attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.denomination }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Denominazione:</label>
                    <input type="text" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.denomination">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditDenomination(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditDenomination = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditVintage" class="z-50">
                <ModalAction :showModal="showModalEditVintage" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica l'annata del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Annata attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.vintage }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Annata:</label>
                    <input type="text" class="w-full border-1 border-black rounded" v-model="copySelectedDish.vintage">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditVintage(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditVintage = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditBreeding" class="z-50">
                <ModalAction :showModal="showModalEditBreeding" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica il metodo di allevamento del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        metodo di allevamento attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.breeding_method }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Metodo di allevamento:</label>
                    <input type="text" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.breeding_method">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditBreeding(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditBreeding = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalTraductionBreeding" class="z-50">
                <ModalAction :showModal="showModalTraductionBreeding" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Traduci il metodo di allevamento del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Italiano:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.breeding_method }}
                        </span>
                    </div>

                    <label for="breeding_method_en" class="font-bold text-xl">Inglese:</label>
                    <input type="text" id="breeding_method_en" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.breeding_method_en">

                    <label for="breeding_method_fr" class="font-bold text-xl">Francese:</label>
                    <input type="text" id="breeding_method_fr" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.breeding_method_fr">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmTraductionBreeding(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalTraductionBreeding = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditFormat" class="z-50">
                <ModalAction :showModal="showModalEditFormat" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica il formato del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        formato attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.format }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Formato:</label>
                    <input type="text" class="w-full border-1 border-black rounded" v-model="copySelectedDish.format">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditFormat(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditFormat = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditCertification" class="z-50">
                <ModalAction :showModal="showModalEditCertification" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica le certificazioni del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        certificazioni attuali:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.certifications }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Certificazioni:</label>
                    <input type="text" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.certifications">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditCertification(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditCertification = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditTemperature" class="z-50">
                <ModalAction :showModal="showModalEditTemperature" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica la temperatura di servizio del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Temperatura attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.serving_temperature }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Temperatura:</label>
                    <input type="text" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.serving_temperature">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditTemperature(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditTemperature = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalEditNose" class="z-50">
                <ModalAction :showModal="showModalEditNose" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Modifica l'olfatto' del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Olfatto attuale:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.nose }}
                        </span>
                    </div>

                    <label for="name" class="font-bold text-xl">Olfatto:</label>
                    <input type="text" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.nose">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditTemperature(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalEditNose = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>

            <div v-if="showModalTraductionNose" class="z-50">
                <ModalAction :showModal="showModalTraductionNose" :selectedDrink="selectedDrink">
                    <h2 class="font-bold text-2xl text-center pb-6">
                        Traduci l'olfatto' del drink:
                    </h2>

                    <div class="text-xl pb-4 first-letter:uppercase mb-8">
                        Italiano:
                        <span class="text-red-500 text-xl">
                            {{ selectedDrink.nose }}
                        </span>
                    </div>

                    <label for="nose_en" class="font-bold text-xl">Inglese:</label>
                    <input type="text" id="node_id" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.nose_en">

                    <label for="nose_fr" class="font-bold text-xl">Francese:</label>
                    <input type="text" id="nose_fr" class="w-full border-1 border-black rounded"
                        v-model="copySelectedDish.nose_fr">


                    <div class="flex w-full justify-between py-5">
                        <button class="bg-red-600 border-black border-2 rounded text-white p-3 w-32"
                            @click="confirmEditTemperature(copySelectedDish)">Conferma</button>
                        <button class="bg-white border-black border-2 rounded text-black p-3 w-32"
                            @click="showModalTraductionNose = false">Annulla</button>
                    </div>
                </ModalAction>
            </div>
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
    props: ['selectedDrink', 'showModalDrink', 'allergens', 'allergensDrinks', 'pairingsEnoteca', 'drinks'],
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
            showModalEditInstruction: false,
            showModalEditImg: false,
            showModalEditPairings: false,
            showModalEditGrades: false,
            showModalEditColor: false,
            showModalEditProd: false,
            showModalEditFlavour: false,
            showModalEditNose: false,
            showModalEditTemperature: false,
            showModalEditOrigin: false,
            showModalEditGrape: false,
            showModalEditProducer: false,
            showModalEditDenomination: false,
            showModalEditVintage: false,
            showModalEditBreeding: false,
            showModalEditFormat: false,
            showModalEditCertification: false,
            showModalTraductionColor: false,
            showModalTraductionOrigin: false,
            showModalTraductiontProd: false,
            showModalTraductionFlavour: false,
            showModalTraductionBreeding: false,
            showModalTraductionNose: false,
            dishIdToDelete: null,
            copySelectedDish: null,
            arrayAllergens: this.allergensDrinks,
            pairings: [],
            localComponentAllergen: 0,
            selectedDishDrinks: []
        }
    },
    methods: {
        showModalDrink() {
            this.$emit('showModalDrink');
        },
        openDeleteModalDish(dishId) {
            this.dishIdToDelete = dishId;
            this.showModalDeleteDish = true;
        },
        confirmDeleteDish() {
            axios.delete(`/api/drinks/${this.dishIdToDelete}`)
            .then(response => {
                this.$emit('deleteDrink', this.selectedDrink.id);
                this.showModalDeleteDish = false;
                })
                .catch(error => {
                    console.error(error);
                });

        },
        matchDish(dishId, allergenId) {
            this.$emit('matchDish', dishId, allergenId);
        },
        isAllergenMatched(allergenId) {
            const allergenDrink = this.allergensDrinks.find(allergenDrink => allergenDrink.id === allergenId)

            if (!allergenDrink) {
                return false;
            }

            return allergenDrink.drinks.some(drink => drink.pivot.drink_id === this.selectedDrink.id);
        },
        openInputName() {
            this.showModalEditName = true;
        },
        confirmEditName(dishNew) {
            this.selectedDrink.name = dishNew.name

            axios.put(`/api/dishes/${this.selectedDrink.id}`, {
                name: dishNew.name
            })


            this.showModalEditName = false;


        },
        openInputPrice() {
            this.showModalEditPrice = true;
        },
        confirmEditPrice(dishNew) {
            this.selectedDrink.price = dishNew.price

            axios.put(`/api/dishes/${this.selectedDrink.id}`, {
                price: dishNew.price
            })

            this.showModalEditPrice = false;
        },
        openInputInstruction() {
            this.showModalEditInstruction = true;
        },
        confirmEditInstruction(dishNew) {
            this.selectedDrink.instructions = dishNew.instructions

            axios.put(`/api/dishes/${this.selectedDrink.id}`, {
                instructions: dishNew.instructions
            })

            this.showModalEditInstruction = false;
        },
        openInputDescription() {
            this.showModalEditDescription = true;
        },
        confirmEditDescription(dishNew) {
            this.selectedDrink.description = dishNew.description

            axios.put(`/api/dishes/${this.selectedDrink.id}`, {
                description: dishNew.description
            })

            this.showModalEditDescription = false;
        },
        openInputImg() {
            this.showModalEditImg = true;
        },
        uploadImage(img) {
            let body = new FormData()
            body.set('key', 'b77fe7e58631e53150bce61c6ad37bb5')
            body.append('image', img)

            return axios({
                method: 'post',
                url: 'https://api.imgbb.com/1/upload',
                data: body
            })
        },
        confirmEditImg(drinkNew) {
            let newDrink = null;
            const formData = new FormData();
            const fileInput = document.querySelector('#editImg');

            this.uploadImage(fileInput.files[0])
                .then(response => {
                    newDrink = {
                        ...drinkNew,
                        image: response.data.data.url
                    }

                    this.selectedDrink.image = newDrink.image

                    axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                        image: newDrink.image
                    })
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
        openEditPairings() {
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
        confirmEditPairings(dishId) {
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
        openInputGrades() {
            this.showModalEditGrades = true;
        },
        confirmEditDegrees(dishNew) {
            this.selectedDrink.degrees = dishNew.degrees

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                degrees: dishNew.degrees
            })

            this.showModalEditGrades = false;
        },
        openInputColor() {
            this.showModalEditColor = true;
        },
        confirmEditColor(dishNew) {
            this.selectedDrink.color = dishNew.color

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                color: dishNew.color
            })

            this.showModalEditColor = false;
        },
        openTraductionColor() {
            this.showModalTraductionColor = true;
        },
        confirmTraductionColor(dishNew) {
            this.selectedDrink.color_en = dishNew.color_en
            this.selectedDrink.color_fr = dishNew.color_fr

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                color_en: dishNew.color_en,
                color_fr: dishNew.color_fr
            })

            this.showModalTraductionColor = false;
        },
        openInputProd() {
            this.showModalEditProd = true;
        },
        confirmEditProd(dishNew) {
            this.selectedDrink.production_method = dishNew.production_method

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                production_method: dishNew.production_method
            })

            this.showModalEditProd = false;
        },
        openTraductionProd() {
            this.showModalTraductiontProd = true;
        },
        confirmTraductionProd(dishNew) {
            this.selectedDrink.production_method_en = dishNew.production_method_en
            this.selectedDrink.production_method_fr = dishNew.production_method_fr

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                production_method_en: dishNew.production_method_en,
                production_method_fr: dishNew.production_method_fr
            })

            this.showModalTraductiontProd = false;
        },
        openInputFlavour() {
            this.showModalEditFlavour = true;
        },
        confirmEditFlavour(dishNew) {
            this.selectedDrink.flavour = dishNew.flavour

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                flavour: dishNew.flavour
            })

            this.showModalEditFlavour = false;
        },
        openTraductionFlavour() {
            this.showModalTraductionFlavour = true;
        },
        confirmTraductionFlavour(dishNew) {
            this.selectedDrink.flavour_en = dishNew.flavour_en
            this.selectedDrink.flavour_fr = dishNew.flavour_fr

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                flavour_en: dishNew.flavour_en,
                flavour_fr: dishNew.flavour_fr
            })

            this.showModalTraductionFlavour = false;
        },
        openInputNose() {
            this.showModalEditNose = true;
        },
        confirmEditNose(dishNew) {
            this.selectedDrink.nose = dishNew.nose

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                nose: dishNew.nose
            })

            this.showModalEditNose = false;
        },
        openTraductionNose() {
            this.showModalTraductionNose = true;
        },
        confirmTraductionNose(dishNew) {
            this.selectedDrink.nose_en = dishNew.nose_en
            this.selectedDrink.nose_fr = dishNew.nose_fr

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                nose_en: dishNew.nose_en,
                nose_fr: dishNew.nose_fr
            })

            this.showModalTraductionNose = false;
        },
        openInputTemperature() {
            this.showModalEditTemperature = true;
        },
        confirmEditTemperature(dishNew) {
            this.selectedDrink.serving_temperature = dishNew.serving_temperature

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                serving_temperature: dishNew.serving_temperature
            })

            this.showModalEditTemperature = false;
        },
        openInputOrigin() {
            this.showModalEditOrigin = true;
        },
        confirmEditOrigin(dishNew) {
            this.selectedDrink.origin = dishNew.origin

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                origin: dishNew.origin
            })

            this.showModalEditOrigin = false;
        },
        openTraductionOrigin() {
            this.showModalTraductionOrigin = true;
        },
        confirmTraductionOrigin(dishNew) {
            this.selectedDrink.origin_en = dishNew.origin_en
            this.selectedDrink.origin_fr = dishNew.origin_fr

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                origin_en: dishNew.origin_en,
                origin_fr: dishNew.origin_fr
            })

            this.showModalTraductionOrigin = false;
        },
        openInputGrape() {
            this.showModalEditGrape = true;
        },
        confirmEditGrape(dishNew) {
            this.selectedDrink.grape_variety = dishNew.grape_variety

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                grape_variety: dishNew.grape_variety
            })

            this.showModalEditGrape = false;
        },
        openInputProducer() {
            this.showModalEditProducer = true;
        },
        confirmEditProducer(dishNew) {
            this.selectedDrink.producer = dishNew.producer

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                producer: dishNew.producer
            })

            this.showModalEditProducer = false;
        },
        openInputDenomination() {
            this.showModalEditDenomination = true;
        },
        confirmEditDenomination(dishNew) {
            this.selectedDrink.denomination = dishNew.denomination

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                denomination: dishNew.denomination
            })

            this.showModalEditDenomination = false;
        },
        openInputVintage() {
            this.showModalEditVintage = true;
        },
        confirmEditVintage(dishNew) {
            this.selectedDrink.vintage = dishNew.vintage

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                vintage: dishNew.vintage
            })

            this.showModalEditVintage = false;
        },
        openInputBreeding() {
            this.showModalEditBreeding = true;
        },
        confirmEditBreeding(dishNew) {
            this.selectedDrink.breeding_method = dishNew.breeding_method

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                breeding_method: dishNew.breeding_method
            })

            this.showModalEditBreeding = false;
        },
        openTraductionBreeding() {
            this.showModalTraductionBreeding = true;
        },
        confirmTraductionBreeding(dishNew) {
            this.selectedDrink.breeding_method_en = dishNew.breeding_method_en
            this.selectedDrink.breeding_method_fr = dishNew.breeding_method_fr

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                breeding_method_en: dishNew.breeding_method_en,
                breeding_method_fr: dishNew.breeding_method_fr
            })

            this.showModalTraductionBreeding = false;
        },
        openInputFormat() {
            this.showModalEditFormat = true;
        },
        confirmEditFormat(dishNew) {
            this.selectedDrink.format = dishNew.format

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                format: dishNew.format
            })

            this.showModalEditFormat = false;
        },
        openInputCertification() {
            this.showModalEditCertification = true;
        },
        confirmEditCertification(dishNew) {
            this.selectedDrink.certifications = dishNew.certifications

            axios.put(`/api/drinks/${this.selectedDrink.id}`, {
                certifications: dishNew.certifications
            })

            this.showModalEditCertification = false;
        },
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
.container-edit-img {
    width: 400px;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;

    .object-img {
        width: 100%;
        height: 100%;
    }
}

.bg-olive {
    background-color: #6b7238;
}

.container-drink-show {
    width: calc(100vw - 140px);
    height: calc(100vh - 110px);
    padding: 5px;
}

.grid-show-drink {
    display: grid;
    margin: 20px 0;
    height: 62vh;
    grid-template-areas:
        "nome nome nome immagine"
        "prezzo annata formato immagine"
        "colore origine gradi immagine"
        "allergeni allergeni allergeni immagine"
        "certificazioni certificazioni certificazioni immagine"
        "denominazione denominazione ingredienti ingredienti"
        "vitigno vitigno produttore produttore"
        "temperatura temperatura olfatto olfatto"
        "sapore sapore sapore sapore"
        "allevamento allevamento allevamento allevamento"
        "produzione produzione produzione produzione";
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-template-rows: repeat(8, 1fr);
    /* Usa 8 righe di altezza uguale, adatta se necessario */
    gap: 10px;
    overflow-y: scroll;
    scrollbar-width: none;

    .h-image {
        width: 100%;
        height: 80%;
    }
}

.button-delete {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 10vh;
}
</style>