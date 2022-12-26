<template>
  <section class="py-3.5">
    <div class="flex items-center px-2">
      <h2 class="text-gray-600 text-sm font-medium">{{ __('Assignee') }}</h2>

      <TaskAssign class="ml-auto"/>
    </div>

    <div class="flex flex-wrap pt-2 px-2" v-if="task.data.users.length">
      <UserAvatar
        data-cooltipz-dir="top"
        :aria-label="user.name"
        class="w-6 h-6 border-2 border-white mr-1 mb-1"
        :user="user"
        v-for="user in task.data.users"
        :key="user.id"
      />
    </div>
  </section>
</template>

<script setup>
  import UserAvatar from 'Component/UserAvatar.vue'
  import { useTaskStore } from 'Store/task'
  import TaskAssign from './TaskAssign.vue'

  const task = useTaskStore()
</script>
