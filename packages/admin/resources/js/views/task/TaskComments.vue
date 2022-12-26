<template>
  <section id="comments" class="mt-8">
    <Collapsible :open="false">
      <template #trigger="{ open }">
        <div class="flex">
          <svg class="w-4 h-4 mr-4 text-gray-500 mt-1 cursor-pointer" :class="{ 'rotate-[270deg]': !open }" viewBox="0 0 16 16"><path d="M14 5.758L13.156 5 7.992 9.506l-.55-.48.002.002-4.588-4.003L2 5.77 7.992 11 14 5.758" fill="currentColor"></path></svg>

          <div class="flex-1 border-b pb-2">
            <span class="font-medium text-sm text-gray-800">{{ __('Comments') }}</span>
            <span class="text-sm font-light ml-2 text-gray-600">{{ task.data.comments.length }}</span>
          </div>
        </div>
      </template>

      <div class="pl-8 pt-4">
        <CommentForm/>

        <div class="space-y-4">
          <template v-for="(comment, index) in task.data.comments" :key="comment.id">
            <Component :is="task.commentForm == index ? CommentForm : CommentItem" :index="index" :id="comment.id" :comment="comment"/>
          </template>
        </div>
      </div>
    </Collapsible>
  </section>
</template>

<script setup>
  import { useTaskStore } from 'Store/task'
  import Collapsible from 'Component/Collapsible.vue'
  import CommentItem from './CommentItem.vue'
  import CommentForm from './CommentForm.vue'
  import { ChevronRightIcon } from '@heroicons/vue/outline'

  const task = useTaskStore()
</script>
