import { defineStore } from 'pinia'

export const useFlashStore = defineStore({
  id: 'flash',

  state: () => ({
    message: null,
    type: 'success'
  }),

  actions: {
    hide() {
      this.message = null
    },

    flash(message, type = 'success') {
      this.message = message
      this.type = type

      setTimeout(() => {
        this.hide()
      }, 4000)
    },

    success(message) {
      this.flash(message, 'success')
    },

    danger(message) {
      this.flash(message, 'danger')
    }
  }
})
