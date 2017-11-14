<template>
  <div class="login-container">
    <input type="password" class="input text-input" placeholder="Login..." :disabled="blocked" v-model="secret" v-on:keyup.enter="submit">
    <div class="sending" v-if="blocked">
      Sende Login...
    </div>
    <div class="error " v-if="error">
      {{ error }}
    </div>
  </div>
</template>

<script>
  import send from '../js/send';

  export default {
    name: 'Login',
    data(){
        return {
          secret: "",
          error: "",
          blocked: false
        }
    },
    methods: {
        submit(){
          if(this.secret){
            this.blocked = true;
            send({key: btoa(this.secret), action: 'check'})
              .then(res => {
                if(res.ok){
                  this.error = "";
                  this.$emit('auth', this.secret);
                }else{
                  this.error = "Passwort falsch";
                }
                this.secret = "";
                this.blocked = false;
              })
              .catch(err => {
                this.blocked = false;
                this.error = err.message;
              });
          }
        }
    }
  }
</script>

<style>
  p.error{
    color: darkred;
  }

  input{
    width: 100%;
  }
</style>
