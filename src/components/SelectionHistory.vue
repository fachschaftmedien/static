<template>
  <div class="history-container centered">
    <header class="history-header">
      Verlauf
    </header>
    <ul class="history">
      <li class="history-entry row" @click="select(entry)" v-for="entry in history.entries()">
        <p class="col-xs-12" :title="entry.path.length > 0 ? entry.path : '/'">{{ entry.path.length > 0 ? entry.path : '/' }}</p>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    name: 'SelectionHistory',
    props: {
        history: {
            type: Object
        }
    },
    methods: {
        select(entry){
          this.$emit('selected', entry);
        }
    }
  }
</script>

<style>
  .history-container{
    margin-top: 2em;
  }

  .history-header{
    display: block;
    width: 100%;
    margin-bottom: 1em;
  }

  ul.history{
    width: 100%;
  }

  li.history-entry{
    width: 100%;
    margin: 0;
    cursor: pointer;
  }

  li.history-entry>p{
    display: flex;
    align-items: center;
    justify-content: flex-start;
  }

</style>
