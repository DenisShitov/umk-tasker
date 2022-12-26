<template>
  <div :id="name" class="dropdown relative">
    <div :id="name + '-trigger'" @click.prevent="isOpen = !isOpen, $emit('toggle', isOpen)">
      <slot name="trigger"/>
    </div>

    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <slot v-if="isOpen"/>
    </transition>
  </div>
</template>

<script>
  import { ref, watch, onUpdated } from 'vue'

  export default {
    props: {
      modal: Boolean,
      name: String,
      close: Boolean,
      closeOutside: Boolean,
    },

    emits: ['toggle'],

    setup(props, ctx) {
      let isOpen = ref(false)

      onUpdated(() => {
        if (props.close)
          isOpen.value = false
      })

      watch(isOpen, (current, prev) => {
        if (current) {
          props.modal
            ? document.querySelector('.modal-content').addEventListener('click', props.closeOutside ? closeIfClickedOutside : closeOnClick)
            : document.addEventListener('click', props.closeOutside ? closeIfClickedOutside : closeOnClick)
        } else {
          props.modal
            ? document.querySelector('.modal-content').removeEventListener('click', props.closeOutside ? closeIfClickedOutside : closeOnClick)
            : document.removeEventListener('click', props.closeOutside ? closeIfClickedOutside : closeOnClick)
        }
      })

      function closeIfClickedOutside(event) {
        if (! event.target.closest(`#${props.name}`)) {
          isOpen.value = false
          ctx.emit('toggle', isOpen.value)
        }
      }

      function closeOnClick(event) {
        if (! event.target.closest(`#${props.name}-trigger`)) {
          isOpen.value = false
          ctx.emit('toggle', isOpen.value)
        }
      }

      return {
        isOpen
      }
    }
  }
</script>
