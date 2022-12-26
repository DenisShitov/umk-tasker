<template>
  <div class="relative flex group">
    <!-- <span class="inline-block rounded-full bg-white h-5 w-5 text-white cursor-pointer mt-px border border-gray-300 mr-2">
      <svg viewBox="0 0 16 16" fill="white"><path d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/></svg>
    </span> -->
    <SubTaskCheckbox :id="id" :index="index" :is-completed="isCompleted"/>

    <p class="flex-1 text-gray-700 text-sm" @click="task.subtaskForm = index">{{ subtask }}</p>

    <div class="absolute flex items-center right-0 bg-white pl-4" :class="{ 'opacity-50': processing }" v-if="deleteConfirmation">
      <span class="text-gray-600 text-sm mr-2">Are you sure to delete?</span>
      <CheckCircleIcon class="w-5 h-5 text-green-600 cursor-pointer hover:text-green-800 mr-1" @click="deleteTask"/>
      <XCircleIcon class="w-5 h-5 text-red-600 cursor-pointer hover:text-red-800" @click="deleteConfirmation = false"/>
    </div>

    <div class="absolute hidden group-hover:flex right-0 bg-white pl-4" v-else>
      <span @click="task.subtaskForm = index" class="mr-1">
        <PencilAltIcon class="w-4 h-4 text-gray-600 cursor-pointer hover:text-gray-900"/>
      </span>
      <TrashIcon class="w-4 h-4 text-gray-600 cursor-pointer hover:text-gray-900" @click="deleteConfirmation = true"/>
    </div>
  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { useTaskStore } from 'Store/task'
  import SubTaskCheckbox from './SubTaskCheckbox.vue'
  import { PencilAltIcon, TrashIcon, XCircleIcon, CheckCircleIcon } from '@heroicons/vue/outline'

  const props = defineProps({
    id: Number,
    index: Number,
    subtask: String,
    isCompleted: String,
  })

  const task = useTaskStore(),
    deleteConfirmation = ref(false),
    processing = ref(false)

  function deleteTask() {
    if (processing.value) return

    processing.value = true

    axios.delete(`sub-tasks/${props.id}`)
      .then(data => {
        processing.value = false
        if (!data.success) return
        task.data.tasks.splice(props.index, 1)
      })
  }
</script>
