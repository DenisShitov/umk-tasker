<template>
  <div class="px-2">
    <div class="flex items-center mb-1.5 ltr:pl-2 rtl:pr-2 py-2 hover:bg-gray-300 rounded cursor-pointer group" v-show="!show" @click="showForm">
      <svg class="h-4 w-4 text-gray-500 group-hover:text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>

      <span class="block ltr:ml-2 rtl:mr-2 text-sm text-gray-500 group-hover:text-gray-700">{{ __('Add task') }}</span>
    </div>

    <div class="mb-2" v-show="show">
      <input type="text" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-sm border-gray-300 rounded-md" v-model="task" ref="taskinput" @keyup.enter="submit" @keyup.escape="cancel" placeholder="Enter a task"/>

      <div class="mt-2">
        <v-button size="xs" @click="submit" :processing="processing">{{ __('Add task') }}</v-button>
        <v-button class="ltr:ml-1 rtl:mr-1" white size="xs" @click="hideForm" :disabled="processing">{{ __('Cancel') }}</v-button>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { useDetailStore } from 'Store/detail'

  const props = defineProps({
    projectId: Number,
    listId: Number,
    listIndex: Number
  })
  const show = ref(false),
    processing = ref(false),
    task = ref(''),
    taskinput = ref(null)

  const detail = useDetailStore('project')()

  function showForm() {
    console.log( detail.data.lists )
    console.log('showForm')
    console.log(props.projectId)
    show.value = true
    setTimeout(function () {
      taskinput.value.focus()
    })
  }

  function hideForm() {
    show.value = false
    task.value = ''
  }

  function submit() {
    console.log(detail.data.lists)
    console.log(props.listIndex)
    console.log( detail.data.lists[props.listIndex] )
    if (!task.value) return

    processing.value = true

    axios.post('tasks', {
      task: task.value,
      project_id: props.projectId,
      list_id: props.listId
    })
      .then(data => {
        console.log(data)
        detail.data.lists[props.listIndex].tasks.push(data)
        task.value = ''
        show.value = false
        processing.value = false
      })
  }
</script>
