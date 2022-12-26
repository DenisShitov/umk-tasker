import debounce from 'lodash/debounce'
import { defineStore } from 'pinia'
import { useFlashStore } from 'Store/flash'
import { useConfirmStore } from 'Store/confirm'

export const useIndexStore = function (name) {
    return defineStore({
        id: 'index-' + name,

        state: () => ({
            name,
            loading: false,
            uri: null,
            filterUri: null,
            shallowUri: null,
            data: {},
            filters: [],
            appliedFilters: [],
            params: {
                page: 1,
                search: null,
                searchColumn: 'name',
                searchNumericColumn: 'id',
                orderBy: 'id',
                orderByDirection: 'desc'
            }
        }),

        actions: {
            setConfig({uri, filterUri, shallowUri, searchColumn, orderByDirection}) {
                this.uri = uri
                this.filterUri = filterUri
                this.shallowUri = shallowUri
                this.params.searchColumn = searchColumn
                this.params.orderByDirection = orderByDirection
            },

            fetch(payload) {
                this.loading = payload ? payload.loading : true

                axios.get(this.uri, {
                    params: this.params
                })
                    .then(data => {
                        this.loading = false
                        this.data = data
                    })
            },

            delete(items = null) {
                const confirm = useConfirmStore(),
                      store = this

                confirm.show({
                    title: 'Delete Resource',
                    description: 'Are you sure you want to delete this resource?',
                    button: 'Delete',
                    danger: true,
                    onProceed() {
                        if (items)
                            items = [items]

                        const uri = store.shallowUri ? store.shallowUri : store.uri

                        axios.delete(`${uri}/null`, {
                            data: { items }
                        })
                            .then(data => {
                                confirm.hide()
                                store.fetch()
                                useFlashStore().flash(data.message)
                            })
                            .catch(error => {
                                useFlashStore().danger(error.response.data.message)

                                confirm.hide()
                            })
                    }
                })
            },

            next() {
                this.params.page++
                this.fetch()
            },

            prev() {
                this.params.page--
                this.fetch()
            },

            onSearch: debounce(function () {
                this.fetch()
            }, 250),

            getFilters() {
                axios.get((this.filterUri || this.uri) + '/filters')
                    .then(data => {
                        this.filters = data
                        for (let i = 0; i < data.length; i++) {
                            this.params[data[i].attribute] = ''
                        }
                    })
            },

            setAppliedFilter({attribute, component, value}) {
                let param = this.params[attribute].toString()

                if (param != value.toString() || component == 'date-filter') {
                    if (this.appliedFilters.indexOf(attribute) === -1) this.appliedFilters.push(attribute)
                }
                else {
                    const index = this.appliedFilters.indexOf(attribute)
                    this.appliedFilters.splice(index, 1)
                }
            },

            resetFilters() {
                for (let i = 0; i < this.filters.length; i++) {
                    let filter = this.filters[i]

                    this.params[filter.attribute] = filter.value
                }

                this.appliedFilters = []

                this.fetch()
            },

            sort(attribute) {
                if (!attribute) return

                let orderBy = this.params.orderBy,
                    direction = this.params.orderByDirection

                if (orderBy == attribute && direction == 'asc') {
                    this.params.orderByDirection = 'desc'
                }
                else if (orderBy == attribute && direction == 'desc') {
                    this.params.orderBy = this.defaultOrderBy
                    this.params.orderByDirection = 'desc'
                }
                else {
                    this.params.orderBy = attribute
                    this.params.orderByDirection = 'asc'
                }

                this.fetch()
            },
        }
    })
}
