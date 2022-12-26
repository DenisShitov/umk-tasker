<template>
  <div class="cursor-pointer" @click="play = !play">
    <stop-icon class="text-red-500 hover:text-red-800 w-5" @click="timer.stop" v-if="task.id == timer.taskId"/>
    <play-icon class="text-gray-500 hover:text-gray-800 w-5" @click="timer.start(task)" v-else/>
  </div>
</template>

<script>
  import { ref } from 'vue'
  import { useTimerStore } from 'Store/timer'
  import { PlayIcon, StopIcon } from '@heroicons/vue/outline'

  export default {
    components: {
      PlayIcon,
      StopIcon,
    },

    props: {
      task: Object
    },

    setup() {
      const play = ref(false)
      const timer = useTimerStore()

      return { play, timer }
    }
  }
</script>
