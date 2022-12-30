<template>
  <div class="bg-gray-300 rounded-lg flex justify-center py-28" v-if="task.loading">
    <v-loader size="40" color="#5850ec"/>
  </div>

  <div v-else>
    <div class="flex shadow-sm border-b border-gray-200">
      <div class="flex items-center text-sm text-gray-700 px-6">
        <span class="inline-block w-2.5 h-2.5 rounded-full ltr:mr-2 rtl:ml-2" :style="{'background-color': task.data.project.meta.color}">&nbsp;</span>
        <span>{{ task.data.project.name }}</span>
        <span class="px-2">/</span>
        <span>{{ task.data.project_list.name }}</span>
      </div>

      <!-- <div class="px-6 flex items-center space-x-2">
        <button @click="quickScroll('subtasks')" class="text-xs text-gray-700 hover:text-gray-900">Sub-tasks</button>
        <span class="text-gray-700">-</span>
        <button @click="quickScroll('comments')" class="text-xs text-gray-700 hover:text-gray-900">Comments</button>
      </div> -->

      <div class="flex items-center ml-auto">
        <!-- <div v-if="can('task:delete')">
          <div class="flex items-center bg-white pl-4" :class="{ 'opacity-50': processing }" v-if="deleteConfirmation">
            <span class="text-gray-600 text-sm mr-2">Are you sure to delete?</span>
            <CheckCircleIcon class="w-5 h-5 text-green-600 cursor-pointer hover:text-green-800 mr-1" @click="deleteTask"/>
            <XCircleIcon class="w-5 h-5 text-red-600 cursor-pointer hover:text-red-800" @click="deleteConfirmation = false"/>
          </div>

          <span @click="deleteConfirmation = true" v-else>
            <TrashIcon class="w-5 h-5 text-gray-500 hover:text-gray-800 cursor-pointer ltr:mr-1 rtl:ml-1"/>
          </span>
        </div> -->






        <span class="text-gray-600 hover:text-gray-800 cursor-pointer px-4 py-4" @click="close">
          <svg class="w-6 h-6" viewBox="0 0 21 21"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(5 5)"><path d="m10.5 10.5-10-10z"/><path d="m10.5.5-10 10"/></g></svg>
        </span>
      </div>
    </div>

    <div class="flex">
      <main class="flex-1 px-6 pt-6 pb-8 max-h-[85vh] overflow-y-auto">
        <TaskMain/>
          <TaskFiles/>
        <!-- <SubTasks/> -->
        <Checklist/>
        <TaskComments/>

      </main>

      <aside class="bg-gray-50 w-60 px-6 py-6 divide-y divide-gray-200 rounded-br-lg">
        <TaskTimer/>
        <TaskProjectList/>
        <TaskAssignee/>
        <TaskDueDate/>
        <TaskLabels/>
        <!-- <TaskPriority/> -->
        <TaskRecurring/>
        <TaskDelete/>
        <TaskShare/>
      </aside>
    </div>
  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { useTaskStore } from 'Store/task'
  import { useModalStore } from 'Store/modal'
  import { useFlashStore } from 'Store/flash'
  import { useDetailStore } from 'Store/detail'
  import TaskMain from './TaskMain.vue'
  import SubTasks from './SubTasks.vue'
  import Checklist from './Checklist.vue'
  import TaskShare from './TaskShare.vue'
  import TaskDelete from './TaskDelete.vue'
  import TaskRecurring from './TaskRecurring.vue'
  import TaskComments from './TaskComments.vue'
  import TaskAssignee from './TaskAssignee.vue'
  import TaskLabels from './TaskLabels.vue'
  import TaskPriority from './TaskPriority.vue'
  import TaskProjectList from './TaskProjectList.vue'
  import TaskTimer from './TaskTimer.vue'
  import TaskDueDate from './TaskDueDate.vue'
  import TaskFiles from './TaskFiles.vue'
  import { TrashIcon, CheckCircleIcon, XCircleIcon } from '@heroicons/vue/outline'

  const props = defineProps({
    id: Number
  })

  const task = useTaskStore(),
    deleteConfirmation = ref(false),
    processing = ref(false),
    projectDetail = useDetailStore('project')()

  task.fetch(props.id)

  useModalStore().onHide = function () {
    const url = `/projects/${task.data.project_id}`
    history.replaceState(history.state, '', url)
  }

  function close() {
    useModalStore().hide()
  }

  function quickScroll(id) {
    const el = document.querySelector('#' + id)

    el.scrollIntoView({behavior: "smooth"})
  }

  function deleteTask() {
    if (processing.value) return

    processing.value = true

    axios.delete(`tasks/${props.id}`)
      .then(data => {
        close()
        processing.value = false
        useFlashStore().flash(data.message)
        projectDetail.fetch({
          loading: false,
          id: task.data.project_id,
        })
      })
      .catch(error => {
        useFlashStore().danger(error.response.data.message)
      })
  }
</script>
