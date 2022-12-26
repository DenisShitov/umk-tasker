<template>
  <v-field-base v-bind="$props">
    <slot></slot>
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
    },

    setup(props) {
      const formName = inject('form_name')
      const form = useFormStore(formName)()

      return { form, formName }
    }
  }
</script>
