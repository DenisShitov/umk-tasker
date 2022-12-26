<template>
  <v-field-base :inline="inline" :label="label" :name="name" :lg="lg" :full="full">
    <div class="grid gap-3" style="grid-template-columns: repeat(auto-fill, minmax(16px, 1fr));">
      <div class="flex items-center" v-for="option in form.options[name]">
        <span :class="{ 'ring-2': form.data[name] == option.value }" class="ring-offset-2 w-4 h-4 rounded cursor-pointer" :style="{ backgroundColor: option.label, '--tw-ring-color': option.label }" @click="onClick(option.value)">
          &nbsp;
        </span>
      </div>
    </div>
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

      function onClick(value) {
        console.log('onClick')
        form.data[props.name] = value
      }

      return { form, formName, onClick }
    }
  }
</script>

<style scoped>
  .auto-fill-cols {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    grid-gap: 10px;
  }
</style>
