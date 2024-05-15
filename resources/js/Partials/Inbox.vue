<script setup>

const props = defineProps({
  messages: Array,
});

</script>

<template>
    <div class="inbox">
        <h2>
            <span>Messaggi</span>
            <!-- <span v-show="messages.filter(message => !message.read).length > 0" class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                {{ messages.filter(message => !message.read).length }}
            </span> -->
        </h2>
        <ul>
            <li v-for="message in messages" :key="message.id" class="flex justify-between cliccable" @click="readMessage(message)">
                <p :class="{ 'font-bold': !message.is_read }">
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
                background-color: #f5f5f5;
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
