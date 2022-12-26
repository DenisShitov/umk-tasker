import Home from 'View/Home.vue'
import NotFound from 'View/NotFound.vue'
import Profile from 'View/Profile.vue'
import ProjectsDetail from 'View/projects/Detail.vue'
import ProjectsIndex from 'View/projects/Index.vue'
import SettingsEmail from 'View/settings/Email.vue'
import SettingsGeneral from 'View/settings/General.vue'
import SettingsUpdates from 'View/settings/Updates.vue'
import RolesIndex from 'View/roles/Index.vue'
import TasksIndex from 'View/tasks/Index.vue'
import UsersIndex from 'View/users/Index.vue'
import LabelsIndex from 'View/labels/Index.vue'

export default [
  { path: '/', component: Home },
  { path: '/profile', component: Profile },
  { path: '/projects', name: 'Projects', component: ProjectsIndex },
  { path: '/projects/:id', name: 'ProjectsDetail', component: ProjectsDetail },
  { path: '/projects/:id/tasks/:taskId', name: 'ProjectsDetailTask', component: ProjectsDetail, props: true },
  { path: '/users', name: 'Users', component: UsersIndex },
  { path: '/labels', name: 'Labels', component: LabelsIndex },
  { path: '/roles', name: 'Roles', component: RolesIndex },
  { path: '/tasks', name: 'Tasks', component: TasksIndex },
  { path: '/settings/general', component: SettingsGeneral },
  { path: '/settings/email', component: SettingsEmail },
  { path: '/settings/updates', component: SettingsUpdates },

  { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound }
]
