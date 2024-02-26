import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue/dist/vue.esm-bundler.js';

import ExampleComponent from "/resources/js/components/ExampleComponent.vue";
import Reply from "/resources/js/components/Reply.vue";
import Replies from "/resources/js/components/Replies.vue";
import Favorite from "/resources/js/components/Favorite.vue";
import Flash from "/resources/js/components/Flash.vue";
import Btn from "/resources/js/components/Btn.vue";
import PostReply from "/resources/js/components/PostReply.vue";
import ThreadInfo from "/resources/js/components/ThreadInfo.vue";
const app = createApp({});
window.app = app;
window.flash = function(message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

app.component('example-component', ExampleComponent);
app.component('reply', Reply);
app.component('post-reply', PostReply);
app.component('thread-info', ThreadInfo);
app.component('replies', Replies);
app.component('favorite', Favorite);
app.component('btn', Btn);
app.component('flash', Flash);

app.mount('#app');
