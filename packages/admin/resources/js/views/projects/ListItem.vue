<template>
  <div id="list-item" :data-id="task.id" class="bg-white block rounded shadow-md cursor-pointer px-2.5 py-1 mb-2" @click="openModal(task.id)">
    <div class="flex py-1.5">
      <span
        class="flex-1 block text-sm"
        :class="{ 'text-gray-500 line-through': task.completed_at, 'text-gray-700': !task.completed_at }"
        v-text="task.title"
      ></span>

      <!-- <div v-show="isCurrentUserTask">
        <span @click.stop="timer.stop" v-if="task.id == timer.taskId">
          <StopIcon class="w-4 h-4 text-red-500 hover:text-red-800"/>
        </span>
        <span @click.stop="timer.start(task)" v-else>
          <PlayIcon class="w-4 h-4 text-gray-500 hover:text-gray-800"/>
        </span>
      </div> -->
    </div>

    <div class="flex items-center">
      <div class="flex-1 flex">
        <div class="flex items-center py-1 ltr:mr-2.5 rtl:ml-2.5" v-if="task.recurring_at">
          <span :aria-label="task.meta.recurring.phrase" data-cooltipz-dir="right" data-cooltipz-size="medium">
            <RefreshIcon class="w-4 h-4 text-gray-400"/>
          </span>
        </div>

        <div class="flex items-center py-1 ltr:mr-2.5 rtl:ml-2.5" v-show="task.due_at">
          <CalendarIcon class="w-4 h-4 text-gray-400"/>
          <span class="ltr:ml-1 rtl:mr-1 text-xs text-gray-500" v-text="task.human_due_date"></span>
        </div>

        <div class="flex items-center py-1 ltr:mr-2.5 rtl:ml-2.5" v-show="task.comments.length">
          <ChatIcon class="w-4 h-4 text-gray-400"/>
          <span class="ltr:ml-1 rtl:mr-1 text-xs text-gray-500" v-text="task.comments.length"></span>
        </div>

        <div class="flex items-center py-1 ltr:mr-2.5 rtl:ml-2.5" v-if="task.checklists.length ? task.checklists[0].checklist_items.length : 0">
          <CheckCircleIcon class="w-4 h-4 text-gray-400"/>
          <span class="ltr:ml-0.5 rtl:mr-0.5 text-xs text-gray-500 tracking-widest" v-text="countChecklistItems(task.checklists)"></span>
        </div>
      </div>

      <div class="ltr:ml-auto rtl:mr-auto flex items-center py-1" v-if="task.users.length">
        <span v-show="checkIsCurrentUserTask()"></span>
        <img v-show="task.users[0].avatar" class="rounded-full w-4 h-4" :src="task.users[0].avatar" alt="avatar" :title="task.users[0].name">

        <span v-show="!task.users[0].avatar" :title="task.users[0].name" class="inline-block rounded-full overflow-hidden bg-gray-100 text-gray-300 w-4 h-4">
          <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
        </span>

        <span class="text-gray-600 text-[9px] ltr:ml-px rtl:mr-px" v-show="task.users.length > 1">+{{ task.users.length - 1 }}</span>
      </div>
    </div>

    <div class="flex flex-wrap mt-1" v-if="task.labels.length">
      <span
        class="inline-flex items-center px-1.5 py-1 rounded-md text-[10px] leading-none font-semibold ltr:mr-1 rtl:ml-1 mb-1 text-white"
        :style="{'background-color': label.meta.color}"
        v-for="label in task.labels"
        :key="label.id"
      >
        {{ label.name }}
      </span>
    </div>

    <div class="flex items-center mt-1.5 mb-1.5" v-if="task.id == timer.taskId && timer.isTimerRunning">
      <span @click.stop="timer.stop">
        <StopIcon class="w-[0.875rem] h-[0.875rem] text-red-500 hover:text-red-800"/>
      </span>

      <p class="text-red-600 text-xs ml-1">
        {{ timer.currentTaskTimer.h.toString().padStart(2, '0') }}:{{ timer.currentTaskTimer.m.toString().padStart(2, '0') }}:{{ timer.currentTaskTimer.s.toString().padStart(2, '0') }}
      </p>
    </div>
  </div>
</template>

<script setup>
  import { ref, markRaw } from 'vue'
  import TaskModal from 'View/task/TaskModal.vue'
  import { useModalStore } from 'Store/modal'
  import { useTimerStore } from 'Store/timer'
  import { CalendarIcon, CheckCircleIcon, ChatIcon, PlayIcon, StopIcon, RefreshIcon } from '@heroicons/vue/outline'

  const props = defineProps({
    task: ''
  })

  const processing = ref(false)
  const timer = useTimerStore()
  const isCurrentUserTask = ref(false)

  function taskComplete(id) {
    processing.value = true

    axios.patch(`tasks/${id}/complete`)
      .then(data => {
        processing.value = false
        props.task.completed_at = data.completed_at
      })
  }

  function openModal(id = null) {
    const url = `/projects/${props.task.project_id}/tasks/${id}`
    history.replaceState(history.state, '', url)

    useModalStore().show(markRaw(TaskModal), {id, width: 'max-w-3xl'})
  }

  function countSubTasks(tasks) {
    return tasks.filter(x => x.completed_at != null).length + '/' + tasks.length
  }

  function countChecklistItems(items) {
    return items[0].checklist_items.filter(x => x.completed_at != null).length + '/' + items[0].checklist_items.length
  }

  function handleTimer() {
    console.log('handleTimer!')
  }

  function checkIsCurrentUserTask() {
    if (props.task.users.length) {
      if (props.task.users.find(x => x.id == Config.user.id)) {
        return isCurrentUserTask.value = true
      }
    }

    isCurrentUserTask.value = false
  }

  checkIsCurrentUserTask()
</script>
