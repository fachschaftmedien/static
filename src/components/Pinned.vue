<template>
  <div class="pinned-container">
    <h3> Gepinnte Ordner & Dateien </h3>
    <ul class="pinned-list scrollable">
      <li class="pinned-item row link" v-for="pin in pins">
        <p class="col-xs-10 truncated" :title="pin.path" @click="select(pin)">
          {{pin.name}}
        </p>
        <p class="col-xs-2">
          <span class="fa fa-times" @click="unpin(pin)"></span>
        </p>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'Pinned',
  props: {
      pins: Array
  },
  methods: {
      unpin(entry){
        this.$emit('unpin', entry);
      },
      select(entry){
        this.$emit('selected', entry);
      }
  }
}
</script>

<style>
  .pinned-container{
    width: 100%;
    height: 100%;
  }

  .pinned-container>h3{
    height: 1em;
    width: 100%;
    font-size: 1em;
    margin-top: 1em;
    margin-bottom: 0.5em;
  }

  .pinned-container>ul{
    height: calc(100% - 2.5em);
    width: 100%;
  }
</style>
