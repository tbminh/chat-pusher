<template>
    <search-form @searching="fetchList" :lists="lists" @greeting="handleGreeting"/>
    <chat-zalo @messagesent="addMessage" :messages="messages" />
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
    setup() {
        const searchCompleted = ref(false);
        const lists = ref([]); // Khai báo biến lists sử dụng ref

        const inputSearch = ref("");
        const messages = ref([]);
        const currentUser = ref(null);
        const user = ref(null);
        const bottomElRef = ref(null);
        var receiver = 1;
        const getCurrentUser = () => {
            axios
                .get("/getCurrentUser")
                .then((response) => {
                    currentUser.value = response.data.user;
                })
                .catch((error) => {
                    console.error(error);
                });
        };
        const fetchList = (search) => {
            axios
                .get("/getList", { params: search })
                .then((response) => {
                    lists.value = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        };
        const fetchMessages = () => {
            axios
                .get(`/messages/${receiver}`)
                .then((response) => {
                    console.log(response.data);
                    const a = response.data.map((item, index) => ({
                        className:
                            item.user.id == currentUser.value
                                ? "chat-message-right pb-3"
                                : "chat-message-left pb-3",
                        ...item,
                    }));
                    messages.value = a;
                })
                .catch((error) => {
                    console.error(error);
                });
        };
        const addMessage = (message) => {
            axios.post("/messages", message)
                .then((response) => {
                    const { name } = response.data;
                    const newMessage = {
                        user: { name },
                        message: message.message,
                        className:
                        response.data.id == currentUser.value
                            ? "chat-message-right pb-3"
                            : "chat-message-left pb-3",
                    };
                    messages.value.push(newMessage);
                })
                .catch((error) => {
                    console.error(error);
                });
        };
        const handleGreeting = (data) => {
            receiver = data.id;
            messages.value = "";
            fetchMessages();
            // axios.post('/chat/greet/'+data.id)
            // .then((response)=>{
            //     console.log("Dô kèo");
            // })
        }
        onMounted(() => {
            getCurrentUser();
            fetchList();
            // fetchMessages();
            Echo.channel('chat').listen("MessageSent", (e) => {
               const { message, user, className } = e;
               const newMessage = {
                   message: message.message,
                   user,
                   className:
                       user.id == currentUser.value
                           ? "chat-message-right pb-3"
                           : "chat-message-left pb-3",
               };
               if (user.id != currentUser.value){
                   messages.value.push(newMessage);
               }
            });

            Echo.channel(`chat.greet.${currentUser.value}`)
            .listen('GreetingSent', (e) => {
                const { message, user, className } = e;
                messages.value.push({
                    message: message.message,
                    user,
                    className: "chat-message-left pb-3"
                });
                console.log("Đã nhận");
            });            
        });
        return {
            messages,
            user,
            lists,
            inputSearch,
            searchCompleted,
            bottomElRef,
            fetchList,
            addMessage,
            getCurrentUser,
            handleGreeting,
        };
    },
};
</script>
