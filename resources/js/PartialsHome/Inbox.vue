<script setup>

const props = defineProps({
  messages: Array,
});

</script>

<template>
    <div class="inbox relative">
        <h2 v-if="messages.some(message => !message.is_read)" class=" font-semibold p-4 border-4 border-blue-400 sticky top-0 bg-white">
            <span class="text-xl text-blue-700">Hai
              <strong class="text-2xl text-black"> {{ messages.filter(message => !message.is_read).length }} </strong>
              messaggi da leggere</span>
        </h2>
        <h2 v-else class=" font-semibold p-4 border-4 border-blue-400 sticky top-0 bg-white">
            <span class="text-xl text-blue-700">Non ci sono messaggi da leggere</span>
        </h2>
        <ul>
            <li v-for="message in messages" 
                :key="message.id" class="flex justify-between" 
                :class="message.is_read? 'bg-gray-100': 'bg-blue-200'"
                @click="readMessage(message)">
                <p :class="{ 'font-bold cliccable': !message.is_read }">
                    {{ message.content }}
                </p>
                <div class="btn btn-primary">{{ message.is_read ? '✅' : '🔴' }}</div>
            </li>
        </ul>
    </div>
</template>



    
<style scoped>
        .inbox {
            height: 300px; /* Set the desired fixed height */
            width: 100%;
            overflow-y: auto; /* Enable vertical scroll if content exceeds the height */
            min-height: calc(100vh - 7rem);
            margin-top: 2rem;
            padding: 1rem;
            background-color: #fff;
            border-radius: 4px;
            margin: 0 auto;
            scrollbar-width: thin;
            scrollbar-color: #888 #f5f5f5;
            h2{
                font-size: 1.5rem;
                color: #333;
                margin-bottom: 1rem;
            }
            ul{
                list-style-type: none;
                padding: 0;
            }
            li{
                margin-bottom: 0.5rem;
                padding: 0.5rem;
                border-radius: 4px;
            }
            .cliccable {
                cursor: pointer;
            }
        }

    
</style>

<script>
import axios from 'axios';

export default {
 
  methods: {
    async readMessage(message) {
      message.is_read = true;

      try {
        await axios.put(`/api/messages/${message.id}`, {
          is_read: true
        });
      } catch (error) {
        console.error(error);
      }
    }
  }

}
</script>
