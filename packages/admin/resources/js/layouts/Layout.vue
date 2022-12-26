<template>
  <div class="h-screen flex overflow-hidden bg-gray-100">
    <LayoutSidebarMobile/>

    <LayoutSidebar/>

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
      <LayoutHeader/>

      <main class="flex-1 relative overflow-y-auto px-8 py-6">
        <GlobalAlerts/>

        <RouterView/>
      </main>
    </div>
  </div>

  <Modal/>
  <FlashMessage/>
</template>

<script setup>
  import LayoutHeader from './Header.vue'
  import LayoutSidebar from './Sidebar.vue'
  import Modal from 'Component/NewModal.vue'
  import FlashMessage from 'Component/FlashMessage.vue'
  import GlobalAlerts from 'Component/GlobalAlerts.vue'
  import LayoutSidebarMobile from './SidebarMobile.vue'
</script>
