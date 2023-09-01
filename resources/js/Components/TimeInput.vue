<template>
    <div :class="$attrs.class">
      <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
      <input :id="id" ref="input" v-bind="{ ...$attrs, class: null }" class="form-input" :class="{ error: error }" type="time" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
      <div v-if="error" class="form-error">{{ error }}</div>
    </div>
  </template>

  <script>
  import { v4 as uuid } from 'uuid'

  export default {
    inheritAttrs: false,
    props: {
      id: {
        type: String,
        default() {
          return `time-input-${uuid()}`
        },
      },
      error: String,
      label: String,
      modelValue: String,
    },
    emits: ['update:modelValue'],
    methods: {
      focus() {
        this.$refs.input.focus()
      },
      select() {
        this.$refs.input.select()
      },
      setSelectionRange(start, end) {
        this.$refs.input.setSelectionRange(start, end)
      },
    },
  }
  </script>
