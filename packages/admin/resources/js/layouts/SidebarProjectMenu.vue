<template>
  <v-dropdown :name="'sidebar-project-menu-' + id" @toggle="onToggle">
    <template #trigger>
      <span class="text-gray-400 hover:text-gray-200">
        <DotsHorizontalIcon class="w-4 h-4"/>
      </span>
    </template>

    <div class="bottom-6 ltr:origin-bottom-right rtl:origin-bottom-left absolute ltr:right-0 rtl:left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-40" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <div class="py-1" role="none">
        <button class="w-full text-left px-4 py-1.5 text-xs leading-5 font-normal text-gray-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" @click.prevent="favorite">
          {{ isFavoriteProject ? __('Remove favorite') : __('Add to favorite') }}
        </button>
        <button class="w-full text-left px-4 py-1.5 text-xs leading-5 font-normal text-gray-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" @click.prevent="openModal">{{ __('Edit') }}</button>
        <button class="w-full text-left px-4 py-1.5 text-xs leading-5 font-normal text-gray-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" @click.prevent="onArchive">{{ __('Archive') }}</button>
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
  import VDropdown from 'Component/Dropdown.vue'
  import { PlusIcon, DotsHorizontalIcon } from '@heroicons/vue/outline'
  import { useFlashStore } from 'Store/flash'
  import { useFavoriteStore } from 'Store/favorite'
  import { useProjectStore } from 'Store/project'
  import { useProjectArchiveStore } from 'Store/project-archive'
  import { ref, markRaw } from 'vue'
  import { useModalStore } from 'Store/modal'
  import Form from 'View/projects/Form.vue'

  const props = defineProps({
    id: Number,
    isFavorite: Object,
    index: Number,
  })

  const emit = defineEmits(['toggleMenu'])

  const isFavoriteProject = ref(props.isFavorite)
  const project = useProjectStore()
  const archive = useProjectArchiveStore()

  function favorite() {
    axios.patch('/projects/'+props.id+'/favorite')
      .then(data => {
        console.log(data)
        useFlashStore().flash(data.message)
        useFavoriteStore().items = data.favorites.favorites
        isFavoriteProject.value = data.favorite
      })
  }

  function openModal(id = null) {
    useModalStore().show(markRaw(Form), props.id)
  }

  function onArchive() {
    axios.patch(`projects/${props.id}/archive`)
      .then(data => {
        useFlashStore().flash(data.message)
        archive.items.push(data.project)
        project.items.splice(props.index, 1)

        const favoriteIndex = useFavoriteStore().items.findIndex(x => x.project_id == props.id)

        if (favoriteIndex > -1) {
          useFavoriteStore().items.splice(favoriteIndex, 1)
        }
      })
  }

  function onToggle(state) {
    emit('toggleMenu', {
      state,
      index: props.index
    })
  }
</script>
