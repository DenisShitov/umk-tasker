import { defineStore } from 'pinia'

let timerInterval

export const useTimerStore = defineStore({
  id: 'timer',

  state: () => ({
    taskId: '',
    projectId: '',
    projectName: '',
    taskTitle: '',
    processing: false,
    timers: [],
    isTimerRunning: false,
    timerStartedAt: null,
    timerStoppedAt: null,
    currentTaskTimer: {
      h: 0,
      m: 0,
      s: 0,
    }
  }),

  actions: {
    start(task) {
      this.stopPrev()

      this.startTimer()
console.log('start')
console.log(task)
      this.taskId = task.id
      this.taskTitle = task.title
      this.projectId = task.project_id
      this.projectName = task.project.name
      this.processing = true

      axios.post('time-logs', {
        taskId: this.taskId,
        projectId: this.projectId,
        start: true,
        currentTime: this.timerStartedAt,
      })
        .then(data => {
          this.processing = false
          this.fetch()
        })
        .catch(error => {
          this.processing = false
        })
    },

    stop() {
      this.stopTimer()

      const taskId = this.taskId
      const projectId = this.projectId
      this.processing = true

      axios.post('time-logs', {
        taskId: taskId,
        projectId: projectId,
        stop: true,
        currentTime: this.timerStoppedAt,
      })
        .then(data => {
          this.processing = false
          this.fetch()
        })
        .catch(error => {
          this.processing = false
        })

      this.taskId = null
      this.projectId = null
      this.projectName = null
    },

    stopPrev() {
      if (!this.taskId) return

      console.log('stopPrev')
      this.stopTimer()

      const taskId = this.taskId
      const projectId = this.projectId
      this.processing = true

      axios.post('time-logs', {
        taskId: taskId,
        projectId: projectId,
        stop: true,
        currentTime: this.timerStoppedAt,
      })
        .then(data => {
          console.log(data)
        })
        .catch(error => {
          console.log('error')
          this.processing = false
        })
    },

    fetch() {
      axios.get('time-logs')
        .then(data => {
          this.timers = data

          console.log('running!')
          const task = data.find(x => x.user.id == Config.user.id)
          console.log(task)

          if (task) {
            console.log(task.task.id)
            this.taskId = task.task.id
            this.taskTitle = task.task.title
            this.projectId = task.task.project_id
            this.projectName = task.task.project.name
          }
        })
    },

    startTimer() {
      timerInterval = setInterval(() => {
        if (this.currentTaskTimer.s == 59) {
          this.currentTaskTimer.s = 0
          this.currentTaskTimer.m++
        } else if (this.currentTaskTimer.m == 59) {
          this.currentTaskTimer.m = 0
          this.currentTaskTimer.h++
        } else {
          this.currentTaskTimer.s++
        }
      }, 1000)

      this.timerStartedAt = new Date()
      this.isTimerRunning = true
    },

    stopTimer() {
      clearInterval(timerInterval)

      this.timerStoppedAt = new Date()
      this.isTimerRunning = false
    },

    setTimer(seconds) {
      // this.isTimerRunning = false

      this.currentTaskTimer.s = Math.floor(seconds % 60)
      this.currentTaskTimer.m = Math.floor((seconds % 3600) / 60)
      // this.currentTaskTimer.h = Math.floor((seconds % (3600 * 24)) / 3600)
      this.currentTaskTimer.h = Math.floor(seconds / 3600)
    },
  }
})
