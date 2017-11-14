<template>
  <div id="directories">
    <ul class="current-directory-list">
      <li class="current-directory-list-item up-list-item link">
        <div class="current-directory-item row">
          <div class="col-xs-3">
            <span class="fa fa-level-up" @click="handleClick('..')"></span>
          </div>
          <div class="col-xs-9">
            <a href="#" tabindex="4" class="directory-item-link" @click="handleClick('..')"> (Ebene nach oben) </a>
          </div>
        </div>
      </li>
      <li v-for="(entry, index) in entries" class="current-directory-list-item link">
        <div class="current-directory-item row">
          <div class="col-xs-1 current-item-icon icon">
            <span :class="entry.type === 'dir' ? dirIconClass : fileIconClass" @click="handleClick(entry)"></span>
          </div>
          <div class="col-xs-8">
            <a href="#" :tabindex="index+5" class="directory-item-link" @click="handleClick(entry)"> {{entry.name}} </a>
          </div>
          <div class="col-xs-1 current-item-icon">
            <span v-if="loggedIn" class="fa fa-pencil" title=" Datei /  Ordner bearbeiten" @click="showMenu('edit', entry)"></span>
          </div>
          <div class="col-xs-1 current-item-icon">
            <span v-if="loggedIn" class="fa fa-trash" title="Datei / Ordner löschen" @click="showMenu('delete', entry)"></span>
          </div>
          <div class="col-xs-1 current-item-icon">
            <span :class="isPinned(entry) ? unpinClass : pinClass" @click="handlePin(entry)"></span>
          </div>
        </div>
      </li>
    </ul>
    <div class="upload-controls" v-if="loggedIn">
      <button class="btn button">Ordner hier erstellen <span class="fa fa-plus"></span></button>
      <button class="btn button">File hier uploaden <span class="fa fa-upload"></span></button>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'DirectoryView',
    props: {
      loggedIn: {
        type: Boolean,
        default: false
      },
      pins: {
          type: Array
      },
      tree: {
        type: Object,
      },
      current: {
        type: Object,
        default: () => {}
      },
      dirIconClass: {
        type: String,
        default: 'fa fa-folder'
      },
      fileIconClass: {
        type: String,
        default: 'fa fa-file'
      },
      pinClass: {
        type: String,
        default: 'fa fa-thumb-tack'
      },
      unpinClass: {
        type: String,
        default: 'fa fa-times'
      }
    },
    computed: {
        entries(){
            if(!this.current || !this.current.children) return [];
            return this.current.children
              .filter((el)=> el && el.name && el.path && el.name.replace('_','').trim().length > 0)
              .sort((a, b)=>{
                if(a.type === b.type){
                  return a.name.localeCompare(b.name);
                }else{
                  return a.type === 'dir' ? -1 : 1;
                }
              });
        },
    },
    methods: {
      handleClick(entry){
          if(entry.type === 'file'){
              this.$emit('fileOpen', entry);
          }else if(entry.type === 'dir'){
              this.$emit('dirOpen', entry);
          }else if(entry === '..'){
              this.$emit('levelUp', this.current);
          }
      },
      handlePin(entry){
          if(this.isPinned(entry)){
              this.$emit('unpin', entry);
          }else{
              this.$emit('pin', entry);
          }
      },
      isPinned(entry){
        return this.pins && this.pins.findIndex(pin => entry.path === pin.path) >= 0;
      },
      showMenu(action, entry){
        this.$emit('showMenu', action, entry);
      }
    }
  }

</script>

<style>
  #directories{
    width: 96%;
    height: 100%;
    margin: 0 2%;
  }

  a.directory-item-link{
    text-decoration: none;
    color: inherit;
  }

  a.directory-item-link:active, a.directory-item-link:focus{
    text-decoration: underline;
  }
</style>
