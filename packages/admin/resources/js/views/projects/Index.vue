<template>
  <v-topbar :title="__('Projects')">
    <v-button class="ltr:ml-auto rtl:mr-auto" size="sm" data-cy="topbar-create-button" @click="openModal" v-if="can('project:create')">{{ __('Create Project') }}</v-button>
  </v-topbar>

  <v-index name="project" uri="projects" v-slot="{ items, index }">
    <div class="shadow border-b border-gray-200 rounded-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <v-th class="rounded-tl-lg" :index="index" :label="__('Name')" sort="name"/>
            <v-th :index="index" :label="__('Members')"/>
            <th class="px-6 py-3 bg-gray-50 rounded-tr-lg"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="item in items" :key="item.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <div class="flex items-center">
                <div class="w-2.5 h-2.5 rounded-full" :style="{ 'background-color': item.color.name }">&nbsp;</div>

                <router-link class="flex-1 truncate text-gray-900 hover:text-gray-600 ltr:pl-3 rtl:pr-3" :to="'/projects/' + item.id">
                  {{ item.name }}
                </router-link>
              </div>
            </td>
            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-500">
              <div class="flex items-center">
                <div class="flex flex-shrink-0 -space-x-1">
                  <UserAvatar
                    v-for="user in item.users.slice(0, 10)"
                    :key="user.id"
                    :user="user"
                    class="max-w-none h-6 w-6 rounded-full ring-2 ring-white"
                    data-cooltipz-dir="top"
                    :aria-label="user.name"
                  />
                </div>

                <span class="flex-shrink-0 text-xs leading-5 font-medium ltr:ml-2 rtl:mr-2" v-show="item.remaining_users">+{{ item.remaining_users }}</span>
              </div>
            </td>
            <td class="px-6 py-3 ltr:text-right rtl:text-left">
              <TableRowActions :item="item"/>
            </td>
          </tr>
        </tbody>
      </table>

      <v-index-pagination class="rounded-b-lg" :index="index"/>
    </div>
  </v-index>
</template>

<script setup>
  import { markRaw } from 'vue'
  import { EyeIcon, PencilAltIcon, TrashIcon } from '@heroicons/vue/outline'
  import { useModalStore } from 'Store/modal'
  import Form from './Form.vue'
  import TableRowActions from './TableRowActions.vue'
  import UserAvatar from 'Component/UserAvatar.vue'

  function openModal(id = null) {
    useModalStore().show(markRaw(Form), id)
  }
</script>
