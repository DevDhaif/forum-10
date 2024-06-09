<template>
    <Activity>
        <template #heading>
            <div class="flex items-center space-x-2 justify-between">
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl font-bold text-slate-800 dark:text-slate-400">{{ user.name }} </h1>
                    <span>Answered </span>
                    <a :href="path" class="text-blue-500">
                        {{ activity.subject.question.title }}
                    </a>
                </div>
                <div class="text-sm flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M5.486 0c-1.92 0-2.881 0-3.615.373A3.428 3.428 0 0 0 .373 1.871C-.001 2.605 0 3.566 0 5.486v9.6c0 1.92 0 2.88.373 3.613c.329.645.853 1.17 1.498 1.498c.734.374 1.695.375 3.615.375h11.657V24l.793-.396c2.201-1.101 3.3-1.652 4.105-2.473a6.852 6.852 0 0 0 1.584-2.56C24 17.483 24 16.251 24 13.79V5.486c0-1.92 0-2.881-.373-3.615A3.428 3.428 0 0 0 22.129.373C21.395-.001 20.434 0 18.514 0H5.486zm1.371 10.285h10.286a5.142 5.142 0 0 1-10.286.024v-.024z" />
                    </svg>
                    <span> {{ formattedDate }} </span>
                </div>
            </div>
        </template>
        <template #body>
            <h1 class="text-xl font-bold">{{ activity.subject.title }}</h1>
            <p class="text-sm line-clamp-2 overflow-hidden text-slate-900 dark:text-slate-200
             " v-html="activity.subject.body" />
        </template>
    </Activity>
</template>

<script>
import Reply from 'vue-material-design-icons/Reply.vue';
import Activity from './Activity.vue';
import { formatDate } from '../../Utils/helpers.js'

export default {
    components: {
        Activity,
        Reply
    },
    props: ['activity', 'user'],
    computed: {

        formattedDate() {
            return formatDate(this.activity.created_at);
        },
        path() {
            return this.activity.subject.question.path + `#answer-${this.activity.subject.id}`;
        }
    }
};
</script>
