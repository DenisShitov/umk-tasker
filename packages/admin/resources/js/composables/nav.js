import { HomeIcon, InboxIcon, UserIcon } from '@heroicons/vue/outline'

export const Nav = [
  {'label': 'Home', 'uri': '/', 'icon': HomeIcon},
  {'label': 'My Tasks', 'uri': '/tasks', 'icon': InboxIcon},
  {'label': 'Team Members', 'uri': '/users', 'icon': UserIcon, 'permission': 'user:view'},
]
