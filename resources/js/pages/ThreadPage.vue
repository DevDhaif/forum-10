<template>
    <div class="container flex items-start justify-between mx-auto mt-6 space-x-8">

        <div class="w-3/4">
            <ThreadDetails :thread="thread" :user="user"></ThreadDetails>
            <div class="p-4 mt-4 bg-slate-50 dark:bg-slate-900 rounded-lg">
                <p class="mt-6 text-sm text-gray-600">
                    This thread has {{ replies.data.length }}
                    replies.
                </p>
                <PostReply :user="user" :thread="thread" @replyPosted="addReply"></PostReply>
                <Replies :replies="replies" :thread="thread" :user="user" :key="repliesKey"></Replies>
                <button class="w-8 h-8 mx-2 mt-4 text-center text-white bg-blue-500 rounded-full hover:bg-blue-600"
                    v-for="page in Array.from({ length: pagination.lastPage }, (_, i) => i + 1)" :key="page"
                    @click="goToPage(page)">
                    {{ page }}
                </button>
            </div>

        </div>
        <thread-info :thread="thread" :user="thread.creator" />
    </div>
</template>

<script>
import PostReply from "../components/PostReply.vue";
import Replies from "../components/Replies.vue";
import ThreadDetails from "../components/ThreadDetails.vue";
import ThreadInfo from "../components/ThreadInfo.vue";

export default {
    props: ['thread', 'user', 'replies', 'pagination'],
    components: {
        PostReply,
        Replies,
        ThreadDetails,
        ThreadInfo,
    },
    data() {
        return {
            replies: this.replies,
            pagination: this.pagination,
            repliesKey: 0,
        }
    },
    methods: {
        addReply(reply) {
            this.replies.data.push(reply);
            this.repliesKey++;
        },
        goToPage(page) {
            const url = `/threads/${this.thread.channel.name}/${this.thread.id}/replies?page=${page}`;

            axios.get(url)
                .then(response => {
                    this.replies = response.data.replies;
                    this.pagination = response.data.pagination;
                    history.pushState({}, '', `${url}`);
                });
        },
    },
}
</script>
