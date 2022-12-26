<template>
  <div class="px-6 pt-6" v-if="!form.loading">
    <h1 class="text-xl font-semibold text-gray-900" data-cy="page-title">{{ form.id ? __('Edit Role') : __('Create Role') }}</h1>
  </div>

  <v-form-modal
    :id="id"
    name="role"
    uri="roles"
    :title="__('Role')"
  >
    <div class="grid sm:grid-cols-12 gap-6 pt-3 pb-6">
      <v-field-text class="col-span-12" full name="name" :label="__('Name')"/>

      <div class="col-span-12">
        <div class="flex items-center text-sm mb-4">
          <p class="block text-sm font-medium text-gray-700">
            {{ __('Permissions') }}
          </p>
          <span @click="select" class="block pl-4 text-gray-700 hover:text-gray-900 cursor-pointer text-xs">{{ __('Select All') }}</span>
          <span class="block text-xs text-gray-700 px-1">/</span>
          <span @click="deselect" class="block text-gray-700 hover:text-gray-900 cursor-pointer text-xs">{{ __('Deselect All') }}</span>
        </div>
        <v-field-checkbox class="col-span-12" name="permissions"/>
      </div>
    </div>
  </v-form-modal>
</template>

<script>
  import { useMainStore } from 'Store/main'
  import { useFormStore } from 'Store/form'
  import { useIndexStore } from 'Store/index'
  import { useModalStore } from 'Store/modal'

  export default {
    props: {
      id: Number
    },

    setup() {
      const store = useMainStore()
      const modal = useModalStore()
      const form = useFormStore('role')()
      const index = useIndexStore('role')()

      form.onSuccess = function ({model}) {
        index.fetch()
        form.cancel()
      }

      function select() {
        form.data.permissions = form.options.permissions.map(x => x.value)
      }

      function deselect() {
        form.data.permissions = []
      }

      return { store, form, select, deselect }
    }
  }
</script>
