<template>
  <SettingsLayout>
    <v-form
      name="setting-general"
      uri="settings/general"
      title="General"
      save-only
    >
      <v-field-text name="app_name" :label="__('App Name')" inline/>
      <v-field-text name="app_url" :label="__('App URL')" inline/>
      <v-field-select name="app_locale" :label="__('Language')" translatable input-class="max-w-lg sm:max-w-xs" inline/>
      <v-field-select name="app_timezone" :label="__('Timezone')" input-class="max-w-lg sm:max-w-xs" inline/>
      <v-field-select name="app_direction" :label="__('Direction')" input-class="max-w-lg sm:max-w-xs" inline/>
      <FieldLogo/>

      <div class="grid sm:grid-cols-3 border-b border-gray-200 last:border-b-0 py-5" v-if="config.options.is_standalone_demo">
        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">&nbsp;</label>
        <div class="sm:col-span-2 text-sm text-red-600 py-2">Note: Only language and direction will take effect in this demo!</div>
      </div>
    </v-form>
  </SettingsLayout>
</template>

<script lang="ts">
  import { useFormStore } from 'Store/form'
  import SettingsLayout from './SettingsLayout.vue'
  import FieldLogo from './FieldLogo.vue'

  export default {
    components: {
      SettingsLayout,
      FieldLogo
    },

    setup() {
      const config = Config
      const form = useFormStore('setting-general')()

      form.onSuccess = function () {
        location.reload()
      }

      return { config }
    }
  }
</script>
