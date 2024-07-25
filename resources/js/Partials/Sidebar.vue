<script setup>

defineProps({
      messages: Array,
});

</script>

<template>
    
<button data-drawer-target="sidebar-multi-level-sidebar" @click="toggleDropdown" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="https://www.w3.org/2000/svg">
   <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
   </svg>
</button>

<aside id="sidebar-multi-level-sidebar" class="flex flex-col top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 border-e-2 border-black" aria-label="Sidebar">
   <div class="header-sidebar px-3 overflow-y-auto bg-gray-50 dark:bg-gray-800">
      <div class="flex lg:justify-center lg:col-start-2">
                            <img
                                src="img/mammaelvira-logo_text_rect_alt_01.svg"
                                alt="Laravel"
                                class="w-32 h-32"
                            />
      </div>
      <ul class="max-h-96 overflow-y-scroll scrolling space-y-2 font-medium">
         <li>
            <a @click="selectValueButton('Dashboard')" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group cursor-pointer">
               <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="https://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>
         <li>
            <button type="button" @click="toggleDropdown" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                  <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true"  xmlns="https://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
                     <path d="M416 0C400 0 288 32 288 176V288c0 35.3 28.7 64 64 64h32V480c0 17.7 14.3 32 32 32s32-14.3 32-32V352 240 32c0-17.7-14.3-32-32-32zM64 16C64 7.8 57.9 1 49.7 .1S34.2 4.6 32.4 12.5L2.1 148.8C.7 155.1 0 161.5 0 167.9c0 45.9 35.1 83.6 80 87.7V480c0 17.7 14.3 32 32 32s32-14.3 32-32V255.6c44.9-4.1 80-41.8 80-87.7c0-6.4-.7-12.8-2.1-19.1L191.6 12.5c-1.8-8-9.3-13.3-17.4-12.4S160 7.8 160 16V150.2c0 5.4-4.4 9.8-9.8 9.8c-5.1 0-9.3-3.9-9.8-9L127.9 14.6C127.2 6.3 120.3 0 112 0s-15.2 6.3-15.9 14.6L83.7 151c-.5 5.1-4.7 9-9.8 9c-5.4 0-9.8-4.4-9.8-9.8V16zm48.3 152l-.3 0-.3 0 .3-.7 .3 .7z"/>
                  </svg>

                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Ristorante</span>
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="https://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                  </svg>
            </button>
            <ul id="dropdown-example" class="hidden py-2 space-y-2">
               <li v-for="venue in $page.props.venues" :key="venue.id">
                     <a @click="selectVenueName(venue)" href="#" class="venue flex items-center w-full px-2 text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-whit hover:bg-blue-100">
                      {{ venue.name }}
                     </a>

               </li>
            </ul>
         </li>
         <li>
            <a @click="selectValueButton('Anteprima menù')" class="cursor-pointer flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="https://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 384 512">
                  <path d="M16 64C16 28.7 44.7 0 80 0H304c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H80c-35.3 0-64-28.7-64-64V64zM224 448a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM304 64H80V384H304V64z"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Anteprima menù</span>
            </a>
         </li>
         <li>
            <a @click="selectValueButton('Allergeni')" class="cursor-pointer flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" viewBox="0 0 16 16">
                  <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Allergeni</span>
            </a>
         </li>
         <li>
            <a @click="selectValueButton('Ricette')" class="cursor-pointer flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-book font-bold flex-shrink-0 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" viewBox="0 0 16 16">
                  <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Ricette</span>
            </a>
         </li>
         <li>
            <a @click="selectValueButton('inbox')" class="cursor-pointer flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="https://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
               <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ messages.filter(message => !message.is_read).length }}</span>
            </a>
         </li>
         
      </ul>
   </div>
   <Footer />
</aside>
</template>

<style scoped>

li {
    padding: 10px;
}

a {
    text-decoration: none;
    color: #333;
}

a:hover {
    color: #666;
}

.scrolling{
   max-height: 500px;
   scrollbar-width: thin;
   scrollbar-color: #003af7 #cccccc00;
}

.header-sidebar {
   height: 100%;
   overflow: scroll;
   scrollbar-width: none;
}


</style>

<script>
import Footer from '@/Partials/Footer.vue';

export default {
    emits: ['venueName', 'venueColor', 'valueButton'],
    components: {
         ApplicationLogo,
         Footer
      },
    methods: {
        toggleDropdown() {
            const dropdown = document.getElementById('dropdown-example');
            dropdown.classList.toggle('hidden');
        },
        selectVenueName(venue) {
            if (venue) {
               this.$emit('venue-name', venue.name);
               this.$emit('venue-color', venue.color);
            }
         },
         selectValueButton(value) {
            this.$emit('value-button', value);
      
         }
      }
}


</script>