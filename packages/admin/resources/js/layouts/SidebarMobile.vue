<template>
  <TransitionRoot as="template" :show="main.mobileSidebar">
    <Dialog as="div" static class="fixed inset-0 flex z-40 md:hidden" @close="main.mobileSidebar = false" :open="main.mobileSidebar">
      <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
        <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
      </TransitionChild>
      <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
        <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
          <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
              <button class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="main.mobileSidebar = false">
                <span class="sr-only">Close sidebar</span>
                <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
              </button>
            </div>
          </TransitionChild>

          <router-link to="/" custom v-slot="{ href, navigate }">
            <a :href="href" @click="navigate" class="flex items-center flex-shrink-0 px-4">
              <sidebar-logo/>
            </a>
          </router-link>

          <div class="mt-5 flex-1 h-0 overflow-y-auto">
            <sidebar-nav/>
          </div>
        </div>
      </TransitionChild>
      <div class="flex-shrink-0 w-14" aria-hidden="true">
        <!-- Dummy element to force sidebar to shrink to fit close icon -->
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
  import { ref } from 'vue'
  import { Dialog, DialogOverlay, TransitionChild, TransitionRoot } from '@headlessui/vue'
  import { XIcon } from '@heroicons/vue/outline'
  import { useMainStore } from 'Store/main'
  import SidebarNav from './SidebarNav.vue'
  import SidebarLogo from './SidebarLogo.vue'

  const main = useMainStore()
</script>
