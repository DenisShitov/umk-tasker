import { app } from '@/app'
import Button from './Button.vue'
import Index from './Index.vue'
import IndexNoData from './IndexNoData.vue'
import IndexPagination from './IndexPagination.vue'
import Loader from './Loader.vue'
import Th from './Th.vue'
import Topbar from './Topbar.vue'
import Card from './Card.vue'
import Form from './Form.vue'
import FormModal from './FormModal.vue'
import FieldBase from './FieldBase.vue'
import FieldTextarea from './FieldTextarea.vue'
import FieldText from './FieldText.vue'
import FieldSelect from './FieldSelect.vue'
import FieldCheckbox from './FieldCheckbox.vue'
import FieldChoose from './FieldChoose.vue'
import FieldRadio from './FieldRadio.vue'
import FieldImage from './FieldImage.vue'
import FieldAvatar from './FieldAvatar.vue'
import FieldDate from './FieldDate.vue'
import FieldCustom from './FieldCustom.vue'
import FieldColor from './FieldColor.vue'
import Detail from './Detail.vue'

// General
app.component('v-card', Card)
// 'dropdown',
app.component('v-loader', Loader)
app.component('v-button', Button)
// 'tooltip',
app.component('v-detail', Detail)
app.component('v-topbar', Topbar)

// Form
app.component('v-form', Form)
app.component('v-form-modal', FormModal)
// 'form-wizard',

// Fields
app.component('v-field-base', FieldBase)
app.component('v-field-choose', FieldChoose)
app.component('v-field-text', FieldText)
app.component('v-field-select', FieldSelect)
app.component('v-field-radio', FieldRadio)
app.component('v-field-checkbox', FieldCheckbox)
app.component('v-field-date', FieldDate)
app.component('v-field-textarea', FieldTextarea)
app.component('v-field-avatar', FieldAvatar)
app.component('v-field-image', FieldImage)
app.component('v-field-custom', FieldCustom)
app.component('v-field-color', FieldColor)

// Index
app.component('v-index', Index)
app.component('v-index-no-data', IndexNoData)
app.component('v-index-pagination', IndexPagination)
app.component('v-th', Th)
