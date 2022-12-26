import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useItem } from 'Composable/item'

export const useProjectArchiveStore = defineStore('sidebar-project-archive', () => {
  const { processing, items } = useItem()

  async function fetch() {
    items.value = await axios.get('projects?archived')
  }

  return { items, fetch, processing }
})
