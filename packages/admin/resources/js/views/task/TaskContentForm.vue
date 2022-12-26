<template>
  <section :class="{ 'opacity-50': processing }">
    <div class="border rounded-md overflow-hidden">
      <textarea
        class="autosize task-title block w-full text-sm border-0 focus:ring-0 resize-none h-8 font-semibold text-base text-gray-800 placeholder:text-gray-500 placeholder:font-normal placeholder:text-sm px-2 pt-2"
        placeholder="Task"
        v-model="title"
        @keydown.enter.prevent="save"
        @keydown.esc="cancel"
      />

      <textarea
        class="autosize task-description block w-full text-sm border-0 focus:ring-0 resize-none h-14 px-2 py-2 placeholder:text-gray-500 placeholder:font-normal"
        placeholder="Description"
        v-model="description"
        @keydown.ctrl.enter="save"
        @keydown.esc="cancel"
      />
    </div>

    <div class="mt-2">
      <button
        type="button"
        class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        @click="save"
      >
        {{ __('Save') }}
      </button>

      <button
        type="button"
        class="ltr:ml-1 rtl:mr-1 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-700 hover:text-gray-900 bg-white focus:outline-none focus:ring-0"
        @click="cancel"
      >
        {{ __('Cancel') }}
      </button>
    </div>
  </section>
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  import autosize from 'autosize'
  import { useTaskStore } from 'Store/task'

  onMounted(() => {
    document.querySelector('.task-title').focus()
    autosize(document.querySelectorAll('.autosize'))
  })

  const task = useTaskStore(),
    processing = ref(false),
    title = ref(task.data.title),
    description = ref(task.data.description)

  function save(e) {
    if (processing.value) return

    if (task.data.title == title.value && task.data.description == description.value) {
      cancel()
      return
    }

    processing.value = true

    axios.patch(`tasks/${task.data.id}`, {
      title: title.value,
      description: description.value
    })
      .then(data => {
        processing.value = false
        task.data.title = title.value
        task.data.description = description.value
        cancel()
      })
  }

  function cancel() {
    title.value = ''
    description.value = ''
    task.isContentForm = false
  }
</script>
