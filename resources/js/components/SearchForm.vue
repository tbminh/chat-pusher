<template>
    <div class="col-12 col-lg-5 col-xl-3 border-right">
        <div class="px-4 d-none d-md-block">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <input
                        type="text"
                        class="form-control my-3"
                        placeholder="Search..."
                        v-model="inputSearch"
                        @input="fetchList"
                        searchCompleted="false"
                        ref="searchInput"
                    />
                </div>
            </div>
        </div>
        <a
            href="#"
            class="list-group-item list-group-item-action border-0"
            v-for="list in lists"
            :key="list.id"
        >
            <div class="badge bg-success float-right">5</div>
            <div class="d-flex align-items-start">
                <img
                    :src="`/images/${list.avatar}`"
                    class="rounded-circle mr-1"
                    alt="Vanessa Tucker"
                    width="40"
                    height="40"
                />
                <div class="flex-grow-1 ml-3" v-on:click="openChat(list.id)">
                    <b>{{ list.name }}</b>
                    <div class="small">
                        <span class="fas fa-circle chat-online"></span> Online
                    </div>
                </div>
                <div class="flex-grow-1">
                    <button
                        class="btn btn-primary"
                        @click="greetUser(list.id)"
                    >
                        Greeting
                    </button>
                </div>
            </div>
        </a>
        <hr class="d-block d-lg-none mt-1 mb-0" />
    </div>
</template>
<script setup>
    import { ref } from "vue";

    const props = defineProps(["lists"]);
    const emit  = defineEmits(["searching", "openchat", "greeting"]);

    let inputSearch = "";
    let id = "";

    const fetchList = () => {
        emit("searching", {
            search: inputSearch,
        });
    };

    const openChat = (userId) => {
        emit("openchat", {
            id: userId,
        });
    };

    const greetUser = (userId) => {
        emit("greeting", {
            id: userId,
        });
    };
</script>