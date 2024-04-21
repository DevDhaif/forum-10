<template>
    <Activity>
        <template #heading>
            <div class="flex items-center space-x-2 justify-between">
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl font-bold">{{ user.name }}</h1>
                    <p class="text-sm flex justify-between w-full">
                        <span class="text-lg flex items-center space-x-2">
                            <span>created a thread</span>
                            <a :href="getPath(this.activity.subject, 'thread')" class="text-blue-500">
                                {{ activity.subject.title }}
                            </a>
                        </span>
                    </p>
                </div>
                <div class="text-sm flex space-x-2">
                    <Forum class="mt-1 ml-2" />
                    <span> {{ formatDate(activity.subject.created_at) }} </span>
                </div>
            </div>
        </template>
        <template #body>
            <h1 class="text-xl font-bold prose-invert">{{ activity.subject.title }}</h1>
            <p class="text-sm overflow-hidden dark:prose-invert"
                style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;"
                v-html="firstFewLines">
            </p>
        </template>
    </Activity>
</template>

<script>
import Forum from 'vue-material-design-icons/Forum.vue'

import Activity from './Activity.vue';
import { formatDate, getPath, } from '../../Utils/helpers.js'
import { highlightCode } from '../../Utils/highlightCode.js'
export default {
    components: {
        Activity,
        Forum
    },
    props: ['activity', 'user'],
    methods: {
        formatDate,
        getPath,

    },
    computed: {
        highlighted() {
            return highlightCode(this.activity.subject.body)
        },
        firstFewLines() {
            return this.highlighted.split('\n').slice(0, 3).join('\n')
        }
    }

};
</script>
