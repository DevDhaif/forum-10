<template>
    <v-tooltip :text="tooltipText">
      <template v-slot:activator="{ props }">
        <v-btn v-bind="props" @click="handleClick">
            <v-icon>{{ icon }}</v-icon>
        </v-btn>
      </template>
    </v-tooltip>
  </template>

  <script>
  export default {
    props: {
      tooltipText: {
        type: String,
        required: true
      },
      icon: {
        type: String,
        required: true
      },
      actionType: {
        type: Function,
        required: true
      },
      editor:{
      type: Object,
      required:true
    }
    },
    methods: {
      handleClick() {
        this.actionType(this.editor)
      }
    }
  }
  </script>
