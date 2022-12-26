<template>
  <v-topbar :title="__('Profile')"/>

  <v-form
    name="profile"
    uri="profile"
    :title="__('Profile')"
    save-only
  >
    <v-field-avatar/>
    <v-field-text name="name" :label="__('Name')" inline/>
    <v-field-text name="email" :label="__('Email')" inline disabled/>
    <v-field-text name="password" :label="__('New Password')" type="password" inline/>
  </v-form>
</template>

<script lang="ts">
  import { useFormStore } from 'Store/form'

  export default {
    setup() {
      const form = useFormStore('profile')()

      form.onSuccess = function () {
        form.processing = false
        form.data.password = ''
      }
    }
  }
</script>
