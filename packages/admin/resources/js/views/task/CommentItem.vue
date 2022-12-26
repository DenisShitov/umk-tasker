<template>
  <div class="relative group flex py-1">
    <div class="w-6 h-6">
      <UserAvatar class="w-6 h-6" :user="comment.user" />
    </div>
    <div class="flex-1 ltr:pl-4 rtl:pr-4 group">
      <div class="flex">
        <h2 class="flex leading-none font-medium text-sm text-gray-700">
          {{ comment.user.name }}
          <span class="font-normal ltr:ml-3 rtl:mr-3 text-gray-500 text-xs">{{ comment.updated_at }}</span>
        </h2>
      </div>

      <p class="mt-1.5 prose prose-sm text-gray-600 text-sm break-all" v-html="marked.parse(comment.text || '', { breaks: true, renderer })"></p>

      <ul class="mt-4 mb-1 border rounded-md divide-y" v-if="comment.attachments.length">
        <li class="flex items-center py-2 px-3" v-for="attachment in comment.attachments">
          <div class="flex items-center flex-1">
            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
            </svg>
            <a :href="'/' + attachment.path" class="block ltr:ml-2 rtl:mr-2 flex-1 w-0 truncate text-xs text-gray-700 hover:underline ltr:pr-2 rtl:pl-2" target="blank">
              {{ attachment.name }}
            </a>
          </div>
          <a :href="'/' + attachment.path" class="ltr:ml-auto rtl:mr-auto" target="blank">
            <DownloadIcon class="h-5 w-5 text-gray-400"/>
          </a>
        </li>
      </ul>
    </div>


    <div class="absolute flex items-center right-0 bg-white pl-4" :class="{ 'opacity-50': processing }" v-if="deleteConfirmation">
      <span class="text-gray-600 text-sm mr-2">{{ __('Are you sure to delete?') }}</span>
      <CheckCircleIcon class="w-5 h-5 text-green-600 cursor-pointer hover:text-green-800 mr-1" @click="deleteComment"/>
      <XCircleIcon class="w-5 h-5 text-red-600 cursor-pointer hover:text-red-800" @click="deleteConfirmation = false"/>
    </div>

    <div class="absolute hidden group-hover:flex right-0 bg-white pl-4" v-else>
      <!-- <span @click="task.commentForm = index" class="mr-1">
        <PencilAltIcon class="w-4 h-4 text-gray-500 cursor-pointer hover:text-gray-900"/>
      </span> -->
      <TrashIcon class="w-4 h-4 text-gray-500 cursor-pointer hover:text-gray-900" @click="deleteConfirmation = true"/>
    </div>





    <!-- <div class="w-4" v-if="config.user.id == comment.author_id">
      <span @click="onDelete(comment.id, index)">
        <TrashIcon class="w-4 h-4 text-gray-500 hover:text-gray-800 cursor-pointer"/>
      </span>
    </div> -->
  </div>
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
