<template>
  <Menu as="div" class="relative inline-block">
    <div>
      <MenuButton class="flex items-center text-gray-600 hover:text-gray-700 focus:outline-none">
        <span class="sr-only">Open options</span>

        <DotsHorizontalIcon class="h-4 w-4" aria-hidden="true" />
      </MenuButton>
    </div>

    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
      <MenuItems class="ltr:origin-top-right rtl:origin-top-left absolute ltr:right-0 rtl:left-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
        <div class="py-1">
          <MenuItem v-if="can('task-list:update')">
            <a
              href="#"
              class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
              @click.prevent="$emit('listEdit')"
            >
              {{ __('Edit') }}
            </a>
          </MenuItem>
          <MenuItem v-if="can('task-list:delete')">
            <a
              href="#"
              class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
              @click.prevent="onDelete"
            >
              {{ __('Delete') }}
            </a>
          </MenuItem>
        </div>
      </MenuItems>
    </transition>
  </Menu>
</template>

<script setup>
  import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
  import { DotsHorizontalIcon } from '@heroicons/vue/solid'
  import { useConfirmStore } from 'Store/confirm'
  import { useFlashStore } from 'Store/flash'
  import { useDetailStore } from 'Store/detail'

  const props = defineProps({
    listId: Number,
    listIndex: Number,
  })

  const detail = useDetailStore('project')()

  function onDelete() {
    useConfirmStore().show({
      title: 'Delete Resource',
      description: 'Are you sure you want to delete this resource?',
      button: 'Delete',
      danger: true,
      onProceed() {
        axios.delete(`lists/${props.listId}`)
          .then(data => {
            useConfirmStore().hide()
            useFlashStore().flash(data.message)
            detail.data.lists.splice(props.listIndex, 1)
          })
          .catch(error => {
            useFlashStore().danger(error.response.data.message)

            useConfirmStore().hide()
          })
      }
    })
  }
</script>
