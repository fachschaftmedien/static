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
            const headers = new Headers();
            headers.append('Authorization', 'Basic ' + btoa("studident:kukident"));
            fetch('/manage.php?action=check&key='+btoa(this.secret), {method: 'POST', headers: headers})
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
