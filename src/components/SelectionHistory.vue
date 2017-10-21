<template>
  <div class="history-container">
    <h3 class="history-header">
      Verlauf
    </h3>
    <ul class="history scrollable">
      <li class="history-entry row link" @click="select(entry)" v-for="entry in history.entries()">
        <p class="col-xs-12 truncated" :title="entry.path.length > 0 ? entry.path : '/'">{{ entry.path.length > 0 ? entry.path : '/' }}</p>
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
  .history-container>h3{
    display: block;
    width: 100%;
    height: 1em;
    font-size: 1em;
    margin-top: 1em;
    margin-bottom: 0.5em;
  }

  .history-container>ul{
    width: 100%;
    height: calc(100% - 2.5em);
  }

  li.history-entry{
    width: 100%;
    margin: 0;
    cursor: pointer;
  }

  li.history-entry>p{
    padding: 0;
  }

</style>
