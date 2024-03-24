import './bootstrap';

import Alpine from 'alpinejs';


import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';

import ExampleComponent from "/resources/js/components/ExampleComponent.vue";
import Reply from "/resources/js/components/Reply.vue";
import Replies from "/resources/js/components/Replies.vue";
import Favorite from "/resources/js/components/Favorite.vue";
import Flash from "/resources/js/components/Flash.vue";
import Btn from "/resources/js/components/Btn.vue";
import PostReply from "/resources/js/components/PostReply.vue";
import ThreadInfo from "/resources/js/components/ThreadInfo.vue";
import ThreadDetails from "/resources/js/components/ThreadDetails.vue";
import ThreadCard from "/resources/js/components/ThreadCard.vue";
import MyEditor from "/resources/js/components/Editor/MyEditor.vue";
import Layout from './Shared/Layout.vue';
import 'highlight.js/styles/github-dark.css'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { InertiaForm } from "@inertiajs/inertia-vue3";

const vuetify = createVuetify({
    components,
    directives,
})


window.Alpine = Alpine;
Alpine.start();

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]
        page.default.layout = page.default.layout || Layout
        return page
    },
    setup({ el, app, props, plugin }) {
        const vueApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(vuetify)
            .use(InertiaForm)
            .component('example-component', ExampleComponent)
            .component('reply', Reply)
            .component('replies', Replies)
            .component('favorite', Favorite)
            .component('flash', Flash)
            .component('btn', Btn)
            .component('post-reply', PostReply)
            .component('thread-info', ThreadInfo)
            .component('thread-details', ThreadDetails)
            .component('thread-card', ThreadCard)
            .component('my-editor', MyEditor)
            .component('layout', Layout)


        vueApp.mount(el);
        window.app = vueApp;
        window.flash = function (message, level = 'success') {
            window.events.$emit('flash', { message, level });
        };
    },
});
