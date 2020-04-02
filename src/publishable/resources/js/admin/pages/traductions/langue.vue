<template>
  <div class="langue">
    <div class="field nom">{{langue.nom}}</div>
    <div class="field traduction">{{langue.traduction}}</div>
    <div class="field code">{{langue.code}}</div>

    <div class="field visible">
      <span class="icon" @click="toggleVisibility">
        <i class="fa fa-eye" :class="{'fa-eye': visible, 'fa-eye-slash': !visible}"></i>
      </span>
    </div>

    <div class="field available">
      <span class="icon" @click="toggleAvailability">
        <i class="fa fa-eye" :class="{'fa-eye': available, 'fa-eye-slash': !available}"></i>
      </span>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['langue'],

    data(){
      return {
        visible: !!Number(this.langue.visible),
        available: !!Number(this.langue.available),
        routePrefix: "/admin/traductions/langues"
      }
    },

    methods: {
      toggleVisibility(){
        this.visible = !this.visible

        axios.put(`${this.routePrefix}/visibility/${this.langue.code}`,{visibility: +this.visible}).then(({data}) =>
        {
          notify(data)
        })
      },


      toggleAvailability(){
        this.available = !this.available

        axios.put(`${this.routePrefix}/availability/${this.langue.code}`,{availability: +this.available}).then(({data}) =>
        {
          notify(data)
          Event.fire('availableLanguagesChanged')
        })
      },
    }
  }
</script>

<style lang='scss'>
  @import '../../../../sass/core/variables';

  .langue{
    min-height:  40px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  @media screen and (max-width: 550px){
    .field.traduction{
      display: none;
    }
  }


</style>
