<template>
  <div class="space-y-1">
    <template v-for="item in Nav" :key="item.label">
      <router-link custom :to="item.uri" v-slot="{ href, navigate }" v-if="!item.permission || can(item.permission)">
        <a :href="href" @click="navigate" :class="[isActive(item) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center pl-3 py-2 text-sm font-medium rounded-md']">
          <Component :is="item.icon" :class="[isActive(item) ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300', 'ltr:mr-3 rtl:ml-3 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
          {{ __(item.label) }}

          <span class="ml-auto cursor-pointer w-5 h-5 rounded bg-gray-700 text-white hover:bg-gray-800 group-hover:bg-gray-500 hover:opacity-250 hover:text-gray-300 flex items-center justify-center" @click.prevent="add(item.add)" v-if="item.add && can(item.createPermission)">
            <Component :is="PlusIcon" class="h-3.5 w-3.5"/>
          </span>
        </a>
      </router-link>
    </template>
  </div>
</template>

<script setup>
  import { computed, inject, ref } from 'vue'
  import { Nav } from 'Composable/nav'
  import { useRouter } from 'vue-router'
  import { PlusIcon, CogIcon } from '@heroicons/vue/outline'

  const can = inject('can')
  const settingsUrl = ref('')
  const router = useRouter()
  const path = computed(() => router.currentRoute.value.path)

  getSettingsUrl()

  function isActive(item) {
    if (item.uri === '/' || item.uri == '/projects') {
      return path.value === item.uri
    }

    return path.value.startsWith(item.uri)
  }

  function add(uri) {
    router.push(uri)
  }

  function getSettingsUrl() {
    let settings = {
      'setting:general': '/settings/general',
      'setting:email': '/settings/email',
      'user:view': '/users',
      'team:view': '/teams',
      'role:view': '/roles',
      'setting:updates': '/settings/updates',
    }

    for (const key in settings) {
      if (can(key)) {
        settingsUrl.value = settings[key]
        return
      }
    }
  }
</script>
