<template>
  <v-field-base v-bind="$props">
    <div class="py-4 flex" v-for="item in form.options[name]">
      <p class="text-sm font-medium text-gray-900">{{ item.name }}</p>
      <div class="ml-auto">
        edit
        delete
      </div>
    </div>
    <v-button>Add Stage</v-button>
  </v-field-base>
</template>

<script lang="ts">
  import { inject } from 'vue'
  import { useFormStore } from 'Store/form'

  export default {
    props: {
      label: String,
      name: String,
      placeholder: String,
      inline: Boolean,
      lg: Boolean,
      full: Boolean,
      valueKey: {
        type: String,
        default: 'value'
      }
    },

    setup(props) {
      const formName = inject('form_name')
      const form = useFormStore(formName)()

      return { form, formName }
    }
  }
</script>
