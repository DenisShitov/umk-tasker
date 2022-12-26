<template>
  <Menu as="div" class="relative inline-block ltr:ml-auto rtl:mr-auto">
    <div>
      <MenuButton class="flex items-center text-gray-600 hover:text-gray-700 focus:outline-none">
        <span class="sr-only">Project actions menu</span>
        <DotsVerticalIcon class="h-4 w-4" aria-hidden="true" />
      </MenuButton>
    </div>

    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
      <MenuItems class="ltr:origin-top-right rtl:origin-top-left absolute ltr:right-0 rtl:left-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-[600]">
        <div class="py-1">
          <MenuItem>
            <a
              href="#"
              class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
              @click.prevent="favorite"
            >
              {{ isFavoriteProject ? __('Remove favorite') : __('Add to favorite') }}
            </a>
          </MenuItem>
          <MenuItem v-if="can('project:update')">
            <a
              href="#"
              class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
              @click.prevent="openModal"
            >
              {{ __('Edit') }}
            </a>
          </MenuItem>
          <MenuItem v-if="can('project:delete')">
            <a
              href="#"
              class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
              @click.prevent="archive"
            >
              {{ __('Archive') }}
            </a>
          </MenuItem>
        </div>
      </MenuItems>
    </transition>
  </Menu>
</template>

<script setup>
  import { markRaw, ref } from 'vue'
  import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
  import { DotsVerticalIcon } from '@heroicons/vue/solid'
  import { useModalStore } from 'Store/modal'
  import Form from './Form.vue'
  import { useConfirmStore } from 'Store/confirm'
  import { useFlashStore } from 'Store/flash'
  import { useFavoriteStore } from 'Store/favorite'

  const props = defineProps({
    projectId: Number,
    isFavorite: '',
  })

  const isFavoriteProject = ref(props.isFavorite)

  function openModal(id = null) {
    useModalStore().show(markRaw(Form), props.projectId)
  }

  function favorite() {
    axios.patch('/projects/'+props.projectId+'/favorite')
      .then(data => {
        console.log(data)
        useFlashStore().flash(data.message)
        useFavoriteStore().items = data.favorites.favorites
        isFavoriteProject.value = data.favorite
      })
  }

  function archive() {
    axios.patch(`projects/${props.projectId}/archive`)
      .then(data => {
        useFlashStore().flash(data.message)
        window.location.href = '/'
      })
  }
</script>
