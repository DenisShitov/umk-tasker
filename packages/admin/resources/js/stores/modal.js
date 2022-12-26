import { defineStore } from 'pinia'

export const useModalStore = defineStore({
  id: 'modal',

  state: () => ({
    id: null,
    open: false,
    // width: 'max-w-xl',
    width: '86%',
    component: null,
    onHide: null,
  }),

  actions: {
    show(component, payload = null) {
      this.component = component
      this.open = true

      if (payload instanceof Event || !payload) return

      if (typeof payload === 'number') {
        this.id = payload
      } else {
        if (payload.id instanceof Event) payload.id = null
        this.$patch(payload)
      }
    },

    hide() {
      this.hook('onHide')
      this.id = null
      this.open = false
      this.component = null
    },

    hook(callback, payload = null) {
      if (typeof this[callback] === 'function')
        this[callback](payload)
    },
  }
})
