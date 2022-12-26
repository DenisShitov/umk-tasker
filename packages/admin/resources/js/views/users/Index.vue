<template>
  <div class="flex justify-center mt-8" v-if="processing">
    <v-loader size="40" color="#5850ec"/>
  </div>

  <div v-else>
    <section class="mb-8" v-if="indexInvitation.data.data.length">
      <v-topbar :title="__('Pending Invitations')">
        <v-button class="ltr:ml-auto rtl:mr-auto" size="sm" data-cy="topbar-create-button" @click="openInvitationModal" v-if="can('user:create')">
          {{ __('Invite Team Member') }}
        </v-button>
      </v-topbar>

      <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr>
                    <v-th :index="indexInvitation" :label="__('Email')" sort="email"/>
                    <v-th :index="indexInvitation" :label="__('Role')"/>
                    <th class="px-6 py-3 bg-gray-50"></th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="item in indexInvitation.data.data" :key="item.id">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                      {{ item.email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                      {{ item.role.name }}
                    </td>

                    <td class="flex items-center justify-end px-6 py-4 whitespace-nowrap text-right text-sm leading-5 font-medium">
                      <TrashIcon class="w-5 cursor-pointer text-gray-400 hover:text-gray-800 ml-2" @click.prevent="indexInvitation.delete(item.id)" v-if="can('user:delete')"/>
                    </td>
                  </tr>
                </tbody>
              </table>

              <v-index-pagination :index="indexInvitation"/>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <v-topbar :title="__('Team Members')">
        <v-button class="ltr:ml-auto rtl:mr-auto" size="sm" data-cy="topbar-create-button" @click="openInvitationModal" v-if="can('user:create') && !indexInvitation.data.data.length">
          {{ __('Invite Team Member') }}
        </v-button>
      </v-topbar>

      <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr>
                    <v-th :index="indexUser" :label="__('Name')" sort="name"/>
                    <v-th :index="indexUser" :label="__('Role')"/>
                    <th class="px-6 py-3 bg-gray-50"></th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="item in indexUser.data.data" :key="item.id">
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

                      <TrashIcon class="w-5 cursor-pointer text-gray-400 hover:text-gray-800 ml-2" @click.prevent="indexUser.delete(item.id)" v-if="can('user:delete')"/>
                    </td>
                  </tr>
                </tbody>
              </table>

              <v-index-pagination :index="indexUser"/>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
  import { ref, markRaw } from 'vue'
  import { useModalStore } from 'Store/modal'
  import { useIndexStore } from 'Store/index'
  import UserAvatar from 'Component/UserAvatar.vue'
  import Form from './Form.vue'
  import InvitationForm from './InvitationForm.vue'
  import { PencilAltIcon, TrashIcon } from '@heroicons/vue/outline'

  const indexUser = useIndexStore('user')(),
    indexInvitation = useIndexStore('invitation')(),
    processing = ref(true),
    invitations = ref([])

  checkProcessing()

  indexUser.setConfig({
    'name': 'user',
    'uri': 'users',
    'orderByDirection': 'desc'
  })
  indexUser.fetch()

  indexInvitation.setConfig({
    'name': 'invitation',
    'uri': 'invitations',
    'orderByDirection': 'desc'
  })
  indexInvitation.fetch()

  function checkProcessing() {
    setTimeout(function () {
      if (indexUser.loading || indexInvitation.loading) {
        checkProcessing()
        return
      }

      renderData()
    }, 150)
  }

  function renderData() {
    console.log('renderData')
    processing.value = false
  }

  function openInvitationModal(id = null) {
    useModalStore().show(markRaw(InvitationForm), id)
  }

  function openModal(id = null) {
    useModalStore().show(markRaw(Form), id)
  }
</script>
