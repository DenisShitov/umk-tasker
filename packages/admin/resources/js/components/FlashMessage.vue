<template>
  <div
    class="fixed h-10 px-4 rounded flex items-center text-white text-sm"
    :class="{ 'bg-green-600': flash.type == 'success', 'bg-red-500': flash.type == 'danger' }"
    style="right: 2rem; bottom: 7%; touch-action: pan-y; z-index: 2000;"
    v-if="flash.message"
  >
    {{ flash.message }}

    <x-icon
      class="w-5 ml-2 cursor-pointer"
      @click="flash.hide"
    />
  </div>
</template>

<script>
  import { useFlashStore } from 'Store/flash'
  import { XIcon } from '@heroicons/vue/outline'

  export default {
    components: {
      XIcon,
    },

    setup() {
      let flash = useFlashStore()

      return { flash }
    }
  }
</script>
