import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue/dist/vue.esm-bundler.js';

import ExampleComponent from "/resources/js/components/ExampleComponent.vue";
import Flash from "/resources/js/components/Flash.vue";

const app = createApp({});
window.app = app;
window.flash = function(message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

app.component('example-component', ExampleComponent);
app.component('flash', Flash);

app.mount('#app');
