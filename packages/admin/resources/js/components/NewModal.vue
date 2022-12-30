<template>
  <Transition name="modal">
    <div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 sm:py-8 px-4 overflow-y-auto z-[250]" v-if="modal.open" @click="modal.hide">
<!--      <div class="modal-content bg-white rounded-lg shadow-xl mx-auto" :class="[modal.$state.width]" @click.stop>-->
      <div class="modal-content bg-white rounded-lg shadow-xl mx-auto h-full w-full" @click.stop>
        <Component :is="modal.$state.component" :id="modal.$state.id"/>
      </div>
    </div>
  </Transition>
</template>

<script setup>
  import { useModalStore } from 'Store/modal'


  const modal = useModalStore(),
      maxWidth = modal.$state.width
</script>

<style scoped>
    .modal-content {

    }
</style>
