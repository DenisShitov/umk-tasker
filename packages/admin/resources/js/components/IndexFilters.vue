<template>
  <v-dropdown name="filter" class="ltr:ml-4 rtl:mr-4" close-outside>
    <template #trigger>
      <button class="inline-flex justify-center px-3.5 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md bg-white hover:bg-gray-50 focus:outline-none" :class="{ 'bg-gray-700 hover:bg-gray-700': index.appliedFilters.length }">
        <filter-icon class="w-5" :class="index.appliedFilters.length ? 'text-white' : 'text-gray-400'"/>
        <span v-if="index.appliedFilters.length" class="ml-2 text-white font-bold">{{ index.appliedFilters.length }}</span>
      </button>

<!--       <button
        class="bg-gray-200 flex items-center h-9 rounded px-3 ml-3"
        :class="{ 'bg-primary': false }"
      >
        <v-svg
          name="filter"
          width="20"
          classes=""
        />
        <inline-svg name="filter" :classes="index.appliedFilters.length ? 'text-white' : 'text-gray-600'"/>
          <span v-if="index.appliedFilters.length" class="ml-2 text-white font-bold">{{ index.appliedFilters.length }}</span>
      </button> -->
    </template>

    <div class="overflow-x-hidden overflow-y-auto max-h-80 origin-top-left absolute ltr:left-0 rtl:right-0 mt-2 w-72 rounded-md shadow-lg border border-gray-200 z-30">
      <div class="rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="filters">
        <div
          class="text-gray-600 font-medium text-sm uppercase bg-gray-50 py-2 border-b border-gray-200 cursor-pointer text-center hover:text-gray-400"
          @click="index.resetFilters"
          v-if="index.appliedFilters.length"
        >
          {{ __('Reset Filters') }}
        </div>
        <component
          v-for="(filter, index) in index.filters"
          :is="filter.component"
          :key="filter.name"
          :filter="filter"
          :name="name"
        />
      </div>
    </div>

    <!-- <div class="overflow-x-hidden overflow-y-auto" style="width: 290px; max-height: 350px;">
      <div class="text-gray-700 font-semibold text-sm uppercase bg-gray-200 py-2 border-b border-gray-400 cursor-pointer text-center hover:text-gray-500"
           @click="resetFilters"
           v-if="index.appliedFilters.length"
      >
          Reset Filters
      </div>

      <component v-for="(filter, index) in index.filters"
                 :is="filter.component"
                 :key="index"
                 :filter="filter"
                 :name="name"
      ></component>
    </div> -->
  </v-dropdown>
</template>

<script>
  import VDropdown from 'Component/Dropdown.vue'
  import { useIndexStore } from 'Store/index'
  import FilterSelect from '@/components/FilterSelect.vue'
  import { FilterIcon } from '@heroicons/vue/outline'

  export default {
    components: {
      FilterSelect,
      VDropdown,
      FilterIcon,
    },

    props: {
      name: String
    },

    setup({name}) {
      const index = useIndexStore(name)()

      return { index }
    }
  }
</script>
