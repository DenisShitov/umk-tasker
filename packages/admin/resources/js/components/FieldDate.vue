<template>
  <v-field-base v-bind="$props">
    <flat-pickr
      :id="formName + '-' + name"
      :placeholder="label"
      v-model="form.data[name]"
      :class="{ 'border-red-600': form.errors[name] }"
      class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
    />
  </v-field-base>
</template>

<script lang="ts">
  import { inject } from 'vue'
  import { useFormStore } from 'Store/form'
  import flatPickr from '@/flatpickr.js'

  export default {
    components: {
      flatPickr
    },

    props: {
      label: String,
      name: String,
      inline: Boolean,
      lg: Boolean,
      full: Boolean,
    },

    setup() {
      const formName = inject('form_name')
      const form = useFormStore(formName)()

      return { form, formName }
    }
  }
</script>
