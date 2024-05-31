<template>
    <button class="button-css" role="button" :title="tooltipText" :style="{ '--hover-color': hoverColor }">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: 'ButtonCss',
    props: {
        tooltipText: {
            type: String,
            default: ''
        },
        hoverColor: {
            type: String,
            default: '#1100ff'
        }
    }
}
</script>

<style>

button.button-css{
  appearance: none;
  background-color: transparent;
  border-radius: 15px;
  color: #3B3B3B;
  cursor: pointer;
  display: inline-block;
  font-size: 16px;
  font-weight: 700;
  line-height: normal;
  min-height: 40px;
  width: fit-content;
  outline: none;
  padding: 0px 15px;
  text-align: center;
  text-decoration: none;
  transition: all 300ms cubic-bezier(.23, 1, 0.32, 1);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  will-change: transform;
}

.button-css:disabled {
  pointer-events: none;
}

.button-css:hover {
  color: #fff;
  background-color: var(--hover-color);
}

.button-css:active {
  box-shadow: none;
  transform: translateY(0);
} 

</style>