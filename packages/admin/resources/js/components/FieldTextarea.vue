<template>
  <v-field-base v-bind="$props">
    <textarea
      :id="formName + '-' + name"
      :placeholder="placeholder || label"
      :rows="rows"
      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
      :class="{ 'border-red-600': form.errors[name] }"
      v-model="form.data[name]"
    ></textarea>
  </v-field-base>
</template>

<script lang="ts">
  import autosize from 'autosize'
  import { inject, onMounted } from 'vue'
  import { useFormStore } from 'Store/form'

  export default {
    props: {
      label: String,
      name: String,
      placeholder: String,
      rows: {
        default: 5,
      },
      inline: Boolean,
      lg: Boolean,
      full: Boolean,
    },

    setup(props) {
      const formName = inject('form_name')
      const form = useFormStore(formName)()

      onMounted(() => {
        autosize(document.querySelectorAll('textarea'))
      })

      return { form, formName }
    }
  }
</script>
