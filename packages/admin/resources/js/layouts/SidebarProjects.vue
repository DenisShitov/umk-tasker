<template>
  <section class="mt-8">
    <Collapsible open>
      <template #trigger="{ open }">
        <div class="flex items-center pl-3 cursor-pointer">
          <svg viewBox="0 0 16 16" class="w-4 h-4 text-gray-500" :class="{'rotate-[270deg]': !open}"><path d="M14 5.758L13.156 5 7.992 9.506l-.55-.48.002.002-4.588-4.003L2 5.77 7.992 11 14 5.758" fill="currentColor"></path></svg>

          <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Projects') }}</h3>

          <span
            data-cy="create-project-button-sidebar"
            class="flex items-center justify-center ml-auto mr-2 text-gray-500 hover:bg-gray-700 hover:text-gray-300 rounded 1bg-blue-400 w-6 h-6"
            @click.stop="create"
          >
            <PlusIcon class="h-4 w-4"/>
          </span>
        </div>
      </template>

      <div class="mt-2.5 space-y-1">
        <template v-for="(item, index) in project.items" :key="item.name">
          <router-link :to="`/projects/${item.id}`" custom v-slot="{ navigate, href, route }">
            <a :href="href" @click="navigate" :class="[isActive(route.path) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center px-3 py-2 text-sm font-medium rounded-md']">
              <span class="ltr:ml-1 rtl:mr-1 w-2.5 h-2.5 ltr:mr-4 rtl:ml-4 rounded-full" aria-hidden="true" :style="{ 'background-color': item.meta.color }"></span>
              <span class="truncate flex-1">{{ item.name }}</span>

              <SidebarProjectMenu
                :id="item.id"
                :index="index"
                :is-favorite="item.is_favorite"
                class="group-hover:block"
                :class="{ 'hidden': currentIndex != index }"
                @toggleMenu="onToggle"
              />
            </a>
          </router-link>
        </template>
      </div>
    </Collapsible>
  </section>
</template>

<script setup>
  import { ref, markRaw, computed } from 'vue'
  import { PlusIcon, DotsHorizontalIcon } from '@heroicons/vue/outline'
  import Collapsible from 'Component/Collapsible.vue'
  import { useModalStore } from 'Store/modal'
  import ProjectForm from 'View/projects/Form.vue'
  import { useProjectStore } from 'Store/project'
  import { useRouter } from 'vue-router'
  import SidebarProjectMenu from './SidebarProjectMenu.vue'

  const project = useProjectStore(),
        router = useRouter(),
        path = computed(() => router.currentRoute.value.path),
        currentIndex = ref(null)

  project.fetch()

  function create() {
    useModalStore().show(markRaw(ProjectForm))
  }

  function isActive(href) {
    return path.value.startsWith(href)
  }

  function onToggle(data) {
    if (data.state) {
      currentIndex.value = data.index
    } else if (currentIndex.value == data.index) {
      currentIndex.value = null
    }
  }
</script>
