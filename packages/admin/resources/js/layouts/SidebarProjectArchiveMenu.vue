<template>
  <v-dropdown :name="'sidebar-project-menu-' + id" close-outside>
    <template #trigger>
      <span class="text-gray-400 hover:text-gray-200 cursor-pointer">
        <DotsHorizontalIcon class="w-4 h-4"/>
      </span>
    </template>

    <div class="bottom-6 ltr:origin-bottom-right rtl:origin-bottom-left absolute ltr:right-0 rtl:left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-40" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <div class="py-1" role="none">
        <button class="w-full text-left px-4 py-1.5 text-xs leading-5 font-normal text-gray-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" @click="restore">{{ __('Restore') }}</button>
        <button class="w-full text-left px-4 py-1.5 text-xs leading-5 font-normal text-gray-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" @click="onDelete">{{ __('Delete') }}</button>
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
  import VDropdown from 'Component/Dropdown.vue'
  import { useProjectStore } from 'Store/project'
  import { useProjectArchiveStore } from 'Store/project-archive'
  import { PlusIcon, DotsHorizontalIcon } from '@heroicons/vue/outline'

  const props = defineProps({
    id: Number,
    index: Number,
  })

  const project = useProjectStore()
  const archive = useProjectArchiveStore()

  function restore() {
    axios.patch(`projects/${props.id}/restore`)
      .then(data => {
        console.log('data')
        console.log(data)
        project.items.push(data)
        archive.items.splice(props.index, 1)
      })
  }

  function onDelete() {
    axios.delete(`projects/${props.id}`)
      .then(data => {
        archive.items.splice(props.index, 1)
      })
  }
</script>
