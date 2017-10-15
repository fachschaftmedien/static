<template>
  <div class="search-container centered">
    <label for="search" :class="'search-label '+(active?'active':'inactive')">Suche...</label>
    <input type="text" class="text-input" v-model="search" @keyup="searchTree($event)" id="search" @focus="active=true" @blur="active=search.length > 0" autocomplete="off">
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
  .search-container{
    width: 100%;
    display: inline-block;
    position: relative;
    height: 2em;
  }

  .search-label, #search{
    width: 100%;
    height: 100%;
    position: absolute;
  }

  #search{
    height: 1em;
    font-size: 1em;
    z-index: 3;
  }

  .search-label{
    z-index: 4;
    margin: 0;
    top: 0;
    transition: top ease 0.3s;
  }

  .search-label.inactive{
    top: 0;
  }

  .search-label.active{
    top: -1em;
  }
</style>
