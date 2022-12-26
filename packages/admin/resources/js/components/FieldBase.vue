<template>
  <div
    :class="{ 'grid sm:grid-cols-3 border-b border-gray-200 last:border-b-0 py-5': inline, 'grid-rows-field': !inline }"
  >
    <label
      :for="formName + '-' + name"
      class="block text-sm font-medium text-gray-700"
      :class="{ 'sm:mt-px sm:pt-2': inline }"
      v-if="label"
    >
      {{ label }}
    </label>
    <div class="sm:col-span-2" :class="{ 'mt-1': !inline }">
      <slot/>
      <div
        class="text-xs leading-normal text-gray-600 italic mt-2 text-red-600"
        v-if="form.errors[name]"
      >
        {{ form.errors[name][0] }}
      </div>
      <p class="mt-2 text-sm text-gray-500" v-html="__(info, infoParams)" v-if="info"></p>
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
      info: String,
      infoParams: Object,
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
