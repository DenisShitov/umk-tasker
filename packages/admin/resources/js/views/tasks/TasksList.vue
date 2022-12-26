<template>
  <v-index-no-data v-if="!tasks.length" no-create/>

  <v-card v-else>
    <div class="px-6 py-4 border-b border-gray-200">
      <h3 class="text-base leading-6 font-medium text-gray-900">{{ __(title) }}</h3>
    </div>
    <div class="space-y-4 divide-y pb-4">
      <div class="flex items-start pt-4 px-6" v-for="task in tasks" :key="task.id">
        <span
          class="inline-block rounded-full bg-white h-5 w-5 text-white cursor-pointer"
          :class="{ 'opacity-50': processing == task.id, 'bg-blue-400': task.completed_at, 'border border-gray-300': !task.completed_at }"
          @click="taskComplete(task.id)"
        >
          <svg viewBox="0 0 16 16" fill="white"><path d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/></svg>
        </span>

        <div class="ltr:pl-4 rtl:pr-4 -mt-1">
          <span class="block cursor-pointer hover:underline" @click="openModal(task.id)">{{ task.title }}</span>

          <div class="flex space-x-4 rtl:space-x-reverse mt-1.5">
            <div class="flex items-center py-1" v-if="task.due_at">
              <CalendarIcon class="w-4 h-4 text-gray-400"/>
              <span class="ltr:ml-2 rtl:mr-2 text-xs text-gray-500">{{ task.due_at }}</span>
            </div>

            <router-link custom :to="'/projects/'+task.project_id" v-slot="{ href, navigate }">
              <a :href="href" @click="navigate" class="flex items-center text-sm leading-5 text-gray-700 hover:underline transition duration-150 ease-in-out cursor-pointer">
                <span class="block flex-shrink-0 w-2 h-2 rounded-full" :style="{ 'background-color': task.project.meta.color }" aria-hidden="true"></span>
                <span class="ltr:ml-2 rtl:mr-2 text-xs text-gray-500 truncate">{{ task.project.name }}</span>
              </a>
            </router-link>

            <span class="flex items-center cursor-pointer" @click.stop="timer.stop" v-if="task.id == timer.taskId">
              <StopIcon class="w-4 h-4 text-red-500 hover:text-red-800"/>
            </span>
            <span class="flex items-center cursor-pointer" @click.stop="timer.start(task)" v-else>
              <PlayIcon class="w-4 h-4 text-gray-500 hover:text-gray-800"/>
            </span>
          </div>
        </div>

        <div class="ltr:ml-auto rtl:mr-auto">
          <UserAvatar :user="task.users[0]" class="w-6 h-6"/>
        </div>
      </div>
    </div>
  </v-card>
</template>

<script setup>
  import { markRaw, ref } from 'vue'
  import UserAvatar from 'Component/UserAvatar.vue'
  import { CalendarIcon, PlayIcon, StopIcon } from '@heroicons/vue/outline'
  import { useIndexStore } from 'Store/index'
  import TaskModal from 'View/task/TaskModal.vue'
  import { useModalStore } from 'Store/modal'
  import { useTimerStore } from 'Store/timer'

  const props = defineProps({
    title: String,
    tasks: {
      type: Array,
      default: []
    }
  })

  const index = useIndexStore('tasks')()
  const processing = ref(null)
  const timer = useTimerStore()

  function taskComplete(id) {
    processing.value = id

    axios.patch(`tasks/${id}/complete`)
      .then(data => {
        index.fetch()
      })
  }

  function openModal(id) {
    useModalStore().show(markRaw(TaskModal), {id, width: 'max-w-3xl', page: 'tasks'})
  }
</script>
