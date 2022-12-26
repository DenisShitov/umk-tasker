<template>
  <div class="flex items-center" v-if="timer.isTimerRunning">
    <span @click.stop="timer.stop" class="block cursor-pointer">
      <StopIcon class="w-[1.125rem] h-[1.125rem] text-red-600 hover:text-red-800"/>
    </span>

    <p class="w-[4.500rem] text-red-600 text-base ml-2" :aria-label="`${timer.taskTitle} (${timer.projectName})`" data-cooltipz-dir="bottom">
      {{ timer.currentTaskTimer.h.toString().padStart(2, '0') }}:{{ timer.currentTaskTimer.m.toString().padStart(2, '0') }}:{{ timer.currentTaskTimer.s.toString().padStart(2, '0') }}
    </p>
  </div>
</template>

<script setup>
  import { useTimerStore } from 'Store/timer'
  import { StopIcon } from '@heroicons/vue/outline'

  const timer = useTimerStore()

  console.log('header timer')
  console.log(timer)

  function isCurrentUserTask(user_id) {
    return Config.user.id == user_id
  }
</script>
