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
// import ThreadPage from "/resources/js/pages/ThreadPage.vue";

window.Alpine = Alpine;
Alpine.start();

createInertiaApp({
    resolve: name => {
        //Vite has some limitations when it comes to dynamic imports with template literals.
        // Try replacing the template literal with a string concatenation:
        // so this
        return import(/* @vite-ignore */'./Pages/' + name + '.vue').then(module => module.default);
        // instead of this
        // return import(`./Pages/${name}.vue`).then(module => module.default);
    },
    setup({ el, app, props, plugin }) {
        const vueApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .component('example-component', ExampleComponent)
            .component('reply', Reply)
            .component('replies', Replies)
            .component('favorite', Favorite)
            .component('flash', Flash)
            .component('btn', Btn)
            .component('post-reply', PostReply)
            .component('thread-info', ThreadInfo)
            .component('thread-details', ThreadDetails)
        // .component('thread-page', ThreadPage);

        vueApp.mount(el);
        window.app = vueApp;
        window.flash = function (message, level = 'success') {
            window.events.$emit('flash', { message, level });
        };
    },
});
// const app = createApp({});
// window.app = app;
// window.flash = function(message, level = 'success') {
//     window.events.$emit('flash', { message, level });
// };

// app.component('example-component', ExampleComponent);
// app.component('reply', Reply);
// app.component('post-reply', PostReply);
// app.component('thread-info', ThreadInfo);
// app.component('thread-details', ThreadDetails);
// app.component('thread-page', ThreadPage);
// app.component('replies', Replies);
// app.component('favorite', Favorite);
// app.component('btn', Btn);
// app.component('flash', Flash);

// app.mount('#app');

// createInertiaApp({
//   resolve: name => require(`./Pages/${name}`),
//   setup({ el, app, props, plugin }) {
//     return createApp({ render: () => h(app, props) })
//       .use(plugin)
//       .mount(el);
//   },
// });
