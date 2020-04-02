<template>
  <label class="toggle">
    <div class="false" v-text="falseText"></div>
    <div class="center">
      <input type="checkbox" :checked="value" @change="toggle">
      <div class="slider round"></div>
    </div>
    <div class="true" v-text="trueText"></div>
  </label>
</template>

<script>
  export default {
    props: ['value', 'falseText', 'trueText'],

    created(){
      this.$emit('input', this.value)
    },

    methods: {
      toggle(){
        this.$emit('input', event.target.checked)
      }
    }
  }
</script>


<style scoped lang='scss'>
  /* The toggle - the box around the slider */

  .toggle{
    display: flex;
    align-items: center;
    height: 34px;
  }

  .center {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    margin: 0 15px;
  }

  /* Hide default HTML checkbox */
  .center input {display: none;}

  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #2c363f;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: #F3F3F3;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: #2c363f;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #2c363f;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>
