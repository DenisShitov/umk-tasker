<template>
  <div class="bg-white rounded-t-lg px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
    <div class="sm:flex sm:items-start">
      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
        <!-- Heroicon name: exclamation -->
        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
      </div>
      <div class="mt-3 mt-0 ltr:ml-4 rtl:mr-4 ltr:text-left rtl:text-right">
        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
          {{ __(confirm.title) }}
        </h3>
        <div class="mt-2">
          <p class="text-sm leading-5 text-gray-500">
            {{ __(confirm.description) }}
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-gray-50 rounded-b-lg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
    <v-button class="ltr:ml-3 rtl:mr-3" :danger="confirm.danger" @click="confirm.proceed" :processing="confirm.processing">
      {{ __(confirm.button) }}
    </v-button>

    <v-button white @click="confirm.hide">
      {{ __('Cancel') }}
    </v-button>
  </div>
</template>

<script setup>
  import { useConfirmStore } from 'Store/confirm'

  const confirm = useConfirmStore()

  defineProps({id: Number})
</script>
