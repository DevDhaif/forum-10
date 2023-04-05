import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue/dist/vue.esm-bundler.js';

import ExampleComponent from "@/components/ExampleComponent.vue";

const app = createApp({});

app.component('example-component', ExampleComponent);

app.mount('#app');
