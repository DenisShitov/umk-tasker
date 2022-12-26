<template>
  <v-dropdown name="task-labels" :modal="true" close-outside>
    <template #trigger>
      <span class="cursor-pointer">
        <svg class="h-4 w-4 text-gray-600 hover:text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
      </span>
    </template>

    <div class="ltr:origin-top-right rtl:origin-top-left absolute ltr:right-0 rtl:left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-40" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <p class="text-xs text-gray-600 text-center py-1.5" v-if="!task.options.labels.length">There are No Labels!</p>

      <div
        class="flex items-center px-4 py-2 text-sm hover:bg-gray-200"
        :class="{'cursor-pointer': can('task:update')}"
        @click="choose(option)"
        v-for="option in task.options.labels"
      >
        <!-- <span
          class="inline-block rounded-full h-5 w-5"
          :style="{'color': option.meta.color}"
          v-if="(task.data.labels.length ? task.data.labels.find(x => x.id == option.id) : null)"
        >
          <svg viewBox="0 0 16 16" fill="currentColor"><path d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/></svg>
        </span> -->

        <CheckIcon
          class="inline-block w-4 h-4"
          :style="{'color': option.meta.color}"
          v-if="(task.data.labels.length ? task.data.labels.find(x => x.id == option.id) : null)"
        />
        <TagIcon class="inline-block w-4 h-4" :style="{'color': option.meta.color}" v-else/>

        <span class="ltr:ml-2 rtl:mr-2 block text-gray-600">{{ option.name }}</span>
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
  import { inject } from 'vue'
  import VDropdown from 'Component/Dropdown.vue'
  import UserAvatar from 'Component/UserAvatar.vue'
  import { useTaskStore } from 'Store/task'
  import { useDetailStore } from 'Store/detail'
  import { TagIcon } from '@heroicons/vue/solid'
  import { CheckIcon } from '@heroicons/vue/solid'
  // import { CheckIcon } from '@heroicons/vue/outline'

  const task = useTaskStore(),
    projectDetail = useDetailStore('project')(),
    can = inject('can')

  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }

  function choose(label) {
    if (!can('task:update')) return
    let index = task.data.labels.findIndex(x => x.id == label.id)

    if (index >= 0) {
      task.data.labels.splice(index, 1)
    } else {
      task.data.labels.push({
        id: label.id,
        name: label.name,
        meta: {
          color: label.meta.color
        }
      })
    }

    console.log(task.data.labels)

    axios.patch('tasks/' + task.data.id + '/label', {
      label: label.id
    })
      .then(data => {
        console.log(data)
        updateProjectDetail()
      })
  }
</script>
