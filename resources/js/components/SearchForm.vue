<template>
  <div class="col-12 col-lg-5 col-xl-3 border-right" >
    <div class="px-4 d-none d-md-block">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <input type="text" class="form-control my-3" 
                        placeholder="Search..." v-model="inputSearch"
                        @input="fetchList"
                        searchCompleted = "false" ref="searchInput" >
            </div>
        </div>
    </div>
    <a href="#" class="list-group-item list-group-item-action border-0" v-for="list in lists" :key="list.id">
        <div class="badge bg-success float-right">5</div>
        <div class="d-flex align-items-start">
            <img src="./avatar.png" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
            <div class="flex-grow-1 ml-3">
                <b>{{ list.name }}</b> 
                <div class="small">
                    <span class="fas fa-circle chat-online"></span> Online
                </div>
            </div>
        </div>
    </a>
    <hr class="d-block d-lg-none mt-1 mb-0">
  </div>
</template>
<script>
export default {
  props: ["lists"],
  data() {
    return {
      inputSearch: "",
    };
  },
  methods: {
    fetchList() {
      // console.log(this.inputSearch);
      this.$emit("searching", {
        search: this.inputSearch
      }
      );
    },
  },
};
</script>