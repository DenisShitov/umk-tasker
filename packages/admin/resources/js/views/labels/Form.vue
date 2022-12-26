<template>
  <div class="px-6 pt-6" v-if="!form.loading">
    <h1 class="text-xl font-semibold text-gray-900" data-cy="page-title">{{ form.id ? __('Edit Label') : __('Create Label') }}</h1>
  </div>

  <v-form-modal
    :id="id"
    name="label"
    uri="labels"
    :title="__('Label')"
  >
    <div class="grid sm:grid-cols-12 gap-6 pt-3 pb-6">
      <v-field-text class="col-span-12" full name="name" :label="__('Name')"/>

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
      const form = useFormStore('label')()
      const index = useIndexStore('label')()

      form.onSuccess = function ({model}) {
        index.fetch()
        form.cancel()
      }

      return { store, form }
    }
  }
</script>
