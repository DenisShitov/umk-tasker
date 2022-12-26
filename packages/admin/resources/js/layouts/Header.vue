<template>
  <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
    <button class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden" @click="main.mobileSidebar = true">
      <span class="sr-only">Open sidebar</span>
      <MenuAlt2Icon class="h-6 w-6" aria-hidden="true" />
    </button>
    <div class="flex-1 px-4 flex justify-between">
      <div class="flex-1 flex items-center px-4">
        <RecentDropdown/>
        <CreateDropdown class="ltr:ml-6 rtl:mr-6" v-if="can('project:create') || can('user:create')"/>
      </div>
      <div class="ltr:ml-4 rtl:mr-4 flex items-center ltr:md:ml-6 rtl:md:mr-6">
        <TimerCurrentUser class="ltr:mr-5 rtl:ml-5"/>
        <TimerDropdown/>
        <NotificationsDropdown class="ltr:ml-5 rtl:mr-5"/>

        <ProfileDropdown class="ltr:ml-5 rtl:mr-5"/>
      </div>
    </div>
  </div>
</template>

<script setup>
  import CreateDropdown from './CreateDropdown.vue'
  import RecentDropdown from './RecentDropdown.vue'
  import ProfileDropdown from './ProfileDropdown.vue'
  import NotificationsDropdown from './NotificationsDropdown.vue'
  import TimerDropdown from './TimerDropdown.vue'
  import TimerCurrentUser from './TimerCurrentUser.vue'
  import { MenuAlt2Icon } from '@heroicons/vue/outline'
  import { useMainStore } from 'Store/main'

  const main = useMainStore()
</script>
