<template>
  <v-dropdown name="header-recent">
    <template #trigger>
      <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
        <span>{{ __('Recent') }}</span>

        <div class="ltr:ml-1 rtl:mr-1">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </div>
      </button>
    </template>

    <div class="origin-top-left absolute ltr:left-0 rtl:right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <p class="px-4 py-4 text-sm text-gray-700" v-show="!projects.length">{{ __('There are no data') }}</p>

      <div class="py-1" role="none" v-show="projects.length">
        <template v-for="project in projects" :key="project.name">
          <router-link class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" :to="'/projects/'+project.project_id" v-slot="{ href, navigate }">
            <span class="block w-2 h-2 rounded-full" :style="{ 'background-color': project.project.meta.color }">&nbsp;</span>
            <span class="flex-1 ltr:ml-2 rtl:mr-2 font-medium">{{ project.project.name }}</span>
          </router-link>
        </template>
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
  import { ref } from 'vue'
  import VDropdown from 'Component/Dropdown.vue'

  const projects = ref([])

  axios.get('recent-projects')
    .then(data => {
      console.log(data)
      projects.value = data
    })
</script>
