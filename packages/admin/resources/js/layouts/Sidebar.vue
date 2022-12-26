<template>
  <div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
      <div class="flex flex-col h-0 flex-1">
        <RouterLink to="/" class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
          <SidebarLogo/>
        </RouterLink>

        <div class="flex-1 flex flex-col overflow-y-auto sidebar-nav">
          <nav class="bg-gray-800 flex-1 px-2 py-4">
            <SidebarNav/>
            <SidebarFavorites/>
            <SidebarProjects/>
            <SidebarProjectsArchived/>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
  import SidebarNav from './SidebarNav.vue'
  import SidebarLogo from './SidebarLogo.vue'
  import SidebarFavorites from './SidebarFavorites.vue'
  import SidebarProjects from './SidebarProjects.vue'
  import SidebarProjectsArchived from './SidebarProjectsArchived.vue'
</script>
