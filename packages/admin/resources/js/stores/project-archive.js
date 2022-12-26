import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useProjectArchiveStore = defineStore('sidebar-project-archive', () => {
  const
    items = ref([]),
    processing = ref(false),
    show = ref(false)

  async function fetch() {
    this.processing = true

    items.value = await axios.get('projects?archived')

    this.processing = false
    this.show = true
    this.items = items
  }

  return { items, fetch, processing, show }
})
