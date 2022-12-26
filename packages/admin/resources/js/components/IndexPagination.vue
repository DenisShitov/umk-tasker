<template>
  <nav class="bg-white py-3 flex items-center justify-between" :class="[classes]" aria-label="Pagination">
    <div class="hidden sm:block">
      <p class="text-sm text-gray-700">
        {{ __('Showing') }}
        <span class="font-medium text-gray-600">{{ index.data.from }}</span>
        {{ __('to') }}
        <span class="font-medium text-gray-600">{{ index.data.to }}</span>
      </p>
    </div>
    <div class="flex-1 flex justify-between sm:justify-end" v-if="index.data.next_page_url || index.data.prev_page_url">
      <span
        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 cursor-pointer"
        :class="{ 'pointer-events-none opacity-50': !index.data.prev_page_url }"
        @click="index.prev()"
      >
        {{ __('Previous') }}
      </span>
      <span
        class="ltr:ml-3 rtl:mr-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 cursor-pointer"
        :class="{ 'pointer-events-none opacity-50': !index.data.next_page_url }"
        @click="index.next()"
      >
        {{ __('Next') }}
      </span>
    </div>
  </nav>
</template>

<script>
  export default {
    props: {
      index: Object,
      classes: {
        type: String,
        default: 'px-4 sm:px-6 border-t border-gray-200',
      },
    }
  }
</script>
