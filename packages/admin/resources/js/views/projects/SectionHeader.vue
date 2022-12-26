<template>
  <div class="flex items-center py-2.5 px-2">
    <div v-if="show" class="flex-1 ltr:pr-2 rtl:pl-2">
      <input ref="input" type="text" id="list-edit-input" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-sm border-gray-300 rounded-md" v-model="listName" @keyup.enter="submit">
    </div>

    <div class="px-2 font-semibold text-sm text-gray-700 leading-none py-[0.313rem]" v-text="text" v-if="!show"></div>

    <div class="ltr:ml-auto rtl:mr-auto" v-if="can('task-list:update') || can('task-list:delete')">
      <SectionDropdown :list-id="id" :list-index="index" @list-edit="onListEdit"/>
    </div>
  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import SectionDropdown from './SectionDropdown.vue'

  const props = defineProps({
    id: Number,
    index: Number,
    name: String,
  })

  const show = ref(false)
  const listName = ref('')
  const input = ref(null)
  const text = ref(props.name)

  function closeIfClickedOutside(event) {
    console.log('closeIfClickedOutside')
    console.log(event.target.closest('#list-edit-input'))
    if (! event.target.closest('#list-edit-input')) {
      show.value = false
      document.removeEventListener('click', closeIfClickedOutside)
    }
  }

  function onListEdit() {
    show.value = true
    listName.value = text.value
    setTimeout(function () {
      input.value.focus()
      document.addEventListener('click', closeIfClickedOutside)
    })
  }

  function submit() {
    if (!listName.value) return

    axios.patch(`lists/${props.id}`, {
      name: listName.value
    })
      .then(data => {
        text.value = listName.value
        show.value = false
        listName.value = ''
        document.removeEventListener('click', closeIfClickedOutside)
      })
  }
</script>
