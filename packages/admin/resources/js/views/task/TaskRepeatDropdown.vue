<template>
  <v-dropdown name="task-repeat" :modal="true" close-outside :close="closeDropdown" @toggle="onOpen">
    <template #trigger>
      <span class="cursor-pointer">
        <svg class="h-4 w-4 text-gray-600 hover:text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
      </span>
    </template>

    <div class="bottom-0 ltr:origin-bottom-right rtl:origin-bottom-left absolute ltr:right-0 rtl:left-0 mb-6 w-96 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-40" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
      <div class="px-6 py-4">
        <h3 class="font-medium text-gray-700 text-sm mb-6">{{ __('Recurrence') }}</h3>

        <section class="flex items-center">
          <p class="whitespace-nowrap text-sm text-gray-600 mr-6">{{ __('Repeat every') }}</p>

          <input type="number" v-model="form.every" class="w-16 px-2.5 py-1.5 block shadow-sm text-xs border-gray-300 focus:ring-0 focus:border-gray-300 rounded-md mr-2 text-gray-800" min="1" max="99" @change="form.every = Math.max(Math.min(Math.round(form.every), 99), 1)">

          <select v-model="form.type" class="pl-2.5 py-1.5 block text-xs border-gray-300 focus:outline-none focus:ring-0 focus:border-gray-300 rounded-md text-gray-800">
            <option value="daily">Day{{ form.every > 1 ? 's' : '' }}</option>
            <option value="weekly">Week{{ form.every > 1 ? 's' : '' }}</option>
            <option value="monthly">Month{{ form.every > 1 ? 's' : '' }}</option>
            <option value="yearly">Year{{ form.every > 1 ? 's' : '' }}</option>
          </select>
        </section>

        <section class="flex items-center mt-6" v-if="form.type == 'daily'">
          <p class="whitespace-nowrap text-sm text-gray-600 mr-6">{{ __('Hour At') }}</p>

          <select v-model="form.hour_at" class="pl-2.5 py-1.5 block text-gray-800 text-xs border-gray-300 focus:outline-none focus:ring-0 focus:border-gray-300 rounded-md">
            <option v-for="(i, index) in 24" :value="index">{{ index.toString().padStart(2, '0') }}:00</option>
          </select>
        </section>

        <section class="mt-6" v-if="form.type == 'weekly'">
          <p class="whitespace-nowrap text-sm text-gray-600">{{ __('Repeat on') }}</p>

          <div class="flex space-x-2 mt-2.5">
            <span
              v-for="(weekDay, index) in weekDays"
              :key="weekDay.value"
              @click="chooseWeekDay(weekDay.value, index)"
              class="flex items-center justify-center text-xs w-6 h-6 rounded cursor-pointer"
              :class="{ 'border border-gray-300 text-gray-500': !form.repeat_on.includes(weekDay.value), 'bg-indigo-600 text-white': form.repeat_on.includes(weekDay.value) }"
            >
              {{ weekDay.label }}
            </span>
          </div>
        </section>

        <section class="flex items-center mt-6" v-if="form.type == 'monthly'">
          <p class="whitespace-nowrap text-sm text-gray-600 mr-6">{{ __('Day') }}</p>

          <select v-model="form.day_at" class="pl-2.5 py-1.5 block text-gray-800 text-xs border-gray-300 focus:outline-none focus:ring-0 focus:border-gray-300 rounded-md">
            <option v-for="(i, index) in 31" :value="i">{{ i.toString().padStart(2, '0') }}</option>
            <option value="lastday">{{ __('Last Day') }}</option>
          </select>
        </section>

        <section class="flex items-center mt-6" v-if="form.type == 'yearly'">
          <p class="whitespace-nowrap text-sm text-gray-600 mr-6">{{ __('Month') }} / {{ __('Day') }}</p>

          <select v-model="form.month_at" class="pl-2.5 py-1.5 block text-gray-800 text-xs border-gray-300 focus:outline-none focus:ring-0 focus:border-gray-300 rounded-md">
            <option v-for="(month, index) in months" :value="month.value">{{ month.label }}</option>
          </select>

          <select v-model="form.day_at" class="ml-2 pl-2.5 py-1.5 block text-gray-800 text-xs border-gray-300 focus:outline-none focus:ring-0 focus:border-gray-300 rounded-md">
            <option v-for="(i, index) in 31" :value="i">{{ i.toString().padStart(2, '0') }}</option>
            <option value="lastday">{{ __('Last Day') }}</option>
          </select>
        </section>

        <section class="mt-6">
          <p class="whitespace-nowrap text-sm text-gray-600 mb-3">{{ __('Ends') }}</p>

          <div class="space-y-1.5">
            <div class="flex items-center h-[1.875rem]">
              <input id="ends-never" v-model="form.ends" type="radio" value="never" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
              <label for="ends-never" class="ml-3">
                <span class="block text-sm text-gray-600">{{ __('Never') }}</span>
              </label>
            </div>
            <div class="flex items-center">
              <div class="flex items-center w-[9.375rem]">
                <input id="ends-on" v-model="form.ends" type="radio" value="on" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="ends-on" class="ml-3">
                  <span class="block text-sm text-gray-600">{{ __('On') }}</span>
                </label>
              </div>

              <div>
                <FlatPickr
                  id="ends-on-date"
                  v-model="form.ends_at"
                  :disabled="form.ends != 'on'"
                  class="focus:ring-0 focus:border-gray-300 block shadow-sm text-gray-800 text-xs border-gray-300 rounded-md disabled:opacity-50 px-2 py-1.5"
                />
              </div>
            </div>
            <div class="flex items-center">
              <div class="flex items-center w-[9.375rem]">
                <input id="ends-after" v-model="form.ends" type="radio" value="after" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="ends-after" class="ml-3">
                  <span class="block text-sm text-gray-600">{{ __('After') }}</span>
                </label>
              </div>

              <div>
                <div class="flex rounded-md shadow-sm border border-gray-300" :class="{ 'opacity-50': form.ends != 'after' }">
                  <input
                    type="number"
                    placeholder="1"
                    v-model="form.repetitions"
                    class="focus:ring-0 border-0 block w-20 px-2.5 py-1.5 text-xs rounded-md text-gray-800"
                    :disabled="form.ends != 'after'"
                    @change="form.repetitions = Math.max(Math.min(Math.round(form.repetitions), 999), 1)"
                  >

                  <div class="flex items-center pointer-events-none pr-2.5">
                    <span class="text-gray-600 text-xs"> {{ __('Occurences') }} </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="mt-8">
          <!-- <p class="whitespace-nowrap text-sm text-gray-600 mb-4">Completion</p> -->

          <div class="flex items-center">
            <input id="task-completion" type="checkbox" v-model="form.task_completion_required" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
            <label for="task-completion" class="pl-3 text-sm text-gray-600">{{ __('Only if last task was completed') }}</label>
          </div>
        </section>

        <section class="flex justify-start mt-8">
          <v-button
            @click="save"
            size="xs"
            :processing="processing"
          >
            {{ __('Save') }}
          </v-button>

          <button
            type="button"
            class="ltr:ml-1 rtl:mr-1 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-700 hover:text-gray-900 bg-white focus:outline-none focus:ring-0"
            @click="cancel"
          >
            {{ __('Cancel') }}
          </button>
        </section>

        <!-- <section class="flex justify-end mt-6">
          <button
            type="button"
            class="ltr:mr-1 rtl:ml-1 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-700 hover:text-gray-900 bg-white focus:outline-none focus:ring-0"
            @click="cancel"
          >
            {{ __('Cancel') }}
          </button>

          <v-button
            @click="save"
            size="xs"
            :processing="processing"
          >
            {{ __('Save') }}
          </v-button>
        </section> -->
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
  import { reactive, ref } from 'vue'
  import VDropdown from 'Component/Dropdown.vue'
  import { useTaskStore } from 'Store/task'
  import { useDetailStore } from 'Store/detail'
  import FlatPickr from '@/flatpickr.js'

  const task = useTaskStore(),
    projectDetail = useDetailStore('project')(),
    processing = ref(false),
    closeDropdown = ref(false),
    defaultForm = {
      type: 'daily',
      every: 1,
      hour_at: 0,
      day_at: 1,
      month_at: 1,
      repeat_on: [],
      task_completion_required: true,
      ends_at: null,
      repetitions: 1,
      ends: 'never',
    },
    months = [
      { label: 'Jan', value: 1 },
      { label: 'Feb', value: 2 },
      { label: 'Mar', value: 3 },
      { label: 'Apr', value: 4 },
      { label: 'May', value: 5 },
      { label: 'Jun', value: 6 },
      { label: 'Jul', value: 7 },
      { label: 'Aug', value: 8 },
      { label: 'Sep', value: 9 },
      { label: 'Oct', value: 10 },
      { label: 'Nov', value: 11 },
      { label: 'Dec', value: 12 },
    ],
    weekDays = [
      { label: 'M', value: 'Mon' },
      { label: 'T', value: 'Tue' },
      { label: 'W', value: 'Wed' },
      { label: 'T', value: 'Thu' },
      { label: 'F', value: 'Fri' },
      { label: 'S', value: 'Sat' },
      { label: 'S', value: 'Sun' },
    ],
    form = reactive({ ...defaultForm })

  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }

  function chooseWeekDay(weekDay, index) {
    if (form.repeat_on.includes(weekDay)) {
      form.repeat_on.splice(form.repeat_on.indexOf(weekDay), 1)
    } else {
      form.repeat_on.push(weekDay)

      // console.log('weekDay:', weekDay)
      // console.log('index:', index)

      // form.repeat_on.splice(index, 0, weekDay)
    }

    console.log(form.repeat_on)
  }

  function save() {
    console.log('save!')
    processing.value = true

    axios.post(`tasks/${task.data.id}/recurring`, {
      ...form
    })
      .then(data => {
        console.log('data')
        console.log(data)
        processing.value = false
        closeDropdown.value = true
        Object.assign(task.data, data)
      })
      .catch(error => {
        processing.value = false
      })
  }

  function cancel() {
    console.log('cancel!')
    // console.log( closeDropdown.value )
    closeDropdown.value = true
    // console.log( closeDropdown.value )
  }

  function onOpen() {
    console.log('hit onOpen!')
    console.log(task.data.meta?.recurring)
    console.log(form)
    console.log(defaultForm)

    closeDropdown.value = false

    task.data.meta?.recurring ? updateForm() : resetForm()
  }

  function resetForm() {
    console.log('resetForm!')

    Object.assign(form, defaultForm)
    console.log(form)
  }

  function updateForm() {
    console.log('updateForm!')

    Object.assign(form, task.data.meta.recurring)
  }
</script>
