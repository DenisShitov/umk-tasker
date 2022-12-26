import { defineStore } from 'pinia'
import { useModalStore } from 'Store/modal'
import { markRaw } from 'vue'
import ModalConfirm from 'Component/ModalConfirm.vue'

export const useConfirmStore = defineStore({
  id: 'confirm',

  state: () => ({
    title: '',
    description: '',
    button: '',
    danger: false,
    onProceed: null,
    processing: false,
  }),

  actions: {
    proceed() {
      this.processing = true
      this.onProceed()
    },

    show(payload) {
      useModalStore().show(markRaw(ModalConfirm))
      this.$patch(payload)
    },

    hide() {
      this.$reset()
      useModalStore().hide()
    }
  }
})
