<template>
  <section class="py-3">
    <h2 class="text-gray-600 text-sm font-medium px-2">{{ __('Delete') }}</h2>

    <div class="px-2 mt-2 space-y-2" v-if="isDeleteConfirm">
      <button @click="archive" class="w-full flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-0 disabled:opacity-50" :disabled="processing">
        <TrashIcon class="w-3.5 h-3.5 mr-2"/>
        {{ __('Are you sure') }}
      </button>

      <button @click="isDeleteConfirm = false" class="w-full flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-500 bg-gray-200 hover:text-gray-700 focus:outline-none focus:ring-0 disabled:opacity-50" :disabled="processing">
        <ReplyIcon class="w-3.5 h-3.5 mr-2"/>
        {{ __('Cancel') }}
      </button>
    </div>

    <div class="px-2 mt-2 space-y-2" v-else>
      <button @click="isDeleteConfirm = true" class="w-full flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-500 hover:text-gray-700 bg-gray-200 focus:outline-none focus:ring-0">
        <TrashIcon class="w-3.5 h-3.5 mr-2"/>
          {{ __('Delete') }}
      </button>
    </div>
  </section>
</template>

<script setup>
  import { ref } from 'vue'
  import { ArchiveIcon, TrashIcon } from '@heroicons/vue/outline'
  import { ReplyIcon } from '@heroicons/vue/solid'
  import { useTaskStore } from 'Store/task'
  import { useDetailStore } from 'Store/detail'
  import { useModalStore } from 'Store/modal'
  import { useFlashStore } from 'Store/flash'

  const task = useTaskStore()
  const projectDetail = useDetailStore('project')()
  const processing = ref(false)
  const isDeleteConfirm = ref(false)

  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }

  function archive() {
    if (processing.value) return

    processing.value = true

    axios.patch('tasks/' + task.data.id + '/archive')
      .then(data => {
        processing.value = false
        updateProjectDetail()
        task.data.deleted_at = 'archived'
        close()
      })
  }

  function restore() {
    if (processing.value) return

    processing.value = true

    axios.patch('tasks/' + task.data.id + '/restore')
      .then(data => {
        processing.value = false
        // updateProjectDetail()
        task.data.deleted_at = null
      })
  }

  function deleteTask() {
    if (processing.value) return

    processing.value = true

    axios.delete(`tasks/${task.data.id}`)
      .then(data => {
        close()
        processing.value = false
        useFlashStore().flash(data.message)
        updateProjectDetail()
      })
      .catch(error => {
        useFlashStore().danger(error.response.data.message)
      })
  }

  function close() {
    const url = `/projects/${task.data.project_id}`
    history.replaceState(history.state, '', url)

    useModalStore().hide()
  }
</script>
