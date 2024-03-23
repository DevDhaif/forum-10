<template>
    <div class="container flex items-start justify-between mx-auto mt-6 space-x-8">
        <div class="w-3/4">
            <thread-details :thread="thread" :user="user"></thread-details>
            <div class="p-4 mt-4 bg-white rounded shadow">
                <p class="mt-6 text-sm text-gray-600">
                    This thread has {{ replies.data.length }}
                    replies.
                </p>
                <post-reply :user="user" :thread="thread" @replyPosted="addReply"></post-reply>
                <replies :replies="replies" :thread="thread" :user="user" :key="repliesKey"></replies>
                <!-- <button
                class="w-8 h-8 mx-2 mt-4 text-center text-white bg-blue-500 rounded-full hover:bg-blue-600"
                v-for="page in Array.from({ length: pagination.lastPage }, (_, i) => i + 1)" :key="page"
                    @click="goToPage(page)">
                    {{ page }}
                </button> -->
                <!-- <pagination :links="replies.links"></pagination> -->
            </div>
        </div>
        <thread-info :thread="thread" :user="thread.creator" />
    </div>
</template>

<script>
import Pagination from '../../Shared/Pagination.vue'
export default {
    components: {
        Pagination,
    },
    props: ['thread', 'user', 'replies'],
    data() {
        return {
            replies: this.replies,
            repliesKey: 0,
        }
    },
    methods: {
        addReply(reply) {
            this.replies.data.push(reply)
            this.repliesKey++
        },
    },
    mounted() {
        console.log(this.thread)
    },
}
</script>
