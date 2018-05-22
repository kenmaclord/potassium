<template>
  <button type="submit" class="button is-danger sessionExpired" v-if="sessionExpired" v-cloak @click.prevent="logout">
    <span class="icon">
      <i class="fa fa-sign-out"></i>
    </span>
    <span>Session expirée. Cliquez pour vous reconnecter</span>
  </button>
</template>

<script>
  export default {
    props: {
      idleTimeout: {
        required: false,
        default : 1
      },
    },

    data(){
      return{
        // Intervalle de temps entre chaque vérification
        checkInterval    : 5000,

        // Indicateur de session expirée
        sessionExpired   : false,

        // L'objet Timer
        idleSecondsTimer : "",

        // Temps avant la déconnexion
        timeBeforeLogout : this.idleTimeout*60,
      }
    },

    mounted(){
      this.checkIdleTime()

      this.initActivityEvent()

      this.idleSecondsTimer = window.setInterval(this.checkIdleTime, this.checkInterval);
    },

    methods : {
      /**
       * Vérifie si l'on a atteint le temps max d'inactivité, sinon on incrémente le timer d'inactivité
       *
       * @return  void
       */
      checkIdleTime() {
        if (this.timeBeforeLogout<=10) {
          window.clearInterval(this.idleSecondsTimer);
          this.sessionExpired = true
          Event.fire('sessionExpired')
        }

        this.timeBeforeLogout-= Math.round(this.checkInterval/1000);
      },


      /**
       * Évènements considérés comme une activité et remettant à zéro le timer d'inactivité
       *
       * @return  void
       */
      initActivityEvent(){
        self = this

        document.onclick = function(){self.timeBeforeLogout = this.idleTimeout*60;};
        document.onmousemove = function(){self.timeBeforeLogout = this.idleTimeout*60;};
        document.onkeypress = function(){self.timeBeforeLogout = this.idleTimeout*60;};
      },


      /**
       * Rafraichit la page de sorte à renouveller le token et atteindre la page de login
       */
      logout()
      {
        location.reload()
      }
    }
  }
</script>

<style scoped lang ='scss'>
  .sessionExpired{
    margin-right: 10px;
  }
</style>
