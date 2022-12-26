<template>
  <section class="my-8">
    <div class="flex items-center pr-2" v-show="!archive.show">
      <span class="flex-1 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer" @click="archive.fetch">
        {{ __('Archived Projects') }}
      </span>
      <v-loader size="16" color="text-gray-400" v-show="archive.processing"/>
    </div>

    <div class="flex items-center pr-2" v-show="archive.show && !archive.items.length">
      <span class="flex-1 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer" @click="archive.show = false">
        {{ __('No archived projects') }}
      </span>
      <span class="cursor-pointer text-gray-500 hover:text-gray-300" @click="archive.show = false">
        <XIcon class="w-3 h-3"/>
      </span>
    </div>

    <div class="flex items-center" v-show="archive.show && archive.items.length">
      <span class="flex-1 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer" @click="archive.show = false">
        {{ __('Hide Archived') }}
      </span>
    </div>

    <div class="mt-2.5 space-y-1" v-show="archive.show && archive.items.length">
      <div v-for="(item, index) in archive.items" :key="item.name" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
        <span class="ltr:ml-1 rtl:mr-1 w-2.5 h-2.5 ltr:mr-4 rtl:ml-4 rounded-full" aria-hidden="true" :style="{ 'background-color': item.meta.color }"></span>
        <span class="truncate flex-1">{{ item.name }}</span>
        <SidebarProjectArchiveMenu :id="item.id" :index="index" class="hidden group-hover:block"/>
      </div>
    </div>
  </section>
</template>

<script setup>
  import SidebarProjectArchiveMenu from './SidebarProjectArchiveMenu.vue'
  import { useProjectArchiveStore } from 'Store/project-archive'
  import { XIcon, DotsHorizontalIcon } from '@heroicons/vue/outline'

  const archive = useProjectArchiveStore()
</script>
