<template>
  <section id="checklist" class="mt-8">
    <Collapsible :open="false">
      <template #trigger="{ open }">
        <div class="flex">
          <svg class="w-4 h-4 mr-4 text-gray-500 mt-1 cursor-pointer" :class="{ 'rotate-[270deg]': !open }" viewBox="0 0 16 16"><path d="M14 5.758L13.156 5 7.992 9.506l-.55-.48.002.002-4.588-4.003L2 5.77 7.992 11 14 5.758" fill="currentColor"></path></svg>

          <div class="flex-1 border-b pb-2">
            <span class="font-medium text-sm text-gray-800">{{ __('Checklist') }}</span>
            <span class="text-sm font-light ml-2 text-gray-600">{{ countItems() }}</span>
          </div>
        </div>
      </template>

      <div class="pl-8 pt-4">
        <div class="space-y-4">
          <template v-for="(item, index) in task.data.checklists.length ? task.data.checklists[0].checklist_items : []" :key="item.id">
            <Component :is="task.checklistItemForm == index ? ChecklistItemForm : ChecklistItem" :index="index" :id="item.id" :item="item.title" :is-completed="item.completed_at"/>
          </template>
        </div>

        <button class="flex items-center group" :class="{ 'mt-6': (task.data.checklists.length ? task.data.checklists[0].checklist_items.length : 0) > 0 }" @click="task.newChecklistItemForm = true" v-if="!task.newChecklistItemForm">
          <svg class="h-4 w-4 text-gray-600 group-hover:text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          <span class="pl-2 text-sm text-gray-600 group-hover:text-gray-800">{{ __('Add item') }}</span>
        </button>

        <ChecklistItemForm :class="{ 'mt-6': (task.data.checklists.length ? task.data.checklists[0].checklist_items.length : 0) > 0 }" v-if="task.newChecklistItemForm"/>
      </div>
    </Collapsible>
  </section>
</template>

<script setup>
  import { useTaskStore } from 'Store/task'
  import Collapsible from 'Component/Collapsible.vue'
  import ChecklistItem from './ChecklistItem.vue'
  import ChecklistItemForm from './ChecklistItemForm.vue'
  import { ChevronRightIcon } from '@heroicons/vue/outline'

  const task = useTaskStore()

  task.checklistItemForm = null
  task.newChecklistItemForm = false

  function countItems() {
    if (!task.data.checklists.length) return

    return task.data.checklists[0].checklist_items.filter(x => x.completed_at).length + '/' + task.data.checklists[0].checklist_items.length
  }
</script>
