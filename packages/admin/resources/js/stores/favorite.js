import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useFavoriteStore = defineStore('favorite', () => {
  const items = ref([])

  async function fetch() {
    items.value = await axios.get('favorites')
  }

  return { items, fetch }
})
