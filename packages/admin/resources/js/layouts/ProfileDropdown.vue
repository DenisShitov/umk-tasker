<template>
  <v-dropdown name="header-profile">
    <template #trigger>
      <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
        <UserAvatar :user="user" class="h-8 w-8"/>

        <div class="ltr:ml-2 rtl:mr-2">{{ user.name }}</div>

        <div class="ltr:ml-1 rtl:mr-1">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </div>
      </button>
    </template>

    <div class="origin-top-right absolute ltr:right-0 rtl:left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <div class="divide-y divide-gray-100">
        <p class="px-4 py-2.5">
          <span class="block text-xs text-gray-500 font-normal">{{ __('Signed in as') }}</span>
          <span class="block text-sm font-normal text-gray-600 truncate mt-0.5" role="none">{{ user.email }}</span>
        </p>

        <div class="py-1" role="none">
          <router-link to="/profile" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('Profile') }}</router-link>
          <router-link to="/settings/general" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('Settings') }}</router-link>

          <form method="POST" action="/logout">
            <input type="hidden" name="_token" :value="csrf_token">

            <a
              href="/logout"
              onclick="event.preventDefault(); this.closest('form').submit();"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
            >
              {{ __('Logout') }}
            </a>
          </form>
        </div>
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
  import VDropdown from 'Component/Dropdown.vue'
  import UserAvatar from 'Component/UserAvatar.vue'

  const user = Config.user
  const csrf_token = Config.csrf_token
</script>
