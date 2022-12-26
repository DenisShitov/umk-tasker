<template>

    <li class="flex items-center py-2 px-3">
        <div class="flex items-center flex-1">
            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path>
            </svg>
            <a :href="'/' + file.path" class="block ltr:ml-2 rtl:mr-2 flex-1 w-0 truncate text-xs text-gray-700 hover:underline ltr:pr-2 rtl:pl-2" target="blank">{{ file.name }}</a>
        </div>
        <a :href="'/' + file.path" class="ltr:ml-auto rtl:mr-auto" target="blank">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-5 w-5 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
        </a>
    </li>
</template>

<script setup>
  import { ref } from 'vue'
  import { marked } from 'marked'
  import { useTaskStore } from 'Store/task'
  import UserAvatar from 'Component/UserAvatar.vue'
  import { PencilAltIcon, TrashIcon, XCircleIcon, CheckCircleIcon, DownloadIcon } from '@heroicons/vue/outline'

  const props = defineProps({
    id: Number,
    index: Number,
    comment: Object,
      file: Object,
  })

  const renderer = new marked.Renderer()
  const linkRenderer = renderer.link
  renderer.link = (href, title, text) => {
    const html = linkRenderer.call(renderer, href, title, text);
    return html.replace(/^<a /, `<a target="_blank" rel="noreferrer noopener nofollow" `)
  }

  const task = useTaskStore(),
    deleteConfirmation = ref(false),
    processing = ref(false),
    config = Config

  function deleteComment() {
    if (processing.value) return

    processing.value = true

    axios.delete(`comments/${props.id}`)
      .then(data => {
        processing.value = false
        if (!data.success) return
        task.data.comments.splice(props.index, 1)
      })
  }
</script>
