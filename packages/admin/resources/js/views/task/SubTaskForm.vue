<template>
  <div class="flex" :class="{ 'opacity-50': processing }">
    <input
      type="text"
      v-model="subtask"
      class="subtask-input disabled:opacity-50 flex-1 focus:ring-0 focus:border-gray-300 block w-full rounded-none ltr:rounded-l-md rtl:rounded-r-md text-sm border-gray-300 disabled:opacity-50"
      @keyup.enter="submit"
      @keydown.esc="hideForm"
      placeholder="Enter sub-task">

    <button type="button" @click="hideForm" class="disabled:opacity-50 ltr:-ml-px rtl:-mr-px relative inline-flex items-center space-x-2 rtl:space-x-reverse px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-0 focus:border-gray-300">
      <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

    <button type="button" class="disabled:opacity-50 ltr:-ml-px rtl:-mr-px relative inline-flex items-center space-x-2 rtl:space-x-reverse px-4 py-2 border border-gray-300 text-sm font-medium ltr:rounded-r-md rtl:rounded-l-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-0 focus:border-gray-300" @click="submit">
      <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
    </button>
  </div>
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  import { useTaskStore } from 'Store/task'

  const props = defineProps({
    id: Number,
    index: Number,
    subtask: String,
  })

  onMounted(() => {
    document.querySelector('.subtask-input').focus()
  })

  const task = useTaskStore(),
    processing = ref(false),
    subtask = ref(props.subtask)

  function hideForm() {
    task.subtaskForm = null
    task.newSubtaskForm = false
  }

  function submit() {
    if (processing.value) return
    if (!subtask.value) return

    if (props.subtask == subtask.value && props.id) {
      hideForm()
      return
    }

    processing.value = true

    const method = props.id ? 'patch' : 'post'
    const uri = props.id ? `sub-tasks/${props.id}` : 'sub-tasks'

    axios[method](uri, {
      title: subtask.value,
      parent_id: task.data.id,
      project_id: task.data.project_id,
    })
      .then(data => {
        processing.value = false
        props.id ? updateTask(data) : appendTask(data)
        props.id ? hideForm() : subtask.value = ''
      })
  }

  function appendTask(subtask) {
    task.data.tasks.push(subtask)
  }

  function updateTask(subtask) {
    task.data.tasks[props.index] = subtask
  }
</script>
