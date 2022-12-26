<template>
  <v-card v-if="form.loading">
    <div class="animate-pulse px-6">
      <div class="grid sm:grid-cols-3 border-b border-gray-200 last:border-b-0 py-5" v-for="i in 2">
        <label class="bg-gray-200 h-4 ltr:mr-16 rtl:ml-16 rounded sm:mt-px sm:pt-2"/>
        <div class="bg-gray-200 sm:col-span-2 h-4 rounded">&nbsp;</div>
      </div>
    </div>

    <div class="flex justify-end py-5 px-6 bg-gray-50 rounded-b-lg sticky bottom-0">
      <span class="h-4 w-32 bg-gray-300 rounded">&nbsp;</span>
    </div>
  </v-card>

  <div v-else>
    <div v-if="cards">
      <div class="flex">
        <div class="w-64">
          <div class="sticky top-0 pt-6">
            <v-card class="overflow-hidden">
              <nav>
                <p
                  class="group mt-1 first:mt-0"
                  :class="{ 'flex items-center px-3 py-2 text-sm leading-5 font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition ease-in-out duration-150 cursor-pointer': card.name != currentCard, 'flex items-center px-3 py-2 text-sm leading-5 font-medium text-gray-900 bg-gray-100 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150': card.name == currentCard }"
                  v-for="(card, index) in cards"
                  @click.prevent="scroll(card.name)"
                >
                  <span :class="{ 'inline-block py-0.5 px-3 text-xs leading-4 rounded-full text-gray-600 bg-gray-100 group-hover:bg-gray-200 group-focus:bg-gray-200 transition ease-in-out duration-150': card.name != currentCard, 'inline-block py-0.5 px-3 text-xs leading-4 rounded-full bg-white transition ease-in-out duration-150': card.name == currentCard }">
                    {{ index + 1 }}
                  </span>
                  <span class="ltr:ml-3 rtl:mr-3 truncate">
                    {{ __(card.label) }}
                  </span>
                </p>
              </nav>
            </v-card>
          </div>
        </div>
        <div class="flex-1 ltr:pl-6 rtl:pr-6 ltr:pr-2px rtl:pl-2px">
          <slot></slot>

          <div class="transition-spacing duration-150 ease-in-out mt-2px py-5 flex justify-end sticky bottom-0 bg-gray-100" :class="{'px-6': isSticky}">
            <span class="inline-flex rounded-md shadow-sm ltr:mr-3 rtl:ml-3" v-if="!saveOnly">
              <button type="button" class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                {{ __('Cancel') }}
              </button>
            </span>
            <v-button data-cy="submit-button" @click="form.submit" :processing="form.processing">
              <span v-if="saveOnly">{{ __('Save') }}</span>
              <span v-else>{{ id ? __('Update') : __('Create') }} {{ title }}</span>
            </v-button>
          </div>

          <div class="sticky-end h-px"></div>
        </div>
      </div>
    </div>

    <div v-else>
      <div class="px-6">
        <slot></slot>
      </div>

      <div class="flex justify-end py-5 px-6 bg-gray-50 rounded-b-lg bottom-0">
        <v-button class="ltr:mr-3 rtl:ml-3" @click="form.cancel" v-if="!saveOnly" white>
          {{ __('Cancel') }}
        </v-button>
        <v-button data-cy="submit-button" @click="form.submit" :processing="form.processing">
          <span v-if="saveOnly">{{ __('Save') }}</span>
          <span v-else>{{ buttonText || (id ? __('Update') : __('Create')) + ' ' + title }}</span>
        </v-button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
  import { ref, provide } from 'vue'
  import { useFormStore } from 'Store/form'

  export default {
    props: {
      id: [String, Number],
      name: String,
      uri: String,
      title: String,
      saveOnly: Boolean,
      cards: Array,
      buttonText: String,
    },

    setup(props) {
      provide('form_name', props.name)

      const form = useFormStore(props.name)(),
        currentCard = ref(props.cards ? props.cards[0].name : null),
        IntersectionObserverLock = ref(false),
        isSticky = ref(true)

      form.init(props)

      function scroll(id) {
        document.getElementById(id).scrollIntoView({ behavior: 'smooth' })
        currentCard.value = id
        IntersectionObserverLock.value = true
        setTimeout(function () {
          IntersectionObserverLock.value = false
        }, 700)
      }

      if (props.cards) {
        form.onLoaded = function () {
          let observer = new IntersectionObserver(function(entries) {
            if (entries[0].intersectionRatio === 0) {
              isSticky.value = true
            } else if (entries[0].intersectionRatio === 1) {
              isSticky.value = false
            }
          }, { threshold: [0, 1] })

          let cardObserver = new IntersectionObserver(function(entries, observe) {
            if (IntersectionObserverLock.value) return

            let entry = entries[0]

            if (entry.isIntersecting && entry.boundingClientRect.top < 0) {
              let next = props.cards[props.cards.findIndex(x => x.name == entry.target.id)]
              currentCard.value = next.name
            } else if (entry.boundingClientRect.top < 0) {
              let next = props.cards[props.cards.findIndex(x => x.name == entry.target.id) + 1]
              currentCard.value = next.name
            }
          }, { threshold: 0.1 })

          setTimeout(function () {
            observer.observe(document.querySelector('.sticky-end'))

            for (let i = 0; i < props.cards.length; i++) {
              cardObserver.observe(document.getElementById(props.cards[i].name))
            }
          })
        }
      }

      return {
        form,
        currentCard,
        scroll,
        isSticky,
      }
    }
  }
</script>
