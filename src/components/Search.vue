<template>
  <div class="search-container centered">
    <input type="text" class="text-input" placeholder="Suche..." v-model="search" @keyup="searchTree($event)" id="search" @focus="active=true" @blur="active=search.length > 0" autocomplete="off">
  </div>
</template>

<script>

  export default {
    name: 'Search',
    props: {
        tree: {
            type: Object
        }
    },
    data(){
        return {
          search: "",
          results: [],
          timer: null,
          active: false
        }
    },
    methods: {
        searchTree($event){
            let activeClass = 'active';
            this.active = this.search.length > 0;
            let elem = $event.target;
            elem.classList.add(activeClass);
            this.timer = setTimeout(()=>{
              elem.classList.remove(activeClass);
              if(this.search.length === 0) this.active = false;
              this.$emit('searched',this.search);
              this.timer = null;
            },500);
        }
    }
  }
</script>

<style>

  #search{
    width: 100%;
  }

  .search-container{
    width: 100%;
    height: 2em;
  }

  #search{
    height: 1em;
    font-size: 1em;
    z-index: 3;
  }
</style>
