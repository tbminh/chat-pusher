<template>
    <search-form @searching="fetchList" :lists="lists" @openchat="handleChating" @greeting="handleGreeting"/>
    <chat-zalo @messagesent="addMessage" :messages="messages" :info="info"/>
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
        const info = ref([]);
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
        const getReceiver = () => {
            axios.get(`/getReceiver/${receiver}`).then((response) => {
                console.log(response.data);
                info.value = response.data;
            });
        }
        const addMessage = (message) => {
            axios.post(`/messages/${receiver}`, message)
                .then((response) => {
                    console.log(message);
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
                    console.log(message.container)
                    requestAnimationFrame(() => {
                        message.container.scrollTop = message.container.scrollHeight;
                    });
                })
                .catch((error) => {
                    console.error(error);
                });
        };
        const handleChating = (data) => {
            receiver = data.id
            messages.value = "";
            fetchMessages();
            getReceiver();
        }
        const handleGreeting = (data)=>{
            axios.post(`/chat/greet/${data.id}`)
            .then((response)=>{
                console.log(response.data)
            })
        }
        onMounted(() => {
            getCurrentUser();
            fetchList();
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

            Echo.channel(`chat.greet.${currentUser.value}`) //
            .listen('GreetingSent', (e) => {
                const { message, user } = e;
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
            info,
            user,
            lists,
            inputSearch,
            searchCompleted,
            bottomElRef,
            fetchList,
            addMessage,
            getCurrentUser,
            handleChating,
            handleGreeting,
        };
    },
};
</script>
