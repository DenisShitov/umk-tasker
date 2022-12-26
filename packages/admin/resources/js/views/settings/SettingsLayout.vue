<template>
  <div class="topbar flex justify-between">
    <h1 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('Settings') }}</h1>
    <div>
      <slot name="topbar"/>
    </div>
  </div>

  <div class="flex">
    <div class="w-64">
      <v-card class="overflow-hidden">
        <nav class="py-1">
          <template v-for="nav in settingsNav" :key="nav.label">
            <router-link :to="nav.uri" custom v-slot="{ href, navigate, isActive }" v-if="!nav.permission || can(nav.permission)">
              <a :href="href"
                 @click="navigate"
                 class="block text-sm px-4 py-2"
                 :class="{ 'text-gray-900 font-medium bg-gray-100': isActive, 'text-gray-700 hover:text-gray-900 hover:bg-gray-100': !isActive }"
              >
                {{ __(nav.label, nav.count) }}
              </a>
            </router-link>
          </template>
        </nav>
      </v-card>
    </div>
    <div class="flex-1 ltr:pl-6 rtl:pr-6">
      <slot/>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { settingsNav } from 'Composable/settings-nav'
</script>
