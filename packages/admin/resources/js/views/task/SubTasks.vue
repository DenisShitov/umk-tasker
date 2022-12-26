<template>
  <section id="subtasks" class="mt-8">
    <Collapsible :open="true">
      <template #trigger="{ open }">
        <div class="flex">
          <svg class="w-4 h-4 mr-4 text-gray-500 mt-1 cursor-pointer" :class="{ 'rotate-[270deg]': !open }" viewBox="0 0 16 16"><path d="M14 5.758L13.156 5 7.992 9.506l-.55-.48.002.002-4.588-4.003L2 5.77 7.992 11 14 5.758" fill="currentColor"></path></svg>

          <div class="flex-1 border-b pb-2">
            <span class="font-medium text-sm text-gray-800">Sub-tasks</span>
            <span class="text-sm font-light ml-2 text-gray-600">{{ countSubTasks() }}</span>
          </div>
        </div>
      </template>

      <div class="pl-8 pt-4">
        <div class="space-y-4">
          <template v-for="(subtask, index) in task.data.tasks" :key="subtask.id">
            <Component :is="task.subtaskForm == index ? SubTaskForm : SubTask" :index="index" :id="subtask.id" :subtask="subtask.title" :is-completed="subtask.completed_at"/>
          </template>
        </div>

        <button class="flex items-center group" :class="{ 'mt-6': task.data.tasks.length > 0 }" @click="task.newSubtaskForm = true" v-if="!task.newSubtaskForm">
          <svg class="h-4 w-4 text-gray-600 group-hover:text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          <span class="pl-2 text-sm text-gray-600 group-hover:text-gray-800">Add sub-task</span>
        </button>

        <SubTaskForm :class="{ 'mt-6': task.data.tasks.length > 0 }" v-if="task.newSubtaskForm"/>
      </div>
    </Collapsible>
  </section>
</template>

<script setup>
  import { useTaskStore } from 'Store/task'
  import Collapsible from 'Component/Collapsible.vue'
  import SubTask from './SubTask.vue'
  import SubTaskForm from './SubTaskForm.vue'
  import { ChevronRightIcon } from '@heroicons/vue/outline'

  const task = useTaskStore()

  function countSubTasks() {
    return task.data.tasks.filter(x => x.completed_at).length + '/' + task.data.tasks.length
  }
</script>
