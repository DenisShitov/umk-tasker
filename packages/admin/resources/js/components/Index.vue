<template>
  <div class="flex">
    <div class="relative rounded-md shadow-sm w-64 mb-4" v-if="!noSearch">
      <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 ltr:pl-3 rtl:pr-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" x-description="Heroicon name: search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
        </svg>
      </div>
      <input
        type="search"
        :placeholder="__('Search')"
        v-model="index.params.search"
        @input="index.onSearch"
        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full ltr:pl-10 rtl:pr-10 sm:text-sm border-gray-300 rounded-md"
      >
    </div>

    <index-filters :name="name" v-if="!noFilters"/>
  </div>

  <div class="flex justify-center mt-8" v-if="index.loading">
    <v-loader size="40" color="#5850ec"/>
  </div>

  <div :data-cy="name ? 'index-' + name : 'index'" v-else>
    <v-index-no-data v-if="!index.data.data.length" :no-create="noCreate || cannot(`${name}:create`)" :btn-text="btnText" :btn-to="btnTo"/>

    <slot :index="index" :items="index.data.data" v-else/>
  </div>
</template>

<script lang="ts">
  import { useIndexStore } from 'Store/index'
  import IndexFilters from '@/components/IndexFilters.vue'

  export default {
    components: {
      IndexFilters,
    },

    props: {
      uri: String,
      filterUri: String,
      shallowUri: String,
      name: String,
      btnTo: String,
      btnText: String,
      noCreate: Boolean,
      noFilters: Boolean,
      noSearch: Boolean,
      orderByDirection: {
        type: String,
        default: 'desc'
      },
      searchColumn: {
        type: String,
        default: 'name'
      }
    },

    setup(props) {
      const index = useIndexStore(props.name)()

      index.setConfig(props)
      index.fetch()

      if (!props.noFilters)
        index.getFilters()

      return { index }
    }
  }
</script>
