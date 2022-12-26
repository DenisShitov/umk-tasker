<template>
  <div class="grid sm:grid-cols-3 border-b border-gray-200 last:border-b-0 py-5">
    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
      {{ __('Logo') }}
    </label>

    <div class="sm:col-span-2">
      <div class="flex">
        <span class="mr-2 h-[2.125rem] flex items-center px-4 bg-gray-900" v-if="src">
          <img class="block h-8" :src="src">
        </span>

        <label class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          {{ __('Change') }}
          <input type="file" class="hidden" accept="image/*" @change="onChoose" name="logo">
        </label>

        <button type="button" class="ml-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-0" @click="remove" v-if="src">
          {{ __('Remove') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { ref } from 'vue'
  import { useFormStore } from 'Store/form'

  const form = useFormStore('setting-general')(),
        width = 200,
        height = 32,
        src = ref(null)

  src.value = form.data.app_logo ? `/${form.data.app_logo}` : null

  function remove() {
    src.value = null
    form.data.app_logo = null
  }

  function onChoose(e) {
    if (! e.target.files.length) return;

    let file = e.target.files[0];

    let target = e.target;

    let reader = new FileReader();

    reader.readAsDataURL(file);

    reader.onload = e => {
      let img = new Image;

      img.src = e.target.result;

      img.onload = function() {
        if (img.width > width || img.height > height) {
          alert('you can upload max ' + width + ' x ' + height);

          target.value = null;

          return;
        }

        src.value = e.target.result;

        const formData = new FormData();
        formData.append('logo', file);

        axios.post('logo', formData)
          .then(data => {
            form.data.app_logo = data
          });
      };
    };
  }
</script>
