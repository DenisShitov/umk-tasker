<template>
  <span
    class="inline-block rounded-full bg-white h-5 w-5 text-white cursor-pointer mt-0.5"
    :class="{ 'opacity-50': processing, 'bg-blue-400': task.data.completed_at, 'border border-gray-300': !task.data.completed_at }"
    @click="toggle(task.data.id)"
  >
    <svg viewBox="0 0 16 16" fill="white"><path d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/></svg>
  </span>
</template>

<script setup>
  import { ref } from 'vue'
  import { useTaskStore } from 'Store/task'
  import { useDetailStore } from 'Store/detail'
  import { useModalStore } from 'Store/modal'
  import { useIndexStore } from 'Store/index'

  const tasksIndex = useIndexStore('tasks')()
  const projectDetail = useDetailStore('project')()
  const task = useTaskStore(),
    processing = ref(false)

  function toggle(id) {
    if (processing.value) return

    processing.value = true

    axios.patch(`tasks/${id}/complete`)
      .then(data => {
        processing.value = false
        task.data.completed_at = data.completed_at

        updateProjectDetail()

        if (useModalStore().$state.page == 'calendar') {
          calendar.updateDays()
        }

        if (useModalStore().$state.page == 'tasks') {
          tasksIndex.fetch({loading: false})
        }
      })
  }

  function updateProjectDetail() {
    console.log('updateProjectDetail')
    console.log(task.data.project_id)
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }
</script>
