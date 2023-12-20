import {createApp} from 'vue'
import ChatMessages from './components/ChatMessages.vue';
import ChatForm from './components/ChatForm.vue';
import App from './App.vue'
import Search from './Search.vue'
import SearchForm from './components/SearchForm.vue'
import ChatZalo from './components/ChatZalo.vue'
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import axios from "axios";

// const app = createApp(Search)
// app.component('search-form',SearchForm);
// app.component('chat-zalo',ChatZalo);
// app.mount('#search-vue');

const app = createApp(Search)

const options = {
    broadcaster: 'pusher',
    key: 'f13576f65e4a23fc3d2b',
    cluster: 'ap1',
    authorizer: (channel) => {
        return {
            authorize: (socketId, callback) => {
                axios.post('/api/broadcasting/auth', {
                    socket_id: socketId,
                    channel_name: channel.name
                })
                .then(response => {
                    callback(false, response.data);
                })
                .catch(error => {
                    callback(true, error);
                });
            }
        };
    },
}

window.Echo = new Echo({
    ...options,
    client: new Pusher(options.key, options)
});

app.component('search-form',SearchForm);
app.component('chat-zalo',ChatZalo);
app.mount('#search-vue');