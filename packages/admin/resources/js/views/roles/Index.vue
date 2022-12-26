<template>
  <SettingsLayout>
    <template #topbar>
      <v-button class="ml-auto" size="sm" data-cy="topbar-create-button" @click="openModal()" v-if="can('role:create')">{{ __('Create Role') }}</v-button>
    </template>

    <v-index name="role" uri="roles" v-slot="{ items, index }" no-filters no-search>
      <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr>
                    <v-th :index="index" :label="__('Role')"/>
                    <v-th :index="index" :label="__('Permissions')" align="center"/>
                    <th class="px-6 py-3 bg-gray-50"></th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="item in items" :key="item.id">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                      {{ item.name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center">
                      {{ item.permissions_count }}
                    </td>

                    <td class="flex items-center justify-end px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                      <span @click="openModal(item.id)" class="ml-2" v-if="can('role:update')">
                        <PencilAltIcon class="w-5 cursor-pointer text-gray-400 hover:text-gray-800"/>
                      </span>

                      <TrashIcon class="w-5 cursor-pointer text-gray-400 hover:text-gray-800 ml-2" @click.prevent="index.delete(item.id)" v-if="can('role:delete')"/>
                    </td>
                  </tr>
                </tbody>
              </table>

              <v-index-pagination :index="index"/>
            </div>
          </div>
        </div>
      </div>
    </v-index>
  </SettingsLayout>
</template>

<script setup>
  import { markRaw } from 'vue'
  import SettingsLayout from 'View/settings/SettingsLayout.vue'
  import { useModalStore } from 'Store/modal'
  import Form from './Form.vue'
  import { PencilAltIcon, TrashIcon } from '@heroicons/vue/outline'

  function openModal(id = null) {
    useModalStore().show(markRaw(Form), id)
  }
</script>
