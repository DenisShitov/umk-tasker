<template>
  <img :src="`/${logo}`">

  <div class="flex items-center">
    <span class="text-white ltr:ml-2.5 rtl:mr-2.5 font-semibold text-[1.375rem]">ЮМК</span>
  </div>
</template>

<script setup>
  const name = Config.app_name
  const logo = Config.app_logo
</script>
