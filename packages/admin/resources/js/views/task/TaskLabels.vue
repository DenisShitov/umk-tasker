<template>
  <section class="py-3.5">
    <div class="flex items-center px-2">
      <h2 class="text-gray-600 text-sm font-medium">{{ __('Labels') }}</h2>

      <TaskLabelsDropdown class="ml-auto"/>
    </div>

    <div class="flex flex-wrap pt-2 px-2" v-if="task.data.labels.length">
      <span
        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ltr:mr-2 rtl:ml-2 mb-2 text-white"
        :style="{'background-color': label.meta.color}"
        v-for="label in task.data.labels"
        :key="label.id"
      >
        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-white" fill="currentColor" viewBox="0 0 8 8">
          <circle cx="4" cy="4" r="3" />
        </svg>
        {{ label.name }}
      </span>
    </div>
  </section>
</template>

<script setup>
  import { useTaskStore } from 'Store/task'
  import UserAvatar from 'Component/UserAvatar.vue'
  import TaskLabelsDropdown from './TaskLabelsDropdown.vue'

  const task = useTaskStore()
</script>
