import { router } from '@/router'
import { defineStore } from 'pinia'
import { useFlashStore } from 'Store/flash'
import { useModalStore } from 'Store/modal'

export const useFormStore = function (name) {
    return defineStore({
        id: 'form-' + name,

        state: () => ({
            id: null,
            data: {},
            errors: {},
            options: {},
            getUri: '',
            submitUri: '',
            loading: true,
            processing: false,
            onSubmit: null,
            onSuccess: function () {
                router.push('/' + this.submitUri)
            },
            onFail: null,
            onLoaded: null,
            onCancel: null,
        }),

        getters: {
            isLoaded() {
                return !this.loading
            },
        },

        actions: {
            init(payload) {
                if (typeof payload === 'function') {
                    payload()
                    return
                }

                const { id, uri } = payload

                this.loading = true
                this.reset()

                this.$patch({
                    id,
                    getUri: id ? `${uri}/${id}/edit` : `${uri}/create`,
                    submitUri: id ? `${uri}/${id}` : uri
                })

                this.getFieldsData()
            },

            getFieldsData() {
                axios.get(this.getUri)
                    .then(data => {
                        this.setFieldsData(data)
                        this.loading = false
                        this.hook('onLoaded')
                    })
            },

            setFieldsData(data) {
                for (let i = 0; i < data.length; i++) {
                    const {name, value, options} = data[i]

                    this.data[name] = value
                    this.options[name] = options || []
                }
            },

            reset() {
                this.data = {}
                this.errors = {}
            },

            cancel() {
                this.$reset()
                this.hook('onCancel')
                useModalStore().hide()
            },

            hook(callback, payload = null) {
                if (typeof this[callback] === 'function')
                    this[callback](payload)
            },

            submit() {
                if (typeof this.onSubmit === 'function') {
                    this.onSubmit()
                    return
                }

                const method = this.id ? 'patch' : 'post'

                this.processing = true

                axios[method](this.submitUri, this.data)
                    .then(data => {
                        this.hook('onSuccess', data)
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors
                        }

                        this.processing = false
                        useFlashStore().danger(error.response.data.message)

                        this.hook('onFail')
                    })
            }
        }
    })
}
