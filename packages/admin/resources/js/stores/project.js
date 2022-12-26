import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useProjectStore = defineStore('sidebar-project', () => {
  const items = ref([])

  async function fetch() {
    items.value = await axios.get('projects')
  }

  return { items, fetch }
})
