<template>
  <v-field-base :inline="inline" :label="label" :name="name" :lg="lg" :full="full">
    <div
      :class="{ 'border-gray-600': isDragOver, 'border-gray-300': !isDragOver, 'sm:max-w-full': full, 'sm:max-w-lg': lg, 'max-w-lg sm:max-w-xs': inline }"
      class="flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-md"
      @dragover="onDragOver"
      @drop="onDrop"
      @dragleave="onDragLeave"
    >
      <div class="text-center">
        <img class="w-full rounded-md mb-3" :src="src || form.data[name]" v-if="src || form.data[name]">
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true" v-else>
          <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>

        <div class="bg-green-100 w-full rounded-md mb-6" v-if="progress">
          <span class="block bg-green-400 rounded-md h-2" :style="{ width: progress + '%' }"></span>
        </div>

        <div class="flex justify-center text-sm text-gray-600">
          <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
            <span>Upload an image</span>
            <input type="file" id="file-upload" name="file-upload" class="sr-only" accept=".png,.jpg,.gif" @change="onChoose">
          </label>
          <p class="pl-1">or drag and drop</p>
        </div>
        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 1MB</p>
      </div>
    </div>
  </v-field-base>
</template>

<script>
  import { ref, inject } from 'vue'
  import { useFormStore } from 'Store/form'

  export default {
    props: {
      label: String,
      name: String,
      imgName: String,
      description: String,
      inline: Boolean,
      lg: Boolean,
      full: Boolean,
      width: String,
      height: String,
      size: String,
    },

    setup(props) {
      const
        formName = inject('form_name'),
        form = useFormStore(formName)(),
        isDragOver = ref(false),
        progress = ref(0),
        files = ref([]),
        src = ref()

      function isNotValid(file, img, target = null) {
        // Check Size
        if (props.size.match(/MB$/)) {
          const checkSize = file.size <= parseInt(props.size) * 1024 * 1024
          if (!checkSize) {
            alert('Allowed file size is up to ' + props.size)
            target ? target.value = null : ''
            return true
          }
        } else if (props.size.match(/KB$/)) {
          const checkSize = file.size <= parseInt(props.size) * 1024
          if (!checkSize) {
            alert('Allowed file size is ' + props.size)
            target ? target.value = null : ''
            return true
          }
        }

        // Check dimension
        if (img.width > props.width || img.height > props.height) {
          alert('you can upload max ' + props.width + ' x ' + props.height)
          target ? target.value = null : ''
          return true
        }

        return false
      }

      function onDragOver(e) {
        e.preventDefault()
        isDragOver.value = true
      }

      function onDragLeave(e) {
        e.preventDefault()
        isDragOver.value = false
      }

      function onDrop(e) {
        e.preventDefault()
        isDragOver.value = false
        files.value = e.dataTransfer.files
        handle()
      }

      function onChoose(e) {
        e.preventDefault()
        files.value = e.target.files
        handle(e.target)
      }

      function handle(target = null) {
        if (! files.value.length) return

        const file = files.value[0],
          reader = new FileReader(),
          img = new Image

        reader.readAsDataURL(file)
        reader.onload = e => {
          img.src = e.target.result

          img.onload = function() {
            if (isNotValid(file, img, target)) return

            src.value = e.target.result

            const formData = new FormData()
            formData.append('image', file)

            if (props.imgName)
              formData.append('name', props.imgName)

            axios.post('image', formData, {
              onUploadProgress: function(progressEvent) {
                progress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total)
              }
            })
              .then(data => {
                target.value = null
                form.data[props.name] = data
              })
          }
        }
      }

      return {
        form, onDragOver, onDragLeave, onDrop, onChoose, isDragOver, src, progress
      }
    }
  }
</script>
