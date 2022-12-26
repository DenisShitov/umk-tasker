<template>
  <section class="py-3.5">
    <div class="flex items-center px-2">
      <h2 class="text-gray-600 text-sm font-medium">{{ __('Repeat') }}</h2>

      <span v-if="task.data.recurring_at" class="ml-2" :aria-label="task.data.meta.recurring.phrase" data-cooltipz-dir="bottom">
        <RefreshIcon class="w-3 h-3 text-gray-600"/>
      </span>

      <TaskRepeatDropdown class="ml-auto"/>
    </div>

    <div class="flex items-center pt-3 px-2" v-if="task.data.recurring_at">
      <span aria-label="Next Recurring At" data-cooltipz-dir="bottom">
        <ClockIcon class="w-4 h-4 text-gray-500"/>
      </span>

      <p class="text-xs text-gray-600 ml-2">{{ task.data.recurring_at }}</p>
    </div>
  </section>
</template>

<script setup>
  import { useTaskStore } from 'Store/task'
  import TaskRepeatDropdown from './TaskRepeatDropdown.vue'
  import { RefreshIcon, ClockIcon } from '@heroicons/vue/outline'

  const task = useTaskStore()
</script>
