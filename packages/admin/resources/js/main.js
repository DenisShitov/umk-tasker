import { app } from './app'
import { router } from './router'
import { createPinia } from 'pinia'
import axios from 'Util/axios'
import './components/_Index'
import './plugins/authorization'
import './plugins/translation'
import './tailwind.css'
import './style.css'
import 'flatpickr/dist/flatpickr.css'
import 'cooltipz-css'
import wysiwyg from "vue-wysiwyg";

window.axios = axios
const pinia = createPinia()

app.use(pinia)
app.use(wysiwyg, {})
app.use(router)
app.mount('#app')
