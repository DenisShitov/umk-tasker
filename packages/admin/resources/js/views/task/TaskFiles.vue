<template>
  <section id="files" class="mt-8">
    <Collapsible :open="false">
      <template #trigger="{ open }">
        <div class="flex">
          <svg class="w-4 h-4 mr-4 text-gray-500 mt-1 cursor-pointer" :class="{ 'rotate-[270deg]': !open }" viewBox="0 0 16 16"><path d="M14 5.758L13.156 5 7.992 9.506l-.55-.48.002.002-4.588-4.003L2 5.77 7.992 11 14 5.758" fill="currentColor"></path></svg>
          <div class="flex-1 border-b pb-2">
              <span class="font-medium text-sm text-gray-800">Файлы </span>
              <span class="text-sm font-light ml-2 text-gray-600">{{ task.data.files.length }}</span>
          </div>
        </div>
      </template>

      <div class="pl-8 pt-4">
        <div class="space-y-4">
            <ul class="mb-1 border rounded-md divide-y" v-if="task.data.files.length > 0">
                <template v-for="(file, index) in task.data.files" :key="file.id">
                    <FileItem :file="file"/>
                </template>
            </ul>
            <form enctype="multipart/form-data">
                <label class="cursor-pointer" style="width: 100%;">
                    <input type="file" class="hidden" multiple @change="onChoose">
                    <span class="flex group px-3 py-2 rounded-md cursor-pointer bg-gray-200 text-gray-800" style="float: right; margin-top: 15px; align-items: center;">
                        <svg class="w-4 h-4 group-hover:text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        <span class="ltr:ml-2 rtl:mr-2 text-sm font-medium group-hover:text-gray-800">Добавить файл</span>
                    </span>
                </label>
            </form>
        </div>
      </div>
    </Collapsible>
  </section>
</template>

<script setup>
  import { useTaskStore } from 'Store/task'
  import Collapsible from 'Component/Collapsible.vue'
  import FileItem from './FileItem.vue'
  import FileForm from './FileForm.vue'
  import { ChevronRightIcon } from '@heroicons/vue/outline'
  import {ref} from "vue";

  const props = defineProps({
      id: Number,
      index: Number,
      file: Object,
  })

  const task = useTaskStore(),
      files = ref(props.file ? props.file : []),
      progress = ref({}),
      filePaths = ref({});


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
                  create()
              })
      }
  }

  function create() {
      console.log('create')

      axios.post('tasks/' + task.data.id + '/attachment', {
          'task_id': task.data.id,
          'attachments': filePaths.value,
      })
          .then(data => {
              console.log(filePaths.value);
              console.log('data')
              console.log(data)
              task.data.files.push(data)
              files.value = []
              filePaths.value = {}
              progress.value = {}
          })
  }




</script>

<style scoped>
    form{
        margin-top: 10px;
        display: flex
    }


    form .bg-gray-200{
        margin-top: 0;
    }
</style>
