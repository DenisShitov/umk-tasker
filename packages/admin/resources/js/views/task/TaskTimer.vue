<template>
  <section class="pb-3">
    <h2 class="text-gray-600 text-sm font-medium px-2">{{ __('Time') }}</h2>

    <div class="flex items-center px-2 mt-2">
      <div class="pr-4" v-if="isCurrentUserTask">
        <span @click.stop="stopTimer" v-if="task.data.id == timer.taskId">
          <StopIcon class="w-4 h-4 text-red-500 hover:text-red-700 cursor-pointer"/>
        </span>
        <span @click.stop="startTimer" v-else>
          <PlayIcon class="w-4 h-4 text-gray-500 hover:text-gray-700 cursor-pointer"/>
        </span>
      </div>

      <p class="text-gray-600 text-red-500" v-if="task.data.id == timer.taskId">
        {{ timer.currentTaskTimer.h.toString().padStart(2, '0') }}:{{ timer.currentTaskTimer.m.toString().padStart(2, '0') }}:{{ timer.currentTaskTimer.s.toString().padStart(2, '0') }}
      </p>

      <p class="text-gray-600" v-else>
        {{ getTime() }}
      </p>
    </div>
  </section>
</template>

<script setup>
  import { ref } from 'vue'
  import { useTaskStore } from 'Store/task'
  import { useTimerStore } from 'Store/timer'
  import { useDetailStore } from 'Store/detail'
  import { PlayIcon, StopIcon } from '@heroicons/vue/outline'

  const task = useTaskStore()
  const timer = useTimerStore()
  const projectDetail = useDetailStore('project')()
  const isCurrentUserTask = ref(false)
  const isSetTime = ref(false)

  function getTime() {
    if (isSetTime.value) {
      return `${timer.currentTaskTimer.h.toString().padStart(2, '0')}:${timer.currentTaskTimer.m.toString().padStart(2, '0')}:${timer.currentTaskTimer.s.toString().padStart(2, '0')}`
    }

    let seconds = task.data.total_seconds

    let s = Math.floor(seconds % 60)
    let m = Math.floor((seconds % 3600) / 60)
    let h = Math.floor(seconds / 3600)

    return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`
  }

  function startTimer() {
    if (!isSetTime.value) {
      timer.setTimer(task.data.total_seconds)
      isSetTime.value = true
    }

    setTimeout(function () {
      timer.start(task.data)
    })
  }

  function stopTimer() {
    timer.stop()
  }

  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }

  function checkIsCurrentUserTask() {
    if (task.data.users.length) {
      if (task.data.users.find(x => x.id == Config.user.id)) {
        return isCurrentUserTask.value = true
      }
    }

    isCurrentUserTask.value = false
  }

  checkIsCurrentUserTask()
</script>
