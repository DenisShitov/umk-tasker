<template>
  <v-dropdown name="task-assign" :modal="true" close-outside>
    <template #trigger>
      <span class="cursor-pointer">
        <svg class="h-4 w-4 text-gray-600 hover:text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
      </span>
    </template>

    <div class="ltr:origin-top-right rtl:origin-top-left absolute ltr:right-0 rtl:left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-40" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <div
        class="flex items-center px-4 py-2 text-sm hover:bg-gray-200"
        :class="{'cursor-pointer': can('task:update')}"
        @click="choose(user)"
        v-for="user in task.data.project.users"
      >
        <span
          class="inline-block rounded-full h-5 w-5 text-white bg-blue-400"
          v-if="(task.data.users.length ? task.data.users.find(x => x.id == user.id) : null)"
        >
          <svg viewBox="0 0 16 16" fill="white"><path d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/></svg>
        </span>

        <UserAvatar class="w-5 h-5" :user="user" v-else/>

        <span class="ltr:ml-2 rtl:mr-2 block text-gray-600">{{ user.name }}</span>
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

  const task = useTaskStore(),
    projectDetail = useDetailStore('project')(),
    can = inject('can')

  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }

  function choose(user) {
    if (!can('task:update')) return
    let index = task.data.users.findIndex(x => x.id == user.id)

    if (index >= 0) {
      task.data.users.splice(index, 1)
    } else {
      task.data.users.push({
        id: user.id,
        name: user.name,
      })
    }

    console.log(task.data.users)

    axios.patch('tasks/' + task.data.id + '/assign', {
      user: user.id
    })
      .then(data => {
        console.log(data)
        updateProjectDetail()
      })
  }
</script>
