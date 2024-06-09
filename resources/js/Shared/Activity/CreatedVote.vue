<template>
    <Activity>
        <template #heading>
            <div class="flex items-center space-x-2 justify-between">
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl font-bold">{{ user.name }} </h1>

                    <p class="text-sm" v-if="activity.subject">
                        {{ activity.subject.type === 'upvote' ? 'upvoted' : 'downvoted' }}
                        {{ activity.subject.voted_type
                        === 'App\\Models\\Question' ? 'question' : 'answer' }} on
                        <a :href="path" class="text-blue-500"
                            v-if="activity.subject.voted_type === 'App\\Models\\Question'">
                            {{ activity.subject.voted.title }}
                        </a>
                        <a :href="path" class="text-blue-500 "
                            v-else-if="activity.subject.voted_type === 'App\\Models\\Answer'">
                            {{ truncate(activity.subject.voted.body, 5) }}
                        </a>
                    </p>
                </div>
                <div class="text-sm flex space-x-2">
                    <svg v-if="activity.subject && activity.subject.type === 'upvote'" aria-hidden="true"
                        class="w-6 h-6 group-hover:fill-green-400 fill-green-500 " viewBox="0 0 18 18">
                        <path d="M1 12h16L9 4l-8 8Z"></path>
                    </svg>

                    <svg v-else aria-hidden="true" class=" group-hover:fill-red-400 w-6 h-6 fill-red-600 "
                        viewBox="0 0 18 18">
                        <path d="M1 6h16l-8 8-8-8Z"></path>
                    </svg>

                    <span> {{ formattedDate }} </span>
                </div>
            </div>
        </template>
        <template #body>
            <p class="text-sm" v-if="activity.subject" v-html="activity.subject.voted.body"></p>
            <p class="text-sm" v-else>
                The voted item has been deleted
            </p>
        </template>
    </Activity>
</template>

<script>
import Activity from './Activity.vue';
import { formatDate, getVotedPath } from '../../Utils/helpers.js'
import Heart from 'vue-material-design-icons/Heart.vue';
import { highlightCode } from '../../Utils/highlightCode';
export default {
    components: {
        Activity,
        Heart
    },
    props: ['activity', 'user'],
    computed: {
        type() {
            return this.activity.subject.voted_type === 'App\\Models\\Question' ? 'question' : 'answer';
        },
        formattedDate() {
            return formatDate(this.activity.created_at);
        },
        path() {
            return getVotedPath(this.activity.subject.voted, this.type);
            // return getPath(this.activity.subject.voted, this.type);
        },
        truncatedBody(body) {
            let bodyVal = body
            if (bodyVal.length > 100) {
                bodyVal = bodyVal.substring(0, 100) + '...'
            }
            return highlightCode(bodyVal)
        },
    },
    methods: {
        truncate(input, words) {
            return input.split(" ").splice(0, words).join(" ") + "...";
        }
    }

};
</script>
