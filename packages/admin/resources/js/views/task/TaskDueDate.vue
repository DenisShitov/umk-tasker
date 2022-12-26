<template>
  <section class="py-3">
    <h2 class="text-gray-600 text-sm font-medium px-2">{{ __('Due Date') }}</h2>

    <div class="flex items-center mt-2 px-2" data-cooltipz-dir="top" v-if="!can('task:update')">
      <CalendarIcon class="w-4 h-4 text-gray-500"/>

      <span class="block leading-none ltr:ml-1.5 rtl:mr-1.5 text-xs text-gray-600">{{ task.data.due_at ? task.data.due_at : __('No due date') }}</span>
    </div>

    <v-dropdown name="task-date" close-outside :close="closeDropdown" :modal="true" v-else>
      <template #trigger>
        <div class="group flex items-center cursor-pointer mt-2 px-2 py-1.5 hover:bg-gray-200 rounded-md">
          <CalendarIcon class="w-4 h-4 text-gray-500"/>

          <span class="block leading-none ltr:ml-1.5 rtl:mr-1.5 text-xs text-gray-600">{{ task.data.due_at ? task.data.human_due_date : __('No due date') }}</span>

          <span class="flex items-center justify-center ml-auto hover:bg-gray-300 rounded-md w-4 h-4" @click.stop="onDateSelected" v-if="task.data.due_at">
            <XIcon class="w-3.5 h-3.5 text-gray-600"/>
          </span>
        </div>
      </template>

      <div class="ltr:origin-top-left rtl:origin-top-right absolute ltr:left-0 rtl:right-0 mt-2 z-30" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
        <v-calendar :date="task.data.due_at" @selected="onDateSelected"/>
      </div>
    </v-dropdown>
  </section>
</template>

<script setup>
  import { ref } from 'vue'
  import VDropdown from 'Component/Dropdown.vue'
  import VCalendar from 'Component/Calendar.vue'
  import { CalendarIcon, XIcon } from '@heroicons/vue/outline'
  import { useTaskStore } from 'Store/task'
  import { useDetailStore } from 'Store/detail'

  const closeDropdown = ref(false)
  const task = useTaskStore()
  const projectDetail = useDetailStore('project')()

  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }

  function choose(option) {
    task.data.priority = {
      name: option.name,
      color: option.color,
    }

    axios.patch('tasks/' + task.data.id + '/priority', {
      priority: option.id
    })
      .then(data => {
        console.log(data)
      })
  }

  function removeDate() {
    console.log('removeDate')
  }

  const onDateSelected = function (payload) {
    console.log('onDateSelected')
    console.log(payload)
    closeDropdown.value = true
    task.data.due_at = payload ? payload.date : null
    task.data.human_due_date = payload ? payload.label : null

    axios.patch('tasks/' + task.data.id + '/due-date', {
      due_at: payload ? payload.date : null
    })
      .then(data => {
        console.log(data)
        updateProjectDetail()
      })
  }
</script>
