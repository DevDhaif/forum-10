<template>
    <div class="p-4 bg-white rounded-lg shadow-md ">
        <h2 class="text-xl font-bold mb-2 truncate"> <span
                :class="vote.type == 'downvote' ? 'text-red-500' : ' text-green-500'">{{ vote.type }}</span> a {{
            votedType }} {{ title }}</h2>
        <p class="text-sm text-gray-500 mt-2 ">voted on: {{ formatDate(vote.created_at) }}</p>
        <Link :href="path" class="text-blue-500 hover:text-blue-700">View {{ votedType }}</Link>
    </div>
</template>

<script>
import { formatDate, getVotedPath } from '../Utils/helpers';
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
        Link,
    },
    props: {
        vote: Object,
    },
    methods: {
        formatDate(date) {
            return formatDate(date);
        }
    },
    computed: {
        votedType() {
            switch (this.vote.voted_type) {
                case "App\\Models\\Answer":
                    return "answer";
                case "App\\Models\\Question":
                    return "question";
                default:
                    return "Unknown";
            }
        },
        path() {
            return getVotedPath(this.vote.voted, this.votedType);
        },
        title() {
            switch (this.vote.voted_type) {
                case "App\\Models\\Answer":
                    return this.vote.voted.question.title;
                case "App\\Models\\Question":
                    return this.vote.voted.title;
                default:
                    return "Unknown";
            }
        }
    }
};
</script>
