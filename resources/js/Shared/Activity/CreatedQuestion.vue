<template>
    <Activity>
        <template #heading>
            <div class="flex items-center space-x-2 justify-between">
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl font-bold">{{ user.name }}</h1>
                    <p class="text-sm flex justify-between w-full">
                        <span class="text-lg flex items-center space-x-2">
                            <span>created a question</span>
                            <a :href="getVotedPath(this.activity.subject, 'question')" class="text-blue-500">
                                {{ activity.subject.title }}
                            </a>
                        </span>
                    </p>
                </div>
                <div class="text-sm flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 14 14">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M1.44.44A1.5 1.5 0 0 1 2.5 0h10A1.5 1.5 0 0 1 14 1.5v10a1.5 1.5 0 0 1-1.5 1.5H4.562l-3.94.985a.5.5 0 0 1-.596-.643L1 10.419V1.5c0-.398.158-.78.44-1.06m5.692 3.19a1.007 1.007 0 1 1 .385 1.936a.625.625 0 0 0-.625.625V7.28a.625.625 0 1 0 1.25 0v-.551A2.256 2.256 0 1 0 5.261 4.56a.625.625 0 1 0 1.25 0a1.007 1.007 0 0 1 .621-.93m.385 6.994a.897.897 0 1 1 .002 0z"
                            clip-rule="evenodd" />
                    </svg>
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
import { formatDate, getVotedPath } from '../../Utils/helpers.js'
import { highlightCode } from '../../Utils/highlightCode.js'
export default {
    components: {
        Activity,
        Forum
    },
    props: ['activity', 'user'],
    methods: {
        formatDate,
        getVotedPath

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
