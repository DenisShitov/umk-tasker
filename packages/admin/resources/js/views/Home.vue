<template>
  <div class="flex justify-center mt-8" v-if="loading">
    <v-loader size="40" color="#5850ec"/>
  </div>

  <div v-else>
    <h1 class="text-2xl font-semibold text-gray-900" data-cy="page-title">{{ __('Dashboard') }}</h1>

    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
      <div class="relative bg-white py-5 px-4 sm:py-6 sm:px-6 shadow rounded-lg overflow-hidden">
        <dt>
          <div class="absolute bg-indigo-500 rounded-md p-3">
            <inbox-icon class="w-6 h-6 text-white"/>
          </div>
          <p class="ltr:ml-16 rtl:mr-16 text-sm font-medium text-gray-500 truncate">{{ __('Open Tasks') }}</p>
        </dt>
        <dd class="ltr:ml-16 rtl:mr-16 flex items-baseline">
          <p class="text-2xl font-semibold text-gray-900">
            {{ metrics.open_tasks }}
          </p>
        </dd>
      </div>

      <div class="relative bg-white py-5 px-4 sm:py-6 sm:px-6 shadow rounded-lg overflow-hidden">
        <dt>
          <div class="absolute bg-indigo-500 rounded-md p-3">
            <CheckCircleIcon class="w-6 h-6 text-white"/>
          </div>
          <p class="ltr:ml-16 rtl:mr-16 text-sm font-medium text-gray-500 truncate">{{ __('Completed Tasks') }}</p>
        </dt>
        <dd class="ltr:ml-16 rtl:mr-16 flex items-baseline">
          <p class="text-2xl font-semibold text-gray-900">
            {{ metrics.completed_tasks }}
          </p>
        </dd>
      </div>

      <div class="relative bg-white py-5 px-4 sm:py-6 sm:px-6 shadow rounded-lg overflow-hidden">
        <dt>
          <div class="absolute bg-indigo-500 rounded-md p-3">
            <calendar-icon class="w-6 h-6 text-white"/>
          </div>
          <p class="ltr:ml-16 rtl:mr-16 text-sm font-medium text-gray-500 truncate">{{ __('Total Projects') }}</p>
        </dt>
        <dd class="ltr:ml-16 rtl:mr-16 flex items-baseline">
          <p class="text-2xl font-semibold text-gray-900">
            {{ metrics.total_projects }}
          </p>
        </dd>
      </div>
    </dl>

    <div class="grid grid-cols-12 gap-4 sm:gap-8 mt-4 sm:mt-8">
      <div class="col-span-12 sm:col-span-6">
        <v-card class="ltr:pl-4 ltr:pr-3 rtl:pr-4 rtl:pl-3 py-4">
          <h3 class="mb-4 font-medium">{{ __('Completed in the last 7 days') }}</h3>

          <div style="height: 300px;">
            <line-chart id="tasks-chart" :data="chart_tasks_weekly" tooltip-label="Tasks" background-color="rgba(79, 70, 229, 0.2)" border-color="#4F46E5"/>
          </div>
        </v-card>
      </div>

      <div class="col-span-12 sm:col-span-6">
        <v-card class="ltr:pl-4 ltr:pr-3 rtl:pr-4 rtl:pl-3 py-4">
          <h3 class="mb-4 font-medium">{{ __('Most productive month') }}</h3>

          <div style="height: 300px;">
            <line-chart id="tasks-chart-yearly" :data="chart_tasks_yearly" tooltip-label="Tasks" background-color="rgba(79, 70, 229, 0.2)" border-color="#4F46E5"/>
          </div>
        </v-card>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { ref, inject } from 'vue'
  import LineChart from 'Component/LineChart.vue'
  import { InboxIcon, CalendarIcon, FolderIcon, CheckCircleIcon } from '@heroicons/vue/outline'

  const metrics = ref({}),
    loading = ref(true),
    chart_tasks_weekly = ref({}),
    chart_tasks_yearly = ref({}),
    trans = inject('__')

  axios.get('metrics')
    .then(data => {
      metrics.value = data
      loading.value = false

      for (const property in metrics.value.chart_tasks_weekly) {
        chart_tasks_weekly.value[trans(property)] = metrics.value.chart_tasks_weekly[property]
      }

      for (const property in metrics.value.chart_tasks_yearly) {
        chart_tasks_yearly.value[trans(property)] = metrics.value.chart_tasks_yearly[property]
      }
    })
</script>
