<template>
  <v-field-base :inline="inline" :label="label" :name="name" :lg="lg" :full="full">
    <div class="grid gap-4" style="grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));">
      <div class="flex items-center" v-for="option in form.options[name]">
        <input :id="formName + '-' + name + option.value" type="radio" :value="option.value" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" v-model="form.data[name]">
        <label :for="formName + '-' + name + option.value" class="ml-3 block text-sm font-medium text-gray-700 whitespace-nowrap">
          {{ option.label }}
        </label>
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

    setup() {
      const formName = inject('form_name')
      const form = useFormStore(formName)()

      return { form, formName }
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
