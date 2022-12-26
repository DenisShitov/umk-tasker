<template>
  <div id="kanban-wrapper" class="flex-1 relative">
    <div id="container" class="absolute inset-0 overflow-x-auto overflow-y-hidden whitespace-nowrap select-none text-[0] transition-opacity">
      <section id="section-draggable" v-for="(list, index) in detail.data.lists" :key="list.id" :data-id="list.id" class="inline-block rounded whitespace-nowrap w-72 box-border text-base align-top h-full ltr:mr-4 rtl:ml-4">
        <div class="bg-gray-200 rounded flex flex-col whitespace-normal box-border max-h-full">
          <SectionHeader :id="list.id" :name="list.name" :index="index"/>
          <div :id="'list-' + index" :data-id="list.id" class="overflow-y-auto min-h-0 px-2">
            <ListItem v-for="task in list.tasks" :task="task"/>
          </div>
          <TaskFormQuick :project-id="list.project_id" :list-id="list.id" :list-index="index"/>
        </div>
      </section>

      <section class="inline-block whitespace-nowrap w-72 box-border text-base align-top h-full" v-if="can('task-list:create')">
        <div class="border-dashed border-2 border-gray-300 rounded px-2 py-1.5 flex items-center cursor-pointer hover:border-gray-400" @click="handleShowListForm" v-show="!showListForm">
          <svg class="w-6 h-6 text-gray-600" viewBox="0 0 21 21" fill="currentColor"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="m5.5 10.5h10"></path><path d="m10.5 5.5v10"></path></g></svg>
          <span class="ltr:ml-2 rtl:mr-2 text-sm text-gray-700">{{ __('Add list') }}</span>
        </div>

        <div class="bg-gray-200 rounded whitespace-normal box-border max-h-full" v-show="showListForm">
          <div class="py-2.5 px-2">
            <input ref="listinput" type="text" placeholder="Enter list title..." class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-sm border-gray-300 rounded-md" v-model="listName" @keyup.enter="addList">
            <div class="flex mt-1">
              <v-button size="xs" @click="addList" :processing="listFormProcessing">{{ __('Add list') }}</v-button>
              <v-button class="ltr:ml-1 rtl:mr-1" white size="xs" @click="showListForm = false; listName = ''" :disabled="listFormProcessing">{{ __('Cancel') }}</v-button>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
  import Sortable from 'sortablejs'
  import { ref, onMounted, inject } from 'vue'
  import { useDetailStore } from 'Store/detail'
  import SectionHeader from './SectionHeader.vue'
  import ListItem from './ListItem.vue'
  import TaskFormQuick from './TaskFormQuick.vue'

  const detail = useDetailStore('project')()
  const showListForm = ref(false)
  const listEdit = ref(null)
  const listEditName = ref('')
  const listName = ref('')
  const listinput = ref(null)
  const listeditinput = ref(null)
  const listFormProcessing = ref(false)
  console.log(detail.data.lists)

  function onListEdit(payload) {
    console.log('onListEdit!')
    console.log(payload)
    listEdit.value = payload.id
    listEditName.value = payload.name
    // console.log( listeditinput.value )
    setTimeout(function () {
    //   listeditinput.value.focus()
      console.log( listeditinput.value )
    }, 1000)
  }

  function handleShowListForm() {
    console.log('handleShowListForm')
    showListForm.value = true
    setTimeout(function () {
      listinput.value.focus()
    })
    // listinput.value.focus()
    // console.log( listinput.value )
    // const listinput = ref()
    // console.log('listinput')
    // console.log(listinput)
    // console.log(listinput.value)
    // listinput.focus()
    // console.log($refs.listinput)
    // showListForm = true; console.log($refs.listinput);
  }

  function listSortableInit() {
    const i = detail.data.lists.length - 1
    console.log( i )

    setTimeout(function () {
      Sortable.create(document.getElementById(`list-${i}`), {
        group: 'shared',
        delay: 300, // time in milliseconds to define when the sorting should start
        delayOnTouchOnly: true, // only delay if user is using touch
        touchStartThreshold: 100, // px, how many pixels the point should move before cancelling a delayed drag event
        onUpdate: function (evt) {
          console.log('onUpdate!!')
          // al.updateTaskListSort(evt.item.getAttribute('data-id'), evt.item.parentElement.getAttribute('data-id'), evt.oldIndex, evt.newIndex)

          console.log( evt.item.parentElement.getAttribute('data-id') )
          console.log( evt.item.getAttribute('data-id') )

          axios.patch(`tasks/${evt.item.getAttribute('data-id')}/sort`, {
            id: evt.item.getAttribute('data-id'),
            projectId: detail.data.id,
            oldIndex: evt.oldIndex,
            newIndex: evt.newIndex,
          })
            .then(data => {
              console.log('data')
              console.log(data)
            })
        },
        onAdd: function (evt) {
          console.log('onAdd!!')
          // al.updateTaskListSortOtherList(evt.item.getAttribute('data-id'), evt.from.getAttribute('data-id'), evt.to.getAttribute('data-id'), evt.oldIndex, evt.newIndex)

          const taskId = evt.item.getAttribute('data-id')

          axios.patch(`tasks/${taskId}/move`, {
            projectId: detail.data.id,
            fromList: evt.from.getAttribute('data-id'),
            toList: evt.to.getAttribute('data-id'),
            oldIndex: evt.oldIndex,
            newIndex: evt.newIndex,
          })
            .then(data => {
              console.log('data')
              console.log(data)
            })
        },
      })
    })
  }

  function addList() {
    if (!listName.value) return
    console.log('addList')
    listFormProcessing.value = true
    axios.post('projects/'+detail.data.id+'/lists', {
      name: listName.value
    })
      .then(data => {
        console.log(data)
        showListForm.value = false
        listName.value = ''
        detail.data.lists.push(data)
        listFormProcessing.value = false
        listSortableInit()
      })
  }

  let draggablesArray
  let draggingItem
  let draggingItemEvent
  let draggingItemX
  let oldIndex
  let newIndex

  const can = inject('can')

  onMounted(function () {
    document.querySelector('#kanban-wrapper').style.height = (window.innerHeight - (64 + 24 + 48 + 16 + 24)) + 'px'

    if (can('task-list:update')) {
      const sortable = Sortable.create(document.getElementById('container'), {
        draggable: '#section-draggable',
        onUpdate: function (evt) {
          console.log('onUpdate!')
          console.log( evt )
          console.log( evt.item.getAttribute('data-id') )
          console.log( evt.oldIndex )
          console.log( evt.newIndex )
          axios.patch(`projects/${detail.data.id}/list-sort`, {
            id: evt.item.getAttribute('data-id'),
            oldIndex: evt.oldIndex,
            newIndex: evt.newIndex,
          })
            .then(data => {
              console.log('data')
              console.log(data)
              console.log( detail.data.lists )
              detail.data.lists = data
            })
        }
      })

      for (let i = 0; i < detail.data.lists.length; i++) {
        const list = detail.data.lists[i]

        Sortable.create(document.getElementById(`list-${i}`), {
          group: 'shared',
          delay: 300, // time in milliseconds to define when the sorting should start
          delayOnTouchOnly: true, // only delay if user is using touch
          touchStartThreshold: 100, // px, how many pixels the point should move before cancelling a delayed drag event
          onUpdate: function (evt) {
            console.log('onUpdate!!')
            // al.updateTaskListSort(evt.item.getAttribute('data-id'), evt.item.parentElement.getAttribute('data-id'), evt.oldIndex, evt.newIndex)

            console.log( evt.item.parentElement.getAttribute('data-id') )
            console.log( evt.item.getAttribute('data-id') )

            axios.patch(`tasks/${evt.item.getAttribute('data-id')}/sort`, {
              id: evt.item.getAttribute('data-id'),
              projectId: detail.data.id,
              oldIndex: evt.oldIndex,
              newIndex: evt.newIndex,
            })
              .then(data => {
                console.log('data')
                console.log(data)
              })
          },
          onAdd: function (evt) {
            console.log('onAdd!!')
            // al.updateTaskListSortOtherList(evt.item.getAttribute('data-id'), evt.from.getAttribute('data-id'), evt.to.getAttribute('data-id'), evt.oldIndex, evt.newIndex)

            const taskId = evt.item.getAttribute('data-id')

            axios.patch(`tasks/${taskId}/move`, {
              projectId: detail.data.id,
              fromList: evt.from.getAttribute('data-id'),
              toList: evt.to.getAttribute('data-id'),
              oldIndex: evt.oldIndex,
              newIndex: evt.newIndex,
            })
              .then(data => {
                console.log('data')
                console.log(data)
              })
          },
        })
      }
    }




    // const draggables = document.querySelectorAll('#section-draggable')
    // const container = document.querySelector('#container')
    // draggablesArray = Array.prototype.slice.call(draggables)

    // draggables.forEach(draggable => {
    //   draggable.addEventListener('dragstart', dragstart)
    //   draggable.addEventListener('dragend', dragend)
    //   draggable.addEventListener('dragover', dragover)
    //   draggable.addEventListener('drop', drop)
    // })

    // List draggables
    // const listContainer = document.querySelector('#list')
    // const listDraggables = document.querySelectorAll('#list-item')
    // console.log( listContainer )
    // console.log( listDraggables )
    // draggablesArray = Array.prototype.slice.call(draggables)

    // draggables.forEach(draggable => {
    //   draggable.addEventListener('dragstart', dragstart)
    //   draggable.addEventListener('dragend', dragend)
    //   draggable.addEventListener('dragover', dragover)
    //   draggable.addEventListener('drop', drop)
    // })
  })

  function dragstart() {
    draggingItem = this
    draggingItemX = event.clientX
    draggingItemEvent = event
    oldIndex = draggablesArray.indexOf(this)
    setTimeout(function () {
        draggingItem.classList.add('dragging')
    })
  }

  function dragend() {
    this.classList.remove('dragging')
  }

  function dragover() {
    event.preventDefault()
    console.log(draggingItem.getBoundingClientRect().x)
    console.log(event.x)

    if (draggingItem.getBoundingClientRect().x < event.x) {
        console.log('right')
        // console.log('this', this)
        // console.log('nextSibling', this.nextSibling)
        container.insertBefore(draggingItem, this.nextSibling)
    } else {
        console.log('left')
        container.insertBefore(draggingItem, this)
    }
  }

  function drop() {
    console.log(oldIndex);
    console.log(this);
    const draggables = [...document.querySelectorAll('#section-draggable')]
    console.log(draggables)
    console.log( draggables.indexOf(this) )

    newIndex = draggables.indexOf(this)

    // hit api

    // Livewire.emitTo('temp', 'listSort', this.getAttribute('data-id'), oldIndex, newIndex)
    // if (this.nextSibling) {
    //     if (draggingItemX < e.clientX) {
    //         // insert after
    //         console.log('insert after')
    //         document.querySelector('#container').insertBefore(draggingItem, this.nextSibling)
    //     } else {
    //         // insert before
    //         console.log('insert before')
    //         document.querySelector('#container').insertBefore(draggingItem, this)
    //     }
    // } else {
    //     console.log('appendChild')
    //     document.querySelector('#container').appendChild(draggingItem)
    // }

    // this.classList.remove('drag-over');
  }
</script>

<style scoped>

</style>
