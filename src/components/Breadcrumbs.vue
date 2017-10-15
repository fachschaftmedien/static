<template>
  <div class="breadcrumb-container">
    <p class="breadcrumb" v-for="crumb in crumbs" @click="select(crumb)">
      {{ crumb.name.length > 0 ? crumb.name : '~' }}
    </p>
  </div>
</template>

<script>
  export default {
    name: 'Breadcrumbs',
    props: {
        current: {
            type: Object
        }
    },
    computed: {
        crumbs(){
            if(!this.current || !this.current.path) return [];
            let parts = this.current.path.split('/');
            let crumbs = parts.map((el, i, arr) => {
                return {
                  name: el,
                  path: arr.slice(0,i).join('/')+'/'+el
                }
            });
            return crumbs;
        }
    },
    methods: {
        select(crumb){
          this.$emit('levelTo',crumb);
        }
    }
  }
</script>

<style>
  .breadcrumb{
    display: inline-block;
    margin: 0.2em;
  }
</style>
