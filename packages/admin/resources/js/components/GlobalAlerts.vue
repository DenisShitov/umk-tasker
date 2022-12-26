<template>
  <div class="rounded-md p-4 mb-4" :class="[types[alert.type].background]" v-for="alert in alertStore.alerts" :key="alert.message">
    <div class="flex">
      <div class="flex-shrink-0">
        <component :is="types[alert.type].icon" class="h-5 w-5" :class="[types[alert.type].iconColor]"/>
      </div>
      <div class="ml-3">
        <p class="text-sm" :class="[types[alert.type].text]">
          {{ alert.message }}
          <template v-for="link in alert.links" :key="link.text">
            <a :href="link.href" class="font-medium underline px-1" :class="[types[alert.type].link]" v-if="link.href.startsWith('http')" target="_blank">{{ link.text }}</a>
            <router-link :to="link.href" class="font-medium underline px-1" :class="[types[alert.type].link]" v-else>{{ link.text }}</router-link>
          </template>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { ref, inject } from 'vue'
  import { useAlertStore } from 'Store/alert'
  import { InformationCircleIcon, ExclamationIcon, CheckCircleIcon, XCircleIcon } from '@heroicons/vue/solid'

  const alertStore = useAlertStore(),
        trans = inject('__'),
        types = {
          info: { icon: InformationCircleIcon, iconColor: 'text-blue-400', background: 'bg-blue-100', text: 'text-blue-700', link: 'text-blue-700 hover:text-blue-600' },
          warning: { icon: ExclamationIcon, iconColor: 'text-yellow-400', background: 'bg-yellow-100', text: 'text-yellow-700', link: 'text-yellow-700 hover:text-yellow-600' },
          success: { icon: CheckCircleIcon, iconColor: 'text-blue-400', background: 'bg-blue-100', text: 'text-blue-700', link: 'text-blue-700 hover:text-blue-600' },
          error: { icon: XCircleIcon, iconColor: 'text-blue-400', background: 'bg-blue-100', text: 'text-blue-700', link: 'text-blue-700 hover:text-blue-600' },
        }

  // if (!Config.options.email_config && !Config.options.demo) {
  //   alertStore.alerts.push({
  //     type: 'warning',
  //     message: trans('Please first configure your'),
  //     links: [{ href: '/settings/email', text: trans('Email Settings') }]
  //   })
  // }

  if (Config.options.global_update_notification && !Config.options.demo) {
    alertStore.alerts.push({
      type: 'info',
      message: trans('A new Spack update is available.'),
      links: [{ href: 'https://spack-docs.codedott.com/prologue/changelog.html', text: trans('See what’s new in version') + ' ' + Config.options.global_update_notification }]
    })
  }

  // if (Config.options.demo) {
  //   alertStore.alerts.push({
  //     type: 'info',
  //     message: trans('Data reset every 12 hours and some features are disabled.'),
  //     links: [{ href: 'http://spackdemo.xyz/demo', text: trans('Create a standalone demo to test all features.') }]
  //   })
  // }
</script>
