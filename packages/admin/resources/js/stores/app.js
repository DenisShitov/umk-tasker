import { defineStore } from 'pinia'

export const useAppStore = defineStore({
  id: 'app',

  state: () => ({
    favorites: [],
    projects: []
  }),

  actions: {
    //
  }
})
