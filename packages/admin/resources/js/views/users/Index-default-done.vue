<template>
  <div class="flex justify-center mt-8" v-if="processing">
    <v-loader size="40" color="#5850ec"/>
  </div>

  <v-topbar :title="__('Pending Invitations')">
    <v-button class="ltr:ml-auto rtl:mr-auto" size="sm" data-cy="topbar-create-button" @click="openInvitationModal" v-if="can('user:create')">
      {{ __('Invite Team Member') }}
    </v-button>
  </v-topbar>

  <v-index name="invitation" uri="invitations" v-slot="{ items, index }" no-filters no-search>
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <v-th :index="index" :label="__('Name')" sort="name"/>
                  <v-th :index="index" :label="__('Role')"/>
                  <th class="px-6 py-3 bg-gray-50"></th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="item in items" :key="item.id">
                  <td class="px-6 py-4 whitespace-no-wrap text-sm font-medium text-gray-500">
                    <div class="flex">
                      <UserAvatar class="w-6 h-6" :user="item"/>
                      <div class="ltr:ml-3 rtl:mr-3 text-sm">
                        <span class="block text-sm font-medium text-gray-900 leading-none truncate mb-1">
                          {{ item.name }}
                        </span>
                        <span class="block font-normal text-sm text-gray-500">
                          {{ item.email }}
                        </span>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-no-wrap text-sm font-medium text-gray-500">
                    {{ item.role.name }}
                  </td>

                  <td class="flex items-center justify-end px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                    <span @click="openModal(item.id)" class="ml-2" v-if="can('user:update')">
                      <PencilAltIcon class="w-5 cursor-pointer text-gray-400 hover:text-gray-800"/>
                    </span>

                    <TrashIcon class="w-5 cursor-pointer text-gray-400 hover:text-gray-800 ml-2" @click.prevent="index.delete(item.id)" v-if="can('user:delete')"/>
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

  <v-topbar :title="__('Team Members')" class="mt-8"></v-topbar>

  <v-index name="user" uri="users" v-slot="{ items, index }" no-filters no-search>
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <v-th :index="index" :label="__('Name')" sort="name"/>
                  <v-th :index="index" :label="__('Role')"/>
                  <th class="px-6 py-3 bg-gray-50"></th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="item in items" :key="item.id">
                  <td class="px-6 py-4 whitespace-no-wrap text-sm font-medium text-gray-500">
                    <div class="flex">
                      <UserAvatar class="w-6 h-6" :user="item"/>
                      <div class="ltr:ml-3 rtl:mr-3 text-sm">
                        <span class="block text-sm font-medium text-gray-900 leading-none truncate mb-1">
                          {{ item.name }}
                        </span>
                        <span class="block font-normal text-sm text-gray-500">
                          {{ item.email }}
                        </span>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-no-wrap text-sm font-medium text-gray-500">
                    {{ item.roles[0].name }}
                  </td>

                  <td class="flex items-center justify-end px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                    <span @click="openModal(item.id)" class="ml-2" v-if="can('user:update')">
                      <PencilAltIcon class="w-5 cursor-pointer text-gray-400 hover:text-gray-800"/>
                    </span>

                    <TrashIcon class="w-5 cursor-pointer text-gray-400 hover:text-gray-800 ml-2" @click.prevent="index.delete(item.id)" v-if="can('user:delete')"/>
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
</template>

<script setup>
  import { ref, markRaw } from 'vue'
  import { useModalStore } from 'Store/modal'
  import UserAvatar from 'Component/UserAvatar.vue'
  import Form from './Form.vue'
  import InvitationForm from './InvitationForm.vue'
  import { PencilAltIcon, TrashIcon } from '@heroicons/vue/outline'

  const index = useIndexStore('user')(),
    processing = ref(true),
    invitations = ref([])

  function openInvitationModal(id = null) {
    useModalStore().show(markRaw(InvitationForm), id)
  }

  function openModal(id = null) {
    useModalStore().show(markRaw(Form), id)
  }
</script>
