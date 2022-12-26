<template>
  <v-dropdown name="header-timer">
    <template #trigger>
      <button class="relative bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none">
        <ClockIcon class="w-6 h-6"/>

        <div class="flex items-center justify-center w-[1.125rem] h-[1.125rem] rounded-full bg-red-600 text-white text-[0.65rem] absolute z-40 -top-0.5 ltr:-right-0.5 rtl:-left-0.5" v-if="timer.timers.length">{{ timer.timers.length > 9 ? '9+' : timer.timers.length }}</div>
      </button>
    </template>

    <div class="origin-top-right absolute ltr:right-0 rtl:left-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <p class="py-4 text-center text-sm text-gray-700" v-if="!timer.timers.length">{{ __('No Timers!') }}</p>

      <div v-else>
        <ul class="divide-y divide-gray-100">
          <li class="text-sm px-4 py-2 hover:bg-gray-100" v-for="time in timer.timers" :key="time.id">
            <h3 class="flex items-start justify-between text-gray-900">
              {{ time.task.title }}
              <TaskItemTimer class="ml-3" :task="time.task" v-if="isCurrentUserTask(time.user_id)"/>
            </h3>
            <h4 class="flex items-center text-xs mt-2 text-gray-600">
              Started at: {{ time.started_at }}
            </h4>
            <div class="flex items-center mt-1.5">
              <router-link
                custom
                :to="'/projects/' + time.task.project.id"
                v-slot="{ href, navigate }"
              >
                <a
                  :href="href"
                  @click="navigate"
                  class="flex items-center text-gray-600 text-xs hover:underline transition ease-in-out duration-150"
                  role="menuitem"
                >
                  <span class="block w-2 h-2 mr-1.5 rounded-full" :style="{ backgroundColor: time.task.project.meta?.color }" aria-hidden="true">&nbsp;</span>
                  {{ time.task.project.name }}
                </a>
              </router-link>

              <span class="px-2">-</span>

              <router-link
                custom
                :to="'/users/' + time.user.id"
                v-slot="{ href, navigate }"
              >
                <a
                  :href="href"
                  @click="navigate"
                  class="flex items-center text-gray-600 text-xs hover:underline transition ease-in-out duration-150"
                  role="menuitem"
                >
                  <UserAvatar class="w-4 h-4 mr-1.5 font-semibold text-[9px]" :user="time.user"/>
                  {{ time.user.name }}
                </a>
              </router-link>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
  import { ref } from 'vue'
  import { useTimerStore } from 'Store/timer'
  import VDropdown from 'Component/Dropdown.vue'
  import { ClockIcon } from '@heroicons/vue/outline'
  import UserAvatar from 'Component/UserAvatar.vue'
  import TaskItemTimer from './TaskItemTimer.vue'

  const timer = useTimerStore()
  timer.fetch()

  function isCurrentUserTask(user_id) {
    return Config.user.id == user_id
  }

  let count = ref()
</script>
