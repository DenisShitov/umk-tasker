import { ref } from 'vue'

export function useItem() {
  const
    items = ref([]),
    processing = ref(false)

  return {
    items,
    processing,
  }
}
