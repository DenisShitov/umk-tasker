<template>
  <v-field-base :inline="inline" :label="label" :name="name" :lg="lg" :full="full">
    <input
      :type="type"
      :id="formName + '-' + name"
      :placeholder="label"
      :disabled="disabled"
      :class="{ 'border-red-600': form.errors[name], 'sm:max-w-full': full, 'sm:max-w-lg': lg, 'max-w-lg sm:max-w-xs': inline }"
      class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      :value="nested ? form.data[main][sub] : form.data[name]"
      @input="update"
    >
  </v-field-base>
</template>

<script lang="ts">
  import { inject } from 'vue'
  import { useFormStore } from 'Store/form'

  export default {
    props: {
      type: {
        default: 'text'
      },
      label: String,
      name: String,
      inline: Boolean,
      lg: Boolean,
      full: Boolean,
      disabled: Boolean,
    },

    setup(props) {
      const formName = inject('form_name')
      const form = useFormStore(formName)()

      const key = props.name.split('.'),
            nested = key.length == 2,
            main = key[0],
            sub = key[1]

      function update(e) {
        if (nested) {
          form.data[main][sub] = e.target.value
        } else {
          form.data[main] = e.target.value
        }
      }

      return { form, formName, update, nested, main, sub }
    }
  }
</script>
