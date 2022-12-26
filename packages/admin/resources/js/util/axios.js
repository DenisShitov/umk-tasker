import axios from 'axios'
import { router } from '@/router'

const instance = axios.create()

instance.defaults.baseURL = Config.prefix ? '/' + Config.prefix + '/api/' : '/api/'
instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

instance.interceptors.response.use(
    ({data}) => data,
    error => {
        const { status } = error.response

        // Show the user a 500 error
        if (status >= 500) {
            //
        }

        // Handle Session Timeouts
        if (status === 401) {
            window.location.href = '/login'
        }

        // Handle Forbidden
        if (status === 403) {
            router.push('/403')
        }

        // Handle Token Timeouts
        if (status === 419) {
            location.reload()
        }

        return Promise.reject(error)
    }
)

export default instance
