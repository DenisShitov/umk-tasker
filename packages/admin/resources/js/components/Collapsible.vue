<template>
  <div @click.prevent="isOpen = !isOpen">
    <slot name="trigger" :open="isOpen"/>
  </div>

  <slot v-if="isOpen"/>
</template>

<script>
  import { ref } from 'vue'

  export default {
    props: {
      open: Boolean,
    },

    setup({open}) {
      let isOpen = ref(false)

      open ? isOpen.value = true : ''

      return { isOpen }
    }
  }
</script>
