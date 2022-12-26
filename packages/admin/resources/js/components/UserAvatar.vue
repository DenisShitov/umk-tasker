<template>
  <span v-if="user.avatar" class="block rounded-full">
    <img :src="user.avatar" class="w-full h-full rounded-full">
  </span>

  <span :title="user.name" class="inline-block rounded-full bg-gray-100 text-gray-300" v-else>
    <svg class="rounded-full" fill="currentColor" viewBox="0 0 24 24">
      <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
  </span>
</template>

<script setup>
  const props = defineProps({
    user: Object
  })
</script>
