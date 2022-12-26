<template>
  <settings-layout>
    <v-card class="p-6">
      <h3 class="font-medium text-gray-900 mb-6">
        {{ __('Current Version') }}: <span class="text-gray-500 ltr:ml-2 rtl:mr-2">{{ updates.version }}</span>
      </h3>

      <label class="block text-sm font-medium text-gray-700">
        {{ __('Purchase Code') }}
      </label>

      <div class="mt-1 flex items-center border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
        <input
          :type="inputType"
          :placeholder="__('Purchase Code')"
          v-model="purchaseCode"
          class="text-sm flex-1 border-0 rounded-md focus:outline-none focus:border-0 focus:ring-0"
        >

        <div class="px-2 cursor-pointer" @click="handleInputType">
          <EyeIcon class="w-4 h-4 text-gray-500" v-show="inputType == 'text'"/>
          <EyeOffIcon class="w-4 h-4 text-gray-500" v-show="inputType == 'password'"/>
        </div>
      </div>

      <div class="text-xs leading-normal text-gray-600 italic text-red-600 mt-2" v-if="errors.purchase_code">
        {{ errors.purchase_code[0] }}
      </div>

      <div class="flex items-center justify-between border border-gray-200 rounded-md p-4 mt-6 mb-6" v-if="updates.update_available">
        <div>
          {{ __('A new Spack update is available.') }}
          <span class="text-indigo-600">{{ updates.new_version }}</span>
          <p class="text-gray-500 mt-1">{{ __('while updating it will down your app and take some time to update.') }}</p>
        </div>

        <v-button white @click="updateNow" :processing="updateProcessing" :disabled="processing">{{ __('Update Now') }}</v-button>
      </div>

      <div class="flex items-center justify-between border border-gray-200 rounded-md p-4 mt-4 mb-6" v-if="uptodate">
        {{ __('Spack is up to date.') }}
      </div>

      <v-button class="mt-4" @click="checkUpdates" :processing="checkProcessing" :disabled="processing" size="sm">{{ __('Check for Updates') }}</v-button>

      <p class="text-sm text-gray-500 mt-2">
        <span v-if="updates.checked_at">{{ __('Last checked at') }}: {{ updates.checked_at }}</span>
        <span v-else>{{ __('Never checked for updates') }}</span>
      </p>
    </v-card>
  </settings-layout>
</template>

<script lang="ts">
  import { ref, inject } from 'vue'
  import { useRouter } from 'vue-router'
  import { useFlashStore } from 'Store/flash'
  import SettingsLayout from './SettingsLayout.vue'
  import { EyeIcon, EyeOffIcon } from '@heroicons/vue/outline'

  export default {
    components: {
      SettingsLayout,
      EyeIcon,
      EyeOffIcon
    },

    setup() {
      let updates = ref(Config.app_updates),
          processing = ref(false),
          checkProcessing = ref(false),
          updateProcessing = ref(false),
          uptodate = ref(false),
          purchaseCode = ref(Config.purchase_code),
          errors = ref({}),
          inputType = ref('password'),
          router = useRouter(),
          can = inject('can')

      if (!can('setting:updates')) {
        router.push('/404')
      }

      function checkUpdates() {
        processing.value = true
        checkProcessing.value = true

        axios.post('check-updates', {
          'purchase_code': purchaseCode.value,
          'domain': window.location.host,
          'url': window.location.href,
        })
          .then(data => {
            updates.value = data

            if (data.update_available) {
              uptodate.value = false
            } else {
              uptodate.value = true
            }

            errors.value = {}
            processing.value = false
            checkProcessing.value = false
          })
          .catch(error => {
            if (error.response.status == 422) {
              errors.value = error.response.data.errors
            }

            processing.value = false
            checkProcessing.value = false
            useFlashStore().danger(error.response.data.message)
          })
      }

      function updateNow() {
        processing.value = true
        updateProcessing.value = true

        axios.post('update-app')
          .then(data => {
            if (data.status == 'done') {
              runUpdateRecipe()
            }
          })
          .catch(error => {
            processing.value = false
            updateProcessing.value = false
            useFlashStore().danger(error.response.data.message)
          })
      }

      function runUpdateRecipe() {
        axios.post('update-recipe')
          .then(data => {
            if (data.success) {
              location.reload()
              // updates.value = data.updates
            }
            // processing.value = false
            // updateProcessing.value = false
          })
          .catch(error => {
            processing.value = false
            updateProcessing.value = false
            useFlashStore().danger(error.response.data.message)
          })
      }

      function handleInputType() {
        if (inputType.value == 'password') {
          inputType.value = 'text'
        } else {
          inputType.value = 'password'
        }
      }

      return {
        updates,
        processing,
        checkProcessing,
        updateProcessing,
        checkUpdates,
        updateNow,
        uptodate,
        purchaseCode,
        errors,
        inputType,
        handleInputType
      }
    }
  }
</script>
