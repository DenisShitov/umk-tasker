<template>
  <div class="grid sm:grid-cols-3 border-b border-gray-200 last:border-b-0 py-5">
    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
      &nbsp;
    </label>

    <div class="sm:col-span-2">
      <img class="w-24 h-24 rounded-full" :src="src" v-if="src">

      <span class="inline-block h-24 w-24 rounded-full overflow-hidden bg-gray-200" v-else>
        <svg class="h-full w-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
          <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
      </span>

      <!-- <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center" v-else>
        {{ form.data.name.charAt(0) }}
      </div> -->

      <label
        for="avatar"
        class="block w-24 cursor-pointer mt-2 text-sm text-gray-600 text-center"
      >
        Change
      </label>

      <input type="file" id="avatar" class="hidden" accept="image/*" @change="onChoose" name="avatar">
    </div>
  </div>
</template>

<script lang="ts">
  import { ref } from 'vue'
  import { useFormStore } from 'Store/form'

  export default {
    setup() {
      const form = useFormStore('profile')(),
            width = 512,
            height = 512,
            src = ref()

      src.value = form.data.avatar

      function onChoose(e) {
        if (! e.target.files.length) return;

        let file = e.target.files[0];

        let target = e.target

        let reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = e => {
          let img = new Image;

          img.src = e.target.result;

          img.onload = function() {
            if (img.width > width || img.height > height) {
              alert('you can upload max ' + width + ' x ' + height)

              target.value = null

              // src.value = imageSrc

              return
            }

            src.value = e.target.result

            const formData = new FormData();
            formData.append('avatar', file);

            axios.post('avatar', formData)
              .then(data => {
                if (data != 'done') {
                }
              })
          };
        };
      }

      return { src, form, onChoose }
    }
  }
</script>
