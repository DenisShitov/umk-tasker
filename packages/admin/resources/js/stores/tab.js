import { defineStore } from 'pinia'

export const useTabStore = function (name) {
    return defineStore({
        id: 'tab-' + name,

        state: () => ({
            active: 0,
            items: [],
            tab: null,
        }),

        actions: {
            select(index) {
                this.active = index
                this.tab = this.items[index].component
            },

            tabs(tabs) {
                this.active = 0
                this.items = tabs
                this.tab = tabs[0].component
            }
        }
    })
}
