<template>
  <v-dropdown name="header-create">
    <template #trigger>
      <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
        <PlusIcon class="w-4 h-4"/>
        <span class="ltr:ml-2 rtl:mr-2">{{ __('Create') }}</span>
      </button>
    </template>

    <div class="origin-top-left absolute ltr:left-0 rtl:right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <div class="py-1" role="none">
        <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" @click.prevent="openProjectModal" v-show="can('project:create')">{{ __('Create Project') }}</a>
        <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" @click.prevent="openInvitationModal" v-show="can('user:create')">{{ __('Invite Team Member') }}</a>
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
  import { markRaw } from 'vue'
  import VDropdown from 'Component/Dropdown.vue'
  import { PlusIcon } from '@heroicons/vue/outline'
  import ProjectForm from 'View/projects/Form.vue'
  import InvitationForm from 'View/users/InvitationForm.vue'
  import { useModalStore } from 'Store/modal'

  function openProjectModal() {
    useModalStore().show(markRaw(ProjectForm))
  }

  function openInvitationModal() {
    useModalStore().show(markRaw(InvitationForm))
  }
</script>
