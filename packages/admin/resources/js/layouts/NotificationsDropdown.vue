<template>
  <v-dropdown name="header-notification" @toggle="onOpen">
    <template #trigger>
      <button class="relative bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none" aria-label="Notifications">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <div class="flex items-center justify-center w-[1.125rem] h-[1.125rem] rounded-full bg-red-600 text-white text-[0.65rem] absolute z-40 -top-0.5 ltr:-right-0.5 rtl:-left-0.5" v-if="count">{{ count > 9 ? '9+' : count }}</div>
      </button>
    </template>

    <div class="origin-top-right absolute ltr:right-0 rtl:left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <p class="py-4 text-center text-sm text-gray-700" v-if="!notifications.length">{{ __('No Notifications!') }}</p>

      <div v-else>
        <router-link
          custom
          :to="getUrl(notification)"
          v-slot="{ href, navigate }"
          v-for="notification in notifications"
          :key="notification.id"
        >
          <a
            :href="href"
            @click="navigate"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
            role="menuitem"
          >
            {{ notification.data.message }}
          </a>
        </router-link>
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
  import { ref } from 'vue'
  import VDropdown from 'Component/Dropdown.vue'
  import Echo from 'laravel-echo'
  import Pusher from 'pusher-js'

  let notifications = ref([]),
      count = ref()

  const E = new Echo({
    broadcaster: 'pusher',
    key: Config.PUSHER_APP_KEY,
    cluster: Config.PUSHER_APP_CLUSTER,
    forceTLS: true
  })

  E.private(`App.Models.User.${Config.user.id}`)
    .notification((notification) => {
        console.log('notification')
        console.log(notification)
        count.value = count.value + 1
        notifications.value.push({
          type: notification.type,
          data: {
            'item_id': notification.item_id,
            'project_id': notification.project_id,
            'message': notification.message,
          }
        })
    })


  axios.get('notifications')
    .then(data => {
      console.log(data)
      count.value = data.new
      notifications.value = data.notifications
    })

  function onOpen(payload) {
    if (payload && count.value) {
      axios.post('/notifications/read')
        .then(data => {
          if (data.success)
            count.value = 0
        })
    }
  }

  function getUrl(notification) {
    const types = {
      'App\\Notifications\\ProjectAssigned': '/projects/' + notification.data.item_id,
      'App\\Notifications\\TaskAssigned': '/projects/' + notification.data.project_id,
    }

    return types[notification.type]
  }
</script>
