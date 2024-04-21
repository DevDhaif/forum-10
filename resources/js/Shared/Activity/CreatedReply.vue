<template>
    <Activity>
        <template #heading>
            <div class="flex items-center space-x-2 justify-between">
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl font-bold text-slate-800 dark:text-slate-400">{{ user.name }} </h1>
                    <span>replied on </span>
                    <a :href="path" class="text-blue-500">
                        {{ activity.subject.thread.title }}
                    </a>
                </div>
                <div class="text-sm flex space-x-2">
                    <Reply class="-scale-x-100" />
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
import { formatDate, getPath } from '../../Utils/helpers.js'

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
            return this.activity.subject.path;
            // return getPath(this.activity.subject, 'reply');
        }
    },
    mounted() {
        // console.log(this.activity.subject.path)
        // console.log("MOUNTED")
        if (this.activity.subject.favorited_type === 'App\\Models\\Favorite') {
            // console.log(this.type)
            // console.log("the Thread: ");
            // console.log(this.activity.subject.favorited.thread.created_at);
        }
    }
};
</script>
