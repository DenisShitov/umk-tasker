import { app } from '@/app'

app.provide('__', word => {
  const translation = Config.translations[word]

  if (translation) {
    return translation
  }

  console.warn(`[Translation] Not found '${word}' key in '${Config.locale}' locale translations.`)

  return word
})

app.config.globalProperties.__ = word => {
  const translation = Config.translations[word]

  if (translation) {
    return translation
  }

  console.warn(`[Translation] Not found '${word}' key in '${Config.locale}' locale translations.`)

  return word
}
