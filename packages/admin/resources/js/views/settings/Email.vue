<template>
  <SettingsLayout>
    <v-form
      name="setting-email"
      uri="settings/email"
      :title="__('Email')"
      save-only
    >
      <v-field-select name="mail_driver" :label="__('Driver')" input-class="max-w-xs" inline/>
      <v-field-text name="mail_host" :label="__('Host')" inline/>
      <v-field-text name="mail_port" :label="__('Port')" inline/>
      <v-field-text name="mail_username" :label="__('Username')" inline/>
      <v-field-text name="mail_password" :label="__('Password')" inline/>
      <v-field-select name="mail_encryption" :label="__('Encryption')" input-class="max-w-xs" inline/>
      <v-field-text name="mail_from_address" :label="__('From Address')" inline/>
      <v-field-text name="mail_from_name" :label="__('From Name')" inline/>
    </v-form>
  </SettingsLayout>
</template>

<script lang="ts">
  import { useFormStore } from 'Store/form'
  import SettingsLayout from './SettingsLayout.vue'

  export default {
    components: {
      SettingsLayout
    },

    setup() {
      const form = useFormStore('setting-email')()

      form.onSuccess = function () {
        location.reload()
      }
    }
  }
</script>
