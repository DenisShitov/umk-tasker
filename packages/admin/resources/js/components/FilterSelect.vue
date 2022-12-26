<template>
  <h3 class="bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider p-3">{{ __(filter.name) }}</h3>

  <div class="p-2">
    <select class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="index.params[filter.attribute]" @change="onChange">
      <option value="">—</option>
      <option v-for="(option, index) in filter.options" :key="index" :value="option.value">
        {{ __(option.name) }}
      </option>
    </select>
  </div>
</template>

<script>
  import { useIndexStore } from 'Store/index'

  export default {
    props: {
      name: String,
      filter: Object
    },

    setup({name, filter}) {
      const index = useIndexStore(name)()

      function onChange() {
        index.setAppliedFilter(filter)
        index.fetch()
      }

      return {
        index,
        onChange
      }
    }
  }
</script>
