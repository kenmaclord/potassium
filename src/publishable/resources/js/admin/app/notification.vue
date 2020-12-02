<template>
  <div class="flash alerts">
    <div :class="alertType">
      <div class="alert__message" v-html="inside_message"></div>
    </div>
  </div>

</template>

<script>
import velocity from 'velocity-animate';

export default {
  props : ["type","message"],

  data : function(){
    return {
      element:"",
      animating : false,
      easing : [.06, .55, .4, .99],
      durations : {
        opening : 700,
        showing : 5000,
        closing : 1200
      },
      inside_type: "",
      inside_message:""
    }
  },

  computed : {
    alertType : function(){
      return "alert alert--"+ this.inside_type;
    }
  },

  created(){
    Event.listen('flash', ({status, message})=>{
      if(status==undefined || message==undefined)
      {
        if(this.type!="" || this.message!="")
        {
          this.inside_type = this.type
          this.inside_message = $.nl2br(this.message)
          this.displayAlert();
        }
      }else
      {
        if(status!=undefined) { this.inside_type = status }
        if(message!=undefined) {this.inside_message = $.nl2br(message) }

        this.displayAlert();
      }
    })
  },


  mounted(){
    this.element = document.querySelector('.flash.alerts')
  },


  methods : {
    displayAlert(){
      if(!this.animating){
        this.flashAnimate()
      }else{
        velocity(this.element,"stop", true)
        velocity(this.element,"reverse",{duration:500})
        this.flashAnimate()
      }
    },

    flashAnimate(){
      var vm = this

      velocity(this.element, { translateX: ["0%", "101%"] }, {
        duration : this.durations.opening,
        easing   : this.easing,

        begin(){ vm.animating = true },
      })

      velocity(this.element, { translateX: ["101%","0%"] }, {
        delay    : this.durations.showing,
        duration : this.durations.closing,
        easing   : this.easing,

        complete(){ vm.animating = false }
      })
    }
  }
}
</script>


<style lang='scss' scoped>
  .alerts{
    position: fixed;
    top:100px;
    right:0px;
    transform: translateX(101%);
    max-width: 50%;
    z-index: 1000;

    .alert{
      width:100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      color: var(--color-white);
      padding: 15px;
      min-height:50px;

      &--success{ background-color: var(--color-green-500); }
      &--error{ background-color: var(--color-red-500); }
      &--info{ background-color: var(--color-light-blue-400); }
    }
  }

  @media screen and (max-width: 480px){
    .alerts{
      max-width: 80%;
    }
  }

</style>
