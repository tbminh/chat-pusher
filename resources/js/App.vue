<template>
  <div class="container">
    <div class="card">
      <div class="card-header">Chats</div>
      <div class="card-body">
        <chat-messages :messages="messages"></chat-messages>
      </div>
      <div class="card-footer">
        <chat-form @messagesent="addMessage" :user="user"></chat-form>
      </div>
    </div>
  </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import ChatMessages from './components/ChatMessages.vue';
import ChatForm from './components/ChatForm.vue';
import axios from 'axios';

export default {
  components: {
    ChatMessages,
    ChatForm
  },
  setup() {
    const messages = ref([]);
    const user = ref(null);
    
    const fetchMessages = () => {
      axios.get('/messages')
        .then(response => {
          messages.value = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    };

    const addMessage = (message) => {
      axios.post('/messages', message)
        .then(response => {
          const { name } = response.data;
          const newMessage = {
            user: { name },
            message: message.message,
          };
          // messages.value.push(newMessage)
        })
        .catch(error => {
          console.error(error);
        });
    };
 
    onMounted(() => {
      fetchMessages();
      Echo.channel('chat')
        .listen('MessageSent', (e) => {
          const { message, user } = e;
          const newMessage = {
            message: message.message,
            user,
          };
          messages.value.push(newMessage);
        });
    });

    return {
      messages,
      user,
      addMessage
    };
  }
};
</script>
<!-- <script>
import ChatMessages from './components/ChatMessages.vue';
import ChatForm from './components/ChatForm.vue';
export default {
  components: {
    ChatMessages,
    ChatForm
  },
  
  data() {
    return {
      messages: []
    };
  },
  methods: {
    addMessage(message) {
      this.messages.push(message); // Thêm tin nhắn vào mảng 'messages'
    }
  }
};
</script> -->

    