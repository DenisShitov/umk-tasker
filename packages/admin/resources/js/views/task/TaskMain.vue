<template>
  <div class="flex">
    <TaskCheckbox/>

    <div class="flex-1 pl-4">
<!--      <TaskContentForm v-if="task.isContentForm"/>-->
<!--      <TaskContent v-else/>-->

        <TaskTitleForm v-if="task.isContentFormTitle"/>
        <TaskTitle v-else/>

        <TaskDescForm v-if="task.isContentFormDesc"/>
        <TaskDesc v-else/>

    </div>
  </div>
</template>

<script setup>
  import { useTaskStore } from 'Store/task'
  import TaskCheckbox from './TaskCheckbox.vue'
  import TaskContent from './TaskContent.vue'
  import TaskContentForm from './TaskContentForm.vue'
  import TaskTitleForm from './TaskTitleForm.vue'
  import TaskTitle from './TaskTitle.vue'
  import TaskDescForm from './TaskDescForm.vue'
  import TaskDesc from './TaskDesc.vue'

  const task = useTaskStore()
</script>
