<template>
  <div class="flex items-center mb-4">
    <h1 class="text-2xl font-semibold text-gray-900">{{ __('Tasks') }}</h1>

    <div class="flex ltr:ml-auto rtl:mr-auto">
      <nav class="rounded-md flex space-x-2" aria-label="Tabs">
        <span class="group flex items-center px-3 py-2 rounded-md cursor-pointer" :class="{ 'bg-gray-200 text-gray-800': index.params.type == null && project == null, 'text-gray-600': index.params.type != null || project != null }" @click="choose()">
          <InboxIcon class="w-4 h-4 group-hover:text-gray-800"/>
          <span class="ltr:ml-2 rtl:mr-2 text-sm font-medium group-hover:text-gray-800">{{ __('Inbox') }}</span>
        </span>

        <span class="group flex items-center px-3 py-2 rounded-md cursor-pointer" :class="{ 'bg-gray-200 text-gray-800': index.params.type == 'today', 'text-gray-600': index.params.type != 'today' }" @click="choose('today')">
          <CalendarIcon class="w-4 h-4 group-hover:text-gray-800"/>
          <span class="ltr:ml-2 rtl:mr-2 text-sm font-medium group-hover:text-gray-800">{{ __('Today') }}</span>
        </span>

        <span class="group flex items-center px-3 py-2 rounded-md cursor-pointer" :class="{ 'bg-gray-200 text-gray-800': index.params.type == 'upcoming', 'text-gray-600': index.params.type != 'upcoming' }" @click="choose('upcoming')">
          <BeakerIcon class="w-4 h-4 group-hover:text-gray-800"/>
          <span class="ltr:ml-2 rtl:mr-2 text-sm font-medium group-hover:text-gray-800">{{ __('Upcoming') }}</span>
        </span>

        <span class="group flex items-center px-3 py-2 rounded-md cursor-pointer" :class="{ 'bg-gray-200 text-gray-800': index.params.type == 'overdue', 'text-gray-600': index.params.type != 'overdue' }" @click="choose('overdue')">
          <LightningBoltIcon class="w-4 h-4 group-hover:text-gray-800"/>
          <span class="ltr:ml-2 rtl:mr-2 text-sm font-medium group-hover:text-gray-800">{{ __('Overdue') }}</span>
        </span>

        <span class="group flex items-center px-3 py-2 rounded-md cursor-pointer" :class="{ 'bg-gray-200 text-gray-800': index.params.type == 'completed', 'text-gray-600': index.params.type != 'completed' }" @click="choose('completed')">
          <CheckCircleIcon class="w-4 h-4 group-hover:text-gray-800"/>
          <span class="ltr:ml-2 rtl:mr-2 text-sm font-medium group-hover:text-gray-800">{{ __('Completed') }}</span>
        </span>
      </nav>

      <div class="group ltr:ml-2 rtl:mr-2 relative">
        <div class="group flex items-center rounded-md px-3 py-2 cursor-pointer" :class="{ 'bg-gray-200 text-gray-800': project, 'text-gray-600': !project }" v-if="project">
          <span class="block flex-shrink-0 w-2 h-2 rounded-full" :style="{ 'background-color': projectColor }"></span>
          <span class="ltr:ml-2 rtl:mr-2 text-sm font-medium group-hover:text-gray-800">{{ projectName }}</span>
        </div>

        <div class="group flex items-center rounded-md px-3 py-2 cursor-pointer text-gray-600" v-else>
          <FolderIcon class="w-4 h-4 group-hover:text-gray-800"/>
          <span class="ltr:ml-2 rtl:mr-2 text-sm font-medium group-hover:text-gray-800">{{ __('Projects') }}</span>
        </div>

        <div class="hidden group-hover:block absolute ltr:right-0 rtl:left-0 top-full">
          <div class="h-1.5">&nbsp;</div>
          <div class="min-w-[12rem] bg-white rounded-md ring-1 ring-black ring-opacity-5">
            <div class="py-1" role="none">
              <p v-for="project in projects" :key="project.id" @click="chooseProject(project.id, project.name, project.meta.color)" class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer">
                <span class="block flex-shrink-0 w-2.5 h-2.5 rounded-full" :style="{ 'background-color': project.meta.color }" aria-hidden="true"></span>
                <span class="ltr:ml-2.5 rtl:mr-2.5 truncate">{{ project.name }}</span>
              </p>

              <p class="flex items-center px-4 py-3 text-sm leading-5 text-gray-600" v-show="!projects.length">
                {{ __('No projects') }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="flex justify-center mt-8" v-if="index.loading">
    <v-loader size="40" color="#5850ec"/>
  </div>

  <div v-else>
    <v-index-no-data v-if="Array.isArray(index.data)" no-create/>

    <div class="space-y-4" v-else>
      <TasksList title="Today" :tasks="index.data['today']" v-if="index.data['today']"/>
      <TasksList title="Overdue" :tasks="index.data['overdue']" v-if="index.data['overdue']"/>
      <TasksList title="Upcoming" :tasks="index.data['upcoming']" v-if="index.data['upcoming']"/>
      <TasksList title="No Overdue" :tasks="index.data['no overdue']" v-if="index.data['no overdue']"/>
      <TasksList title="Completed" :tasks="index.data['completed']" v-if="index.data['completed']"/>
    </div>
  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { useIndexStore } from 'Store/index'
  import { InboxIcon, CalendarIcon, BeakerIcon, LightningBoltIcon, CheckCircleIcon, FolderIcon } from '@heroicons/vue/outline'
  import TasksList from './TasksList.vue'

  const index = useIndexStore('tasks')(),
    projects = ref([]),
    project = ref(null),
    projectName = ref(''),
    projectColor = ref('')

  index.setConfig({ uri: 'tasks' })
  index.fetch()

  getProjects()

  function getProjects() {
    axios.get('projects/options')
      .then(data => {
        console.log(data)
        projects.value = data
      })
  }

  function choose(type = null) {
    project.value = null
    index.params.project = null
    index.params.type = type
    index.fetch()
  }

  function chooseProject(id, name, color) {
    project.value = id
    projectName.value = name
    projectColor.value = color
    index.params.type = null
    index.params.project = id
    index.fetch()
  }
</script>
