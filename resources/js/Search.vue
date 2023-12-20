<template>
    <search-form @searching="fetchList" :lists="lists" />
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
        const room_id = 1;
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
                    //  searchCompleted.value = true;
                })
                .catch((error) => {
                    console.error(error);
                });
        };
        const fetchMessages = () => {
            axios
                .get(`/messages/${room_id}`)
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
                    // messages.value.push(newMessage);
                })
                .catch((error) => {
                    console.error(error);
                });
        };
        onMounted(() => {
            getCurrentUser();
            fetchList();
            fetchMessages();
            // Echo.private('private-chat.' + currentUser.value)
            //     .listen('.MessageSent', (event) => {
            //         const { message, user, className } = event;
            //         const newMessage = {
            //             message: message.message,
            //             user,
            //             className:
            //                 user.id === currentUser.value
            //                     ? 'chat-message-right pb-3'
            //                     : 'chat-message-left pb-3',
            //         };
            //         if (user.id !== currentUser.value) {
            //             messages.value.push(newMessage);
            //         }
            //     });
            Echo.private("chat"+ room_id).listen("MessageSent", (e) => {
                console.log(e);
                const { message, user, className } = e;
                const newMessage = {
                    message: message.message,
                    user,
                    className:
                        user.id == currentUser.value
                            ? "chat-message-right pb-3"
                            : "chat-message-left pb-3",
                };
                // if (user.id != currentUser.value){
                    messages.value.push(newMessage);
                // }
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
        };
    },
};
</script>
