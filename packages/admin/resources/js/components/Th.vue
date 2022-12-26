<template>
  <th
    class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
    :class="{ 'cursor-pointer': sort, 'text-center': align == 'center', 'ltr:text-left rtl:text-right': align != 'center' }"
    @click="index.sort(sort)"
  >
    <span class="inline-flex items-center">
      {{ label }}

      <svg xmlns="http://www.w3.org/2000/svg" width="7" viewBox="0 0 8 14" class="ltr:ml-2 rtl:mr-2 text-gray-400 flex-shrink-0" v-if="sort">
        <path
          class="fill-current"
          :class="{ 'text-gray-600': index.params.orderByDirection == 'asc' && index.params.orderBy == sort }"
          d="M1.70710678 4.70710678c-.39052429.39052429-1.02368927.39052429-1.41421356 0-.3905243-.39052429-.3905243-1.02368927 0-1.41421356l3-3c.39052429-.3905243 1.02368927-.3905243 1.41421356 0l3 3c.39052429.39052429.39052429 1.02368927 0 1.41421356-.39052429.39052429-1.02368927.39052429-1.41421356 0L4 2.41421356 1.70710678 4.70710678z"
        ></path>

        <path
          class="fill-current"
          :class="{ 'text-gray-600': index.params.orderByDirection == 'desc' && index.params.orderBy == sort }"
          d="M6.29289322 9.29289322c.39052429-.39052429 1.02368927-.39052429 1.41421356 0 .39052429.39052429.39052429 1.02368928 0 1.41421358l-3 3c-.39052429.3905243-1.02368927.3905243-1.41421356 0l-3-3c-.3905243-.3905243-.3905243-1.02368929 0-1.41421358.3905243-.39052429 1.02368927-.39052429 1.41421356 0L4 11.5857864l2.29289322-2.29289318z"
        ></path>
      </svg>
    </span>
  </th>
</template>

<script>
  // import { useIndexStore } from 'Store/index'

  export default {
    props: {
      index: Object,
      sort: String,
      label: String,
      align: {
        type: String,
        default: 'left'
      },
    },

    // setup(props) {
    //   const index = useIndexStore(props.name)()

    //   return { index }
    // }
  }
</script>
