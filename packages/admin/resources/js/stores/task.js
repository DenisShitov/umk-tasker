import { defineStore } from 'pinia'

export const useTaskStore = defineStore({
  id: 'task',

  state: () => ({
    loading: true,
    data: {},
    options: {},
    isContentForm: false,
    subtaskForm: null,
    checklistItemForm: null,
      commentForm: null,
      isContentFormDesc: false,
      isContentFormTitle: false,
    newSubtaskForm: false,
    newChecklistItemForm: false,
  }),

  actions: {
    fetch(payload) {
      if (typeof payload == 'number') {
        this.loading = payload

        axios.get('tasks/' + payload)
          .then(data => {
            this.loading = false
            this.options = data.options
            this.data = data.task
          })
      } else {
        this.loading = payload.loading

        axios.get('tasks/' + payload.id)
          .then(data => {
            this.loading = false
            this.options = data.options
            this.data = data.task
          })
      }
    },
  }
})
