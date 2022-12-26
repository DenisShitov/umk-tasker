<template>
  <h2 class="text-gray-600 text-sm font-medium mt-5 px-2">Priority</h2>

  <div class="flex items-center mt-2 px-2 py-1" v-if="!can('task:update')">
    <FlagIcon class="w-4 h-4 text-gray-500" :style="{ color: task.data.priority ? task.data.priority.color : '#6b7280' }"/>

    <span class="block leading-none ltr:ml-1.5 rtl:mr-1.5 text-xs text-gray-600">
      {{ task.data.priority ? __(task.data.priority.name) : __('No priority') }}
    </span>
  </div>

  <v-dropdown name="task-priority" :modal="true" v-else>
    <template #trigger>
      <div class="group flex items-center cursor-pointer hover:bg-gray-200 px-2 py-1.5 mt-2 rounded-md">
        <FlagIcon class="w-4 h-4 text-gray-500" :style="{ color: task.data.priority ? task.data.priority.color : '#6b7280' }"/>

        <span class="block leading-none ltr:ml-1.5 rtl:mr-1.5 text-xs text-gray-600">{{ task.data.priority ? __(task.data.priority.name) : __('No priority') }}</span>

        <svg class="hidden group-hover:block w-3.5 h-3.5 text-gray-500 cursor-pointer ml-auto" viewBox="0 0 16 16"><path d="M14 5.758L13.156 5 7.992 9.506l-.55-.48.002.002-4.588-4.003L2 5.77 7.992 11 14 5.758" fill="currentColor"></path></svg>
      </div>
    </template>

    <div class="ltr:origin-top-left rtl:origin-top-right absolute ltr:left-0 rtl:right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <span v-for="option in task.options.priority" class="block px-4 py-2 cursor-pointer text-xs hover:bg-gray-200 text-gray-600" @click="choose(option)">{{ __(option.name) }}</span>
    </div>
  </v-dropdown>
</template>

<script setup>
  import VDropdown from 'Component/Dropdown.vue'
  import { FlagIcon } from '@heroicons/vue/outline'
  import { useTaskStore } from 'Store/task'
  import { useDetailStore } from 'Store/detail'

  const task = useTaskStore()
  const projectDetail = useDetailStore('project')()

  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }

  function choose(option) {
    task.data.priority = {
      name: option.name,
      color: option.color,
    }

    axios.patch('tasks/' + task.data.id + '/priority', {
      priority: option.id
    })
      .then(data => {
        console.log(data)
        updateProjectDetail()
      })
  }
</script>
