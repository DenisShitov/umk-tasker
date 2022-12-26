<template>
  <div class="flex justify-between border-b border-gray-200 last:border-b-0 h-14 items-center">
    <label class="text-sm font-medium leading-5 text-gray-700">
      {{ label }}
    </label>

    <div class="flex">
      <label class="ml-2" :key="option" v-for="option in options">
        <input class="hidden" type="radio" :value="option" v-model="form.data[name]"/>
        <span
          class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5"
          :class="{
            'bg-gray-100 hover:bg-gray-200 text-gray-800 cursor-pointer': form.data[name] != option,
            'bg-green-100 text-green-800': form.data[name] == option
          }"
        >
        {{ __(option) }}
        </span>
      </label>
    </div>
  </div>
</template>

<script lang="ts">
  import { inject } from 'vue'
  import { useFormStore } from 'Store/form'

  export default {
    props: {
      label: String,
      name: String,
      required: Boolean,
      defaultValue: String,
    },

    setup({name, required, defaultValue}) {
      const formName = inject('form_name')
      const form = useFormStore(formName)()
      let options = ['Required', 'Optional', 'Disabled']

      if (required) {
        options = ['Required']
        form.data[name] = 'Required'
      }

      if (defaultValue && !form.data[name]) {
        form.data[name] = defaultValue
      } else if (!form.data[name]) {
        form.data[name] = 'Optional'
      }

      return { form, formName, options }
    }
  }
</script>
