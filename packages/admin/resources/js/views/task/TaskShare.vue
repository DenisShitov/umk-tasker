<template>
  <section class="py-3.5">
    <div class="flex items-center px-2">
      <h2 class="text-gray-600 text-sm font-medium">{{ __('Share') }}</h2>

      <TaskShareDropdown class="ml-auto"/>
    </div>
  </section>
</template>

<script setup>
  import TaskShareDropdown from './TaskShareDropdown.vue'
</script>
