<template>
  <div class="px-6 pt-6" v-if="!form.loading">
    <h1 class="text-xl font-semibold text-gray-900" data-cy="page-title">{{ form.id ? __('Edit Team Member') : __('Invite Team Member') }}</h1>
  </div>

  <v-form-modal
    :id="id"
    name="user"
    uri="users"
    :title="__('Team Member')"
  >
    <div class="grid sm:grid-cols-12 gap-6 pt-3 pb-6">
      <v-field-text class="sm:col-span-12" full name="name" :label="__('Name')"/>
      <v-field-text class="sm:col-span-12" full name="email" :label="__('Email')"/>
      <v-field-text class="sm:col-span-12" full name="password" :label="__('Password')"/>
      <v-field-select class="sm:col-span-12" full name="role" :label="__('Role')"/>
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
      const form = useFormStore('user')()
      const index = useIndexStore('user')()

      console.log(form)
      console.log( form.options )

      form.onSuccess = function ({model}) {
        index.fetch()
        form.cancel()
      }

      return { store, form }
    }
  }
</script>
