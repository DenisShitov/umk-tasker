<template>
    <section :class="{ 'opacity-50': processing }">
        <h1 class="text-gray-800 font-semibold mt-4">Описание</h1>
        <div class="border rounded-md overflow-hidden mt-2">
            <QuillEditor
                class="min-h-[250px]"
                theme="snow"
                toolbar="essential"
                v-model:content="description"
                :contentType="'html'"
            />
        </div>

        <div class="mt-2">
            <button
                type="button"
                class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                @click="save"
            >
                {{ __('Save') }}
            </button>

            <button
                type="button"
                class="ltr:ml-1 rtl:mr-1 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-700 hover:text-gray-900 bg-white focus:outline-none focus:ring-0"
                @click="cancel"
            >
                {{ __('Cancel') }}
            </button>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import autosize from 'autosize'
import { useTaskStore } from 'Store/task'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

onMounted(() => {
    document.querySelector('.task-title').focus()
    autosize(document.querySelectorAll('.autosize'))
})

const task = useTaskStore(),
    processing = ref(false),
    title = ref(task.data.title),
    description = ref(task.data.description)

function save(e) {
    if (processing.value) return

    if (task.data.title == title.value && task.data.description == description.value) {
        cancel()
        return
    }

    processing.value = true

    axios.patch(`tasks/${task.data.id}`, {
        title: title.value,
        description: description.value
    })
        .then(data => {
            processing.value = false
            task.data.title = title.value
            task.data.description = description.value
            cancel()
        })
}

function cancel() {
    title.value = ''
    description.value = ''
    task.isContentFormDesc = false
}
</script>

<style scoped>

    article{
        border-radius: 0.375rem;
        border-width: 1px;
        font-size: .875rem;
        line-height: 1.25rem;
        padding: 0.5rem;
        width: 100%;
        max-width: unset;
    }
</style>
