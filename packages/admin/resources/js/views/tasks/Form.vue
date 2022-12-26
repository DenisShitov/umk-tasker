<template>
  <div class="px-6 pt-6" v-if="!form.loading">
    <h1 class="text-xl font-semibold text-gray-900" data-cy="page-title">{{ form.id ? __('Edit Team') : __('Create Team') }}</h1>
  </div>

  <v-form-modal
    :id="id"
    name="team"
    uri="teams"
    :title="__('Team')"
  >
    <div class="grid sm:grid-cols-12 gap-6 pt-3 pb-6">
      <v-field-text class="sm:col-span-12" full name="name" :label="__('Name')"/>

      <div class="sm:col-span-12">
        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Team Members') }} ({{ form.data.users.length }})</label>

        <div role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200 overflow-y-auto" style="max-height: 228px;">
          <label class="flex items-center px-4 py-3 cursor-pointer" v-for="option in form.options['users']">
            <div class="flex items-start">
              <user-avatar class="w-6 h-6" :user="option"/>
              <div class="ml-3 text-sm">
                <span class="block text-sm font-medium text-gray-900 leading-none truncate mb-1">
                  {{ option.name }}
                </span>
                <span class="block text-sm text-gray-500 leading-none truncate">
                  {{ option.email }}
                </span>
              </div>
            </div>
            <div class="ml-auto">
              <input type="checkbox" :value="option.id" v-model="form.data['users']" class="w-5 h-5 border-gray-300 rounded-full focus:ring-0 focus:outline-none focus:ring-offset-0 cursor-pointer">
            </div>
          </label>
        </div>

        <div class="text-xs leading-normal text-gray-600 italic mt-2 text-red-600" v-if="form.errors['users']">
          {{ form.errors['users'][0] }}
        </div>
      </div>
    </div>
  </v-form-modal>
</template>

<script>
  import { useMainStore } from 'Store/main'
  import { useFormStore } from 'Store/form'
  import { useIndexStore } from 'Store/index'
  import { useModalStore } from 'Store/modal'
  import { PlusIcon } from '@heroicons/vue/outline'
  import UserAvatar from '@/components/UserAvatar.vue'

  export default {
    props: {
      id: Number
    },

    components: {
      PlusIcon,
      UserAvatar
    },

    setup() {
      const store = useMainStore()
      const modal = useModalStore()
      const form = useFormStore('team')()
      const index = useIndexStore('team')()

      console.log(form)
      console.log( form.options )

      form.onSuccess = function ({model}) {
        index.fetch()
        form.cancel()
        // window.location.href = '/admin/teams/' + model.id
      }

      return { store, form }
    }
  }
</script>
