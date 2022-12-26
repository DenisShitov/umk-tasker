<template>
  <section class="mt-8">
    <Collapsible open>
      <template #trigger="{ open }">
        <div class="flex items-center pl-3 cursor-pointer">
          <svg viewBox="0 0 16 16" class="w-4 h-4 text-gray-500" :class="{'rotate-[270deg]': !open}"><path d="M14 5.758L13.156 5 7.992 9.506l-.55-.48.002.002-4.588-4.003L2 5.77 7.992 11 14 5.758" fill="currentColor"></path></svg>

          <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Favorites') }}</h3>
        </div>
      </template>

      <div class="mt-2.5">
        <template v-for="item in favorite.items" :key="item.project.name">
          <RouterLink :to="`/projects/${item.project.id}`" custom v-slot="{ navigate, href, route }">
            <a :href="href" @click="navigate" :class="[isActive(route.path) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center pl-3 pr-2 py-2 text-sm font-medium rounded-md']">
              <span class="ltr:ml-1 rtl:mr-1 w-2.5 h-2.5 ltr:mr-4 rtl:ml-4 rounded-full" aria-hidden="true" :style="{ 'background-color': item.project.meta.color }"></span>
              <span class="truncate flex-1">{{ item.project.name }}</span>
            </a>
          </RouterLink>
        </template>
      </div>
    </Collapsible>
  </section>
</template>

<script setup>
  import { computed } from 'vue'
  import { useRouter } from 'vue-router'
  import { useFavoriteStore } from 'Store/favorite'
  import Collapsible from 'Component/Collapsible.vue'

  const router = useRouter(),
        path = computed(() => router.currentRoute.value.path),
        favorite = useFavoriteStore()

  favorite.fetch()

  function isActive(href) {
    return path.value.startsWith(href)
  }
</script>
