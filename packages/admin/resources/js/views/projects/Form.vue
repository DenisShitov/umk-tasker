<template>
  <div class="px-6 pt-6" v-if="!form.loading">
    <h1 class="text-xl font-semibold text-gray-900" data-cy="page-title">{{ form.id ? __('Edit Project') : __('Create Project') }}</h1>
  </div>

  <v-form-modal
    :id="id"
    name="project"
    uri="projects"
    :title="__('Project')"
  >
    <div class="grid sm:grid-cols-12 gap-6 pt-3 pb-6">
      <v-field-text class="sm:col-span-12" full name="name" :label="__('Name')"/>

      <div class="sm:col-span-12">
        <label class="block text-sm font-medium text-gray-700">{{ __('Color') }}</label>

        <label
          class="inline-block rounded h-6 w-6 cursor-pointer mt-1 ltr:mr-1 rtl:ml-1"
          v-for="option in form.options['color']"
          :style="{ 'background-color': option.value, color: form.data['color'] == option.value ? '#ffffff' : option.value }"
        >
          <svg viewBox="0 0 16 16" fill="currentColor"><path d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/></svg>
          <input v-model="form.data['color']" type="radio" :value="option.value" class="hidden" />
        </label>

        <div class="text-xs leading-normal text-gray-600 italic mt-2 text-red-600" v-if="form.errors['color']">
          {{ form.errors['color'][0] }}
        </div>
      </div>

      <div class="sm:col-span-12">
        <div class="flex items-center text-sm mb-4">
          <p class="block text-sm font-medium text-gray-700">
            {{ __('Team Members') }} ({{ form.data.users.length }})
          </p>

          <div class="flex items-center flex-1 pl-4">
            <span @click="select" class="block text-gray-700 hover:text-gray-900 cursor-pointer text-xs">{{ __('Select All') }}</span>
            <span class="block text-xs text-gray-700 px-1">/</span>
            <span @click="deselect" class="block text-gray-700 hover:text-gray-900 cursor-pointer text-xs">{{ __('Deselect All') }}</span>
          </div>
        </div>

        <div role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200 overflow-y-auto" style="max-height: 228px;">
          <label class="flex items-center px-4 py-3 cursor-pointer" v-for="option in form.options['users']">
            <div class="flex items-start">
              <UserAvatar class="w-6 h-6" :user="option"/>
              <div class="ltr:ml-3 rtl:mr-3 text-sm">
                <span class="block text-sm font-medium text-gray-900 leading-none truncate mb-1">
                  {{ option.name }}
                </span>
                <span class="block text-sm text-gray-500 leading-none truncate">
                  {{ option.email }}
                </span>
              </div>
            </div>
            <div class="ltr:ml-auto rtl:mr-auto">
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
  import { useDetailStore } from 'Store/detail'
  import { PlusIcon } from '@heroicons/vue/outline'
  import UserAvatar from '@/components/UserAvatar.vue'
  import { useProjectStore } from 'Store/project'

  export default {
    props: {
      id: Number
    },

    components: {
      PlusIcon,
      UserAvatar
    },

    setup(props) {
      const store = useMainStore()
      const modal = useModalStore()
      const form = useFormStore('project')()
      const project = useProjectStore()
      const detail = useDetailStore('project')()

      console.log(form)
      console.log( form.options )

      form.onSuccess = function ({model}) {
        if (props.id) {
          let index = project.items.findIndex(x => {
            return x.id == props.id
          })

          project.items[index] = {
            id: model.id,
            name: model.name,
            meta: model.meta,
          }

          detail.data.name = model.name

          console.log('detail')
          console.log(detail.data.name)
        } else {
          project.items.push({
            id: model.id,
            name: model.name,
            meta: model.meta,
          })
        }

        form.cancel()
      }

      function select() {
        form.data.users = form.options.users.map(x => x.id)
      }

      function deselect() {
        form.data.users = []
      }

      return { store, form, select, deselect }
    }
  }
</script>
