<template>
  <v-dropdown name="task-share" :modal="true" close-outside @toggle="onOpen">
    <template #trigger>
      <span class="cursor-pointer">
        <ExternalLinkIcon class="h-4 w-4 text-gray-600 hover:text-gray-800"/>
      </span>
    </template>

    <div class="bottom-0 ltr:origin-bottom-right rtl:origin-bottom-left absolute ltr:right-0 rtl:left-0 mb-6 w-96 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-40" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <div class="px-6 py-4">
        <h3 class="font-medium text-gray-700 text-sm mb-4">Share URL</h3>

        <section class="mb-2">
          <div class="flex items-center w-full border border-gray-300 rounded-md px-3 py-2" @click="onClick">
            <input
              type="text"
              ref="input"
              v-model="url"
              readonly
              class="flex-1 border-0 focus:ring-0 text-sm text-gray-600 py-0 px-0"
            >

            <span
              class="block cursor-pointer text-gray-500 hover:text-gray-800 w-4 ml-2"
              :aria-label="copyLabel"
              data-cooltipz-dir="bottom"
              @click="copy"
              @mouseover="resetTooltip"
              v-if="isNavigatorAvailable"
            >
              <ClipboardCopyIcon class="w-4 h-4"/>
            </span>
          </div>
        </section>
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
  import { ref } from 'vue'
  import VDropdown from 'Component/Dropdown.vue'
  import { ExternalLinkIcon, ClipboardCopyIcon } from '@heroicons/vue/outline'

  const isNavigatorAvailable = ref(false),
    url = ref(window.location.href),
    input = ref(null),
    copyLabel = ref('Copy to Clipboard')

  function onOpen() {
    checkNavigator()

    setTimeout(function() {
      onClick()
    })
  }

  function checkNavigator() {
    navigator.clipboard ? isNavigatorAvailable.value = true : isNavigatorAvailable.value = false
  }

  function onClick() {
    input.value.focus()
    input.value.select()
  }

  function copy() {
    navigator.clipboard.writeText(input.value.value)
    copyLabel.value = 'Copied: ' + input.value.value
  }

  function resetTooltip() {
    copyLabel.value = 'Copy to Clipboard'
  }
</script>
