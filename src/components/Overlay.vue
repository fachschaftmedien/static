<template>
  <div class="menu-container" v-if="visible">
    <div class="modal fade in" style="display: block">
      <div class="modal-dialogue row">
        <div class="modal-content col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">
          <header class="modal-header">
            {{ headline }}
          </header>
          <main class="modal-body">
            <div class="edit" v-if="action === 'edit'">
              <label for="name-edit">Name </label>
              <input id="name-edit" class="input text-input" v-model="name">
            </div>
            <div class="delete" v-if="action === 'delete'">
              <label for="delete-confirm">Tippe den Namen {{this.edit.type === 'dir' ? ' der Datei ' : ' des Ordners '}} um ihn löschen zu können</label>
              <input id="delete-confirm" class="input text-input" v-model="confirm">
            </div>
          </main>
          <footer class="modal-footer">
            <button type="button" class="button btn" @click="handleClick"> {{button}} </button>
          </footer>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade in"></div>
  </div>
</template>

<script>
  import send from '../js/send';

  export default {
    name: 'Overlay',
    props: {
      visible: Boolean,
      action: String,
      edit: Object,
      credential: String
    },
    data(){
      return {
        name: ""
      }
    },
    computed: {
      headline(){
          if(this.action === 'edit'){
              return 'Benenne '+this.edit.name+' um';
          }else if(this.action === 'delete'){
              return 'Lösche '+this.edit.name;
          }else if(this.action === 'move'){
              return 'Verschiebe '+this.edit.name
          }
      },
      button(){
        if(this.action === 'edit'){
          return 'speichern';
        }else if(this.action === 'delete'){
          return 'löschen ';
        }else if(this.action === 'move'){
          return 'verschieben';
        }
      }
    },
    methods: {
        handleClick(){
            send({
              action: this.action,
              name: this.edit.name,
              path: this.edit.path,
              key: this.key
            })
        }
    }
  }
</script>

<style lang="scss" scoped>
  div.menu-container{
    width: 100vw;
    height: 100vh;
    position: fixed;
    z-index: 10;
  }

  div.modal-dialogue{
    margin-top: 20vh;
  }

  .modal-footer{
    border-top: none;
  }

  .modal-header{
    border-bottom: none;
  }
</style>
