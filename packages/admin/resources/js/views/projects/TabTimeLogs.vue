<template>
  <div class="pb-8">
    <div class="flex items-center mt-2 mb-6" :class="{'opacity-50': loading}">
      <span class="text-gray-700">{{ __('Total logged time') }}:</span>
      <span class="ltr:ml-2 rtl:mr-2 text-gray-700 font-semibold">{{ totalTime }}</span>
      <a :href="`/api/projects/${detail.data.id}/export-time-logs`" class="ltr:ml-auto rtl:mr-auto inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Export CSV') }}</a>
    </div>

    <v-index name="timelog" :uri="`projects/${detail.data.id}/time-logs`" v-slot="{ items, index }" no-search no-filters>
      <div class="shadow border-b border-gray-200 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-6 py-3 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider ltr:text-left rtl:text-right">
                {{ __('Task') }}
              </th>
              <th class="px-6 py-3 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider ltr:text-left rtl:text-right">
                {{ __('Assignee') }}
              </th>
              <th class="px-6 py-3 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider ltr:text-left rtl:text-right">
                {{ __('Start') }}
              </th>
              <th class="px-6 py-3 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider ltr:text-left rtl:text-right">
                {{ __('Stop') }}
              </th>
              <th class="px-6 py-3 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider ltr:text-left rtl:text-right">
                {{ __('Time') }}
              </th>
              <th class="px-6 py-3 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider ltr:text-left rtl:text-right">
                {{ __('Description') }}
              </th>
              <th class="px-6 py-3">&nbsp;</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="item in items" :key="item.id">
              <td class="align-top px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                <p class="hover:text-gray-700 cursor-pointer" @click="openModal(item.task_id)">{{ item.task.title }}</p>
              </td>
              <td class="align-top px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                <div class="flex items-center">
                  <UserAvatar class="w-6 h-6" :user="item.user"/>
                  <span class="ltr:ml-2 rtl:mr-2">{{ item.user.name }}</span>
                </div>
              </td>

              <td class="align-top px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                {{ item.started_at }}
              </td>
              <td class="align-top px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                {{ item.stopped_at }}
              </td>
              <td class="align-top px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                <p>{{ item.time }}</p>
                {{ item.is_manual ? '(manual)' : '' }}
              </td>
              <td class="align-top px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                {{ item.description || '—' }}
              </td>

              <td class="px-6 py-3 text-right">
                &nbsp;
              </td>
            </tr>
          </tbody>
        </table>

        <v-index-pagination class="rounded-b-lg" :index="index"/>
      </div>
    </v-index>
  </div>
</template>

<script setup>
  import { ref, markRaw, computed } from 'vue'
  import UserAvatar from 'Component/UserAvatar.vue'
  import { useModalStore } from 'Store/modal'
  import TaskModal from '../task/TaskModal.vue'
  import { useDetailStore } from 'Store/detail'
  import { useIndexStore } from 'Store/index'

  const detail = useDetailStore('project')()
  const index = useIndexStore('timelog')()
  const loading = ref(true)
  const totalTime = ref('00:00:00')

  // const indexLoaded = computed(() => {
  //   return index.loading ? false : true
  // })

  getTotalTime()

  function openModal(id = null) {
    useModalStore().show(markRaw(TaskModal), {id, width: 'max-w-3xl'})
  }

  function getTotalTime() {
    axios.get('projects/' + detail.data.id + '/total-time')
      .then(data => {
        console.log(data)

        const decimalTimeString = data
        const n = new Date(0, 0)
        n.setSeconds(+decimalTimeString)
        totalTime.value = n.toTimeString().slice(0, 8)
        loading.value = false
      })
  }
</script>
