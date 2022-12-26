<template>
  <v-field-base :inline="inline" :label="label" :name="name" :lg="lg" :full="full">
    <div class="flex flex-wrap">
      <select
        required
        :id="formName + '-' + name"
        :class="[{ 'border-red-600': form.errors[name] }, inputClass]"
        v-model="form.data[name]"
        class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
      >
        <option :value="null" disabled>{{ __('Choose') }} {{ label }}</option>
        <option v-for="option in form.options[name]" :value="option[valueKey]">
          {{ translatable ? __(option[labelKey]) : option[labelKey] }}
        </option>
      </select>

      <slot/>
    </div>
  </v-field-base>
</template>

<script lang="ts">
  import { inject } from 'vue'
  import { useFormStore } from 'Store/form'

  export default {
    props: {
      label: String,
      name: String,
      translatable: Boolean,
      inline: Boolean,
      lg: Boolean,
      full: Boolean,
      inputClass: String,
      labelKey: {
        type: String,
        default: 'label'
      },
      valueKey: {
        type: String,
        default: 'value'
      }
    },

    setup() {
      const formName = inject('form_name')
      const form = useFormStore(formName)()

      return { form, formName }
    }
  }
</script>
