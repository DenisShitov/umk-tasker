import { defineStore } from 'pinia'
import { useRoute } from 'vue-router'

export const useDetailStore = function (name) {
  return defineStore({
    id: 'detail-' + name,

    state: () => ({
      loading: false,
      uri: false,
      query: null,
      data: {},
    }),

    actions: {
      setConfig({uri, query}) {
        this.uri = uri
        this.query = Object.keys(query).map(key => key + '=' + query[key]).join('&')
      },

      fetch(payload) {
        this.loading = payload ? payload.loading : true

        const id = payload ? payload.id : useRoute().params.id

        axios.get(this.uri + '/' + id + '?' + this.query)
          .then(data => {
            this.loading = false
            this.data = data
          })
      },
    }
  })
}
