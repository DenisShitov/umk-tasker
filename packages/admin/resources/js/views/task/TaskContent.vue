<template>
  <div @click="task.isContentForm = true">
    <h2 class="text-base font-semibold text-gray-800">
      {{ task.data.title }}
    </h2>

    <article
      class="mt-2 prose prose-sm text-gray-700 text-sm break-all"
      v-if="task.data.description"
      v-html="marked.parse(task.data.description || '', { breaks: true, renderer })"
    ></article>

    <p class="flex items-center text-gray-500 text-sm mt-4 font-light" v-else>
      <MenuAlt2Icon class="h-4 w-4 mr-2"/>

      {{ __('Description') }}
    </p>
  </div>
</template>

<script setup>
  import { marked } from 'marked'
  import { useTaskStore } from 'Store/task'
  import { MenuAlt2Icon } from '@heroicons/vue/outline'

  const task = useTaskStore()

  const renderer = new marked.Renderer()
  const linkRenderer = renderer.link
  renderer.link = (href, title, text) => {
    const html = linkRenderer.call(renderer, href, title, text);
    return html.replace(/^<a /, `<a onclick="event.stopPropagation()" target="_blank" rel="noreferrer noopener nofollow" `)
  }
</script>
