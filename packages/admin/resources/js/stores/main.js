import { defineStore } from 'pinia'

export const useMainStore = defineStore({
  id: 'main',

  state: () => ({
    layout: true,
    mobileSidebar: false,
  }),

  actions: {
    setLayout(bool) {
      this.layout = bool
    },

    setMobileSidebar(bool) {
      this.mobileSidebar = bool
    },
  }
})
