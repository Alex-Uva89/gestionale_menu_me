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
                <span class="text-bold uppercase text-red-500">
                    {{ selectedDish.name }}
                </span>
            </div>
            <ButtonCss>
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
            <img :src="'/storage/' + selectedDish.image" :alt="selectedDish.name + ' image'" class="w-full h-full object-cover">
        </div>
        <div class="h-fit flex items-center p-2 border-2 border-black" style="grid-area: allergeni;">
            <span class="font-black me-2 uppercase">
                Allergeni: 
            </span>
            <ul class="flex gap-2" v-if="activeAllergens.length">
                <li v-for="allergen in allergens" :key="allergen.id" class="rounded-full cursor-pointer">
                    <img :src="'/storage/' + allergen.icon" :alt="allergen.name + ' icon'" class="w-10 h-10 rounded-full border border-3 border-black">
                </li>
            </ul>
            <!-- <ul class="flex gap-2" v-if="activeAllergens.length">
                      <li 
                        v-for="allergen in allergens" 
                        v-show="allergen.is_active"
                        class="border border-black rounded-full flex justify-center items-center p-2 ms-2 cursor-pointer hover:bg-gray-300"
                        @click="matchDish(dish.id, allergen.id)" 
                        :id="`${dish.id}-${allergen.id}`"
                        :class="{'bg-green': allergensDishes.some(allergenDish => allergenDish.id === allergen.id && allergenDish.dishes.some(dishAbb => dishAbb.pivot.dish_id === dish.id))}">
                          <img :src="'/storage/' + allergen.icon" :alt="allergen.name + ' icon'" class="object-cover w-10 h10">
                      </li>    
            </ul> -->
            <div class="w-full ps-2 font-black uppercase text-red-600 underline decoration-4 underline-offset-4 text-center" v-else>
                        Non sono presenti allergeni attivi
            </div>


        </div>
        <div class="h-fit p-2 border-2 border-black" style="grid-area: consigli;">
            <div class="w-full flex justify-between items-center font-black uppercase">
                Consigli:
                <ButtonCss>
                    Modifica
                </ButtonCss>
            </div>
            <span class="text-bold uppercase text-red-500">
                {{ selectedDish.description }}
            </span>
        </div>
        <div class="h-fit p-2 border-2 border-black flex items-center justify-between" style="grid-area: prezzo;">
            <div class="flex gap-2">
                <div class="font-black uppercase">
                    prezzo:
                </div>
                <span class="text-bold uppercase text-red-500">
                    {{ selectedDish.price }}
                </span>
            </div>
            <ButtonCss>
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
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo eos aut, optio voluptatibus nesciunt reiciendis ex, voluptates commodi consequatur animi earum sequi, delectus aliquam ut fuga. Beatae corporis voluptatem magni. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Numquam doloribus aut eveniet quis sunt, nihil libero cum placeat natus assumenda. Debitis exercitationem eos voluptas molestiae esse quasi ut quam ipsa? 1Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo eos aut, optio voluptatibus nesciunt reiciendis ex, voluptates commodi consequatur animi earum sequi, delectus aliquam ut fuga. Beatae corporis voluptatem magni. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Numquam doloribus aut eveniet quis sunt, nihil libero cum placeat natus assumenda. Debitis exercitationem eos voluptas molestiae esse quasi ut quam ipsa? 1 Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo eos aut, optio voluptatibus nesciunt reiciendis ex, voluptates commodi consequatur animi earum sequi, delectus aliquam ut fuga. Beatae corporis voluptatem magni. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Numquam doloribus aut eveniet quis sunt, nihil libero cum placeat natus assumenda. Debitis exercitationem eos voluptas molestiae esse quasi ut quam ipsa? 1</p>
        </div>
    </div>
    </div>
</template>


<script>
import ButtonCss from '../ButtonCss.vue';


export default {
    
    props: ['selectedDish', 'showModalDish', 'allergens'],
    components: {
        ButtonCss
    },
    methods: {
        showModalDish(){
            this.$emit('showModalDish');
        }
    },
    computed: {
        activeAllergens() {
          return this.allergens.filter(allergen => allergen.is_active);
        }
    }
}

</script>

<style scoped>

.container-dish-show{
    width: calc(100vw - 140px);
    height: calc(100vh - 110px);
    padding: 5px;
}

.grid-show-dish{
    display: grid;
    margin: 20px 0;
    height: 65vh;
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
}

</style>