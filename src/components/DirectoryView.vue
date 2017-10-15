<template>
  <div id="directories">
    <ul class="current-directory-list">
      <li class="current-directory-list-item up-list-item">
        <div class="current-directory-item row" @click="handleClick('..')">
          <div class="col-xs-3">
            <span class="fa fa-level-up"></span>
          </div>
          <div class="col-xs-9">
            <a href="#" tabindex="4" class="directory-item-link"> (Ebene nach oben) </a>
          </div>
        </div>
      </li>
      <li v-for="(entry, index) in entries" class="current-directory-list-item">
        <div class="current-directory-item row" @click="handleClick(entry)">
          <div class="col-xs-3 current-item-icon icon">
            <span :class="entry.type === 'dir' ? dirIconClass : fileIconClass"></span>
          </div>
          <div class="col-xs-9">
            <a href="#" :tabindex="index+5" class="directory-item-link"> {{entry.name}} </a>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    name: 'DirectoryView',
    props: {
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
      }
    },
    computed: {
        entries(){
            if(!this.current || !this.current.children) return [];
            return this.current.children.sort((a, b)=>{
                console.log(a.type, a.name, b.type, b.name);
                if(a.type === b.type){
                  return a.name.localeCompare(b.name);
                }else{
                  return a.type === 'dir' ? -1 : 1;
                }
            });
        }
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
