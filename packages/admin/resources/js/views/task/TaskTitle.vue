<template>
    <div @click="task.isContentFormTitle = true">
        <h2 class="text-base">
            {{ task.data.title }}
        </h2>
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



<style scoped>
    h2{
        border-radius: 0.375rem;
        border-width: 1px;
        font-size: .875rem;
        line-height: 1.25rem;
        padding: 0.5rem;
        width: 100%;
        max-width: unset;
    }
</style>
