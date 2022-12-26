<template>
  <div class="flex justify-center mt-8" v-if="detail.loading">
    <v-loader size="40" color="#5850ec"/>
  </div>

  <slot :model="detail.data" v-else/>
</template>

<script lang="ts">
  import { useDetailStore } from 'Store/detail'

  export default {
    props: {
      uri: String,
      name: String,
      query: {
        default: {},
        type: Object,
      },
    },

    setup(props) {
      const detail = useDetailStore(props.name)()

      detail.setConfig(props)
      detail.fetch()

      return { detail }
    }
  }
</script>
