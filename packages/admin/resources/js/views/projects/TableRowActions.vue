<template>
  <Menu as="div" class="relative inline-block text-left">
    <div>
      <MenuButton class="flex items-center text-gray-600 hover:text-gray-700 focus:outline-none">
        <span class="sr-only">Open options</span>
        <DotsVerticalIcon class="h-4 w-4 text-gray-500 hover:text-gray-800" aria-hidden="true" />
      </MenuButton>
    </div>

    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
      <MenuItems class="ltr:origin-top-right rtl:origin-top-left absolute ltr:right-0 rtl:left-0 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-[500]">
        <div class="py-1">
          <MenuItem v-if="can('project:update')">
            <span class="ltr:text-left rtl:text-right block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer" @click="openModal(item.id)">{{ __('Edit') }}</span>
          </MenuItem>
          <MenuItem v-if="can('project:create')">
            <span class="ltr:text-left rtl:text-right block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer" @click="duplicate">{{ __('Duplicate') }}</span>
          </MenuItem>
          <MenuItem v-show="!item.archived_at">
            <span class="ltr:text-left rtl:text-right block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer" @click="favorite">{{ item.is_favorite ? __('Remove favorite') : __('Add to favorite') }}</span>
          </MenuItem>
          <MenuItem v-if="can('project:update')">
            <span class="ltr:text-left rtl:text-right block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer" @click="archive">{{ item.archived_at ? __('Restore') : __('Archive') }}</span>
          </MenuItem>
          <MenuItem v-if="can('project:delete')">
            <span class="ltr:text-left rtl:text-right block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer" @click="index.delete(item.id)">{{ __('Delete') }}</span>
          </MenuItem>
        </div>
      </MenuItems>
    </transition>
  </Menu>
</template>

<script setup>
  import { markRaw } from 'vue'
  import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
  import { DotsVerticalIcon } from '@heroicons/vue/solid'
  import { useModalStore } from 'Store/modal'
  import Form from './Form.vue'
  import { useIndexStore } from 'Store/index'
  import { useFlashStore } from 'Store/flash'
  import { useAppStore } from 'Store/app'

  const props = defineProps({
    item: Object
  })

  const index = useIndexStore('project')()

  function openModal(id = null) {
    useModalStore().show(markRaw(Form), id)
  }

  function duplicate() {
    axios.post(`/projects/${props.item.id}/duplicate`)
      .then(data => {
        index.fetch({loading: false})
      })
  }

  function favorite() {
    axios.patch('/projects/'+props.item.id+'/favorite')
      .then(data => {
        useFlashStore().flash(data.message)
        useAppStore().favorites = data.favorites.favorite
        props.item.is_favorite = data.favorite
      })
  }

  function complete() {
    axios.patch('/projects/'+props.item.id+'/complete')
      .then(data => {
        useFlashStore().flash(data.message)
        index.fetch({loading: false})
      })
  }

  function archive() {
    axios.patch('/projects/'+props.item.id+'/archive')
      .then(data => {
        useFlashStore().flash(data.message)
        index.fetch({loading: false})
      })
  }
</script>
