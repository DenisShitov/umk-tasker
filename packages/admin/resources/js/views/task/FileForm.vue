<template>
  <div>
    <div class="border border-gray-300 rounded-md cursor-pointer mt-1 mb-4 hover:shadow" v-show="isSkelton" @click="showForm">
      <p class="text-sm text-gray-500 px-3 py-2">{{ __('Write a comment') }}</p>
    </div>

    <form class="border border-gray-300 rounded-md mt-1 mb-4" enctype="multipart/form-data" v-show="!isSkelton">
      <textarea
        ref="input"
        v-model="commentText"
        class="autosize comment-textarea block w-full border-0 focus:ring-0 resize-none rounded-md text-sm max-h-40"
        :placeholder="__('Write a comment')"
        @keydown.ctrl.enter="create"
        @keydown.esc="cancel"
      />

      <ul class="mt-1 mb-1 mx-3 border rounded-md divide-y" v-if="files.length">
        <li class="block py-2 px-3" v-for="(file, index) in files">
          <div class="flex items-center">
            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
            </svg>
            <span class="ltr:ml-2 rtl:mr-2 flex-1 w-0 truncate text-sm">
              {{ file.name }}
            </span>
            <span class="cursor-pointer ltr:ml-auto rtl:mr-auto" @click="removeFile(index)">
              <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </span>
          </div>

          <div class="bg-green-100 w-full rounded-md mt-2" v-if="progress[index]">
            <span class="block bg-green-400 rounded-md h-1" :style="{ width: progress[index] + '%' }"></span>
          </div>
        </li>
      </ul>

      <div class="flex items-center pt-2 pb-3 px-3">
        <div class="flex items-center">
          <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-0" @click="create">
            {{ __('Save') }}
          </button>

          <button type="button" class="ltr:ml-1 rtl:mr-1 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-700 hover:text-gray-900 bg-white focus:outline-none focus:ring-0" @click="cancel">
            {{ __('Cancel') }}
          </button>
        </div>

        <div class="flex ml-auto">
          <label class="cursor-pointer">
            <input type="file" class="hidden" accept="image/png, image/jpeg, image/gif,.doc,.docx,.pdf,.txt" multiple @change="onChoose">

            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
            </svg>
          </label>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  import { useTaskStore } from 'Store/task'
  import { useDetailStore } from 'Store/detail'
  import autosize from 'autosize'

  const props = defineProps({
    id: Number,
    index: Number,
    comment: Object,
  })

  onMounted(() => {
    autosize(document.querySelectorAll('.autosize'))
    input.value.focus()
  })

  const task = useTaskStore(),
    processing = ref(false),
    files = ref(props.comment ? props.comment.attachments : []),
    commentText = ref(props.comment ? props.comment.comment : ''),
    input = ref(null),
    isSkelton = ref(props.id ? false : true)

  const progress = ref({})
  const filePaths = ref({})
  const submitting = ref(false)
  const config = Config
  const projectDetail = useDetailStore('project')()

  function cancel() {
    isSkelton.value = true
    commentText.value = ''
    task.commentForm = null
  }

  function showForm() {
    isSkelton.value = false

    setTimeout(function () {
      input.value.focus()
    })
  }

  function hideForm() {
    task.subtaskForm = null
    task.newSubtaskForm = false
  }

  function submit() {
    if (processing.value) return
    if (!subtask.value) return

    if (props.subtask == subtask.value && props.id) {
      hideForm()
      return
    }

    processing.value = true

    const method = props.id ? 'patch' : 'post'
    const uri = props.id ? `sub-tasks/${props.id}` : 'sub-tasks'

    axios[method](uri, {
      title: subtask.value,
      parent_id: task.data.id,
      project_id: task.data.project_id,
    })
      .then(data => {
        processing.value = false
        props.id ? updateTask(data) : appendTask(data)
        props.id ? hideForm() : subtask.value = ''
      })
  }

  function appendTask(subtask) {
    task.data.tasks.push(subtask)
  }

  function updateTask(subtask) {
    task.data.tasks[props.index] = subtask
  }







  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }

  function onChoose(e) {
    e.preventDefault()
    files.value = [...e.target.files]

    console.log(files.value)

    for (let i = 0; i < files.value.length; i++) {
      handle(i)
    }
  }

  function handle(index) {
    const file = files.value[index],
      reader = new FileReader()

    reader.readAsDataURL(file)
    reader.onload = e => {
      const formData = new FormData()
      formData.append('file', file)

      axios.post('file', formData, {
        onUploadProgress: function(progressEvent) {
          console.log('progressEvent')
          console.log(progressEvent)
          console.log( Math.round((progressEvent.loaded * 100) / progressEvent.total) )
          progress.value[index] = (Math.round((progressEvent.loaded * 100) / progressEvent.total) - 5)
        }
      })
        .then(data => {
          console.log('data')
          console.log(data)
          filePaths.value[index] = {path: data, name: file.name}
          progress.value[index] = 100
        })
    }
  }

  function removeFile(index) {
    console.log(filePaths.value)
    console.log(index)
    delete filePaths.value[index]
    console.log(files.value)
    files.value.splice(index, 1)
  }

  function create() {
    if (!commentText.value) return

    console.log('create')
    submitting.value = true

    axios.post('tasks/' + task.data.id + '/comments', {
      'text': commentText.value,
      'task_id': task.data.id,
      'attachments': filePaths.value,
    })
      .then(data => {
        console.log('data')
        console.log(data)
        task.data.comments.push(data)
        commentText.value = ''
        files.value = []
        filePaths.value = {}
        progress.value = {}
        submitting.value = false
        updateProjectDetail()
        // detail.fetch({id: task.data.id, loading: false})
      })
  }

  function onDelete(id, index) {
    if (confirm("Are you sure to delete this item?") == true) {
      axios.delete(`comments/${id}`)
        .then(data => {
          useFlashStore().flash(data.message)

          task.data.comments.splice(index, 1)
          updateProjectDetail()
        })
        .catch(error => {
          useFlashStore().danger(error.response.data.message)
        })
    }
  }
</script>
