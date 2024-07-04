<script>
export default {
  props: {
    value: Boolean
  },
  methods: {
    toggleSwitch(event) {
        this.$emit('input', event.target.checked);
        this.$emit('switchChanged', event.target.checked);;
    }
  }
}
</script>

<template>
    <label class="switch">
        <input type="checkbox" :checked="value" @change="toggleSwitch">
        <span class="slider round"></span>
    </label>
</template>

<style scoped>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  z-index: 0;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
  z-index: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  z-index: 0;
  -webkit-transition: .4s;
  transition: .4s;
  border: 2px solid #000000;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 1px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #15b503;
  border: 2px solid #0b6501;
}

input:focus + .slider {
  box-shadow: 0 0 1px #15b503;
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