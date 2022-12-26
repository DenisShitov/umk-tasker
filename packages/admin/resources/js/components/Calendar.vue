<template>
  <div class="min-w-[18rem] max-w-sm w-full rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5">
    <div class="p-4 flex items-center justify-between leading-8">
      <h1 class="text-base font-medium text-gray-800 dark:text-gray-100">{{ __(months[month]) }} {{ year }}</h1>
      <div class="flex items-center text-gray-800 dark:text-gray-100">
        <span class="cursor-pointer hover:text-gray-500" @click="prev">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <polyline points="15 6 9 12 15 18"></polyline>
          </svg>
        </span>
        <span class="cursor-pointer hover:text-gray-500" @click="next">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler ml-3 icon-tabler-chevron-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <polyline points="9 6 15 12 9 18"></polyline>
          </svg>
        </span>
      </div>
    </div>

    <ol class="px-2 grid grid-cols-7 pb-2">
      <li v-for="weekDay in weekDays" :key="weekDay" class="text-sm font-medium text-center text-gray-800 pb-2">{{ weekDay }}</li>
      <li class="flex items-center justify-center py-1" :style="{ gridColumnStart: firstWeekDayOfTheMonth }" v-if="firstWeekDayOfTheMonth">&nbsp;</li>

      <li v-for="day in days" :key="day" class="flex items-center justify-center py-1">
        <p
          class="flex items-center justify-center text-sm font-medium cursor-pointer rounded-full w-6 h-6"
          :class="{ 'text-white bg-indigo-700': day == selected, 'text-gray-500 hover:bg-gray-200': day != selected, 'bg-gray-200': day == currentDay }"
          @click="select(day), $emit('selected', {day: ('0' + day).slice(-2), month: ('0' + (month+1)).slice(-2), year, date: `${year}-${('0' + (month+1)).slice(-2)}-${('0' + day).slice(-2)}`, label: `${shortMonths[month]} ${day}, ${year}`})"
        >
          {{ day }}
        </p>
      </li>
    </ol>
  </div>
</template>

<script>
  import { ref, onMounted } from 'vue'

  export default {
    emits: ['selected'],

    props: {
      date: String,
    },

    setup(props) {
      const today = props.date ? new Date(props.date) : new Date(),
            dayInt = ref(today.getDate()),
            month = ref(today.getMonth()),
            year = ref(today.getFullYear()),
            selected = ref(),
            currentDay = ref(today.getDate()),
            firstWeekDayOfTheMonth = ref(getFirstWeekDayOfTheMonth()),
            days = ref([]),
            weekDays = [
              'Su',
              'Mo',
              'Tu',
              'We',
              'Th',
              'Fr',
              'Sa',
            ],
            months = [
              'January',
              'February',
              'March',
              'April',
              'May',
              'June',
              'July',
              'August',
              'September',
              'October',
              'November',
              'December'
            ],
            shortMonths = [
              'Jan',
              'Feb',
              'Mar',
              'Apr',
              'May',
              'Jun',
              'Jul',
              'Aug',
              'Sep',
              'Oct',
              'Nov',
              'Dec'
            ]

      updateDays()

      function updateDays() {
        const currentDays = []
        selected.value = null
        currentDay.value = null

        for (let day = 1; day <= daysInMonth(); day++) {
          currentDays.push(day)

          if (
            day === today.getDate() &&
            month.value === today.getMonth() &&
            year.value === today.getFullYear()
          ) {
            currentDay.value = day
          }
        }

        days.value = currentDays
        firstWeekDayOfTheMonth.value = getFirstWeekDayOfTheMonth()
        console.log( getFirstWeekDayOfTheMonth() )
      }

      function next() {
        year.value = month.value === 11 ? year.value + 1 : year.value
        month.value = (month.value + 1) % 12
        updateDays()
      }

      function prev() {
        year.value = month.value === 0 ? year.value - 1 : year.value
        month.value = month.value === 0 ? 11 : month.value - 1
        updateDays()
      }

      function daysInMonth() {
        // day 0 here returns the last day of the PREVIOUS month
        return new Date(year.value, month.value + 1, 0).getDate()
      }

      function getFirstWeekDayOfTheMonth() {
        return new Date(year.value, month.value).getDay()
      }

      function select(day) {
        console.log(day)
        selected.value = day
      }

      return { prev, next, month, year, months, shortMonths, weekDays, days, select, selected, currentDay, firstWeekDayOfTheMonth }
    }
  }
</script>
