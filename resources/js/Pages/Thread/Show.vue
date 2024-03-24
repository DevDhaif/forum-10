<template>
    <div class="container flex items-start justify-between mx-auto mt-6 space-x-8">
        <div class="w-3/4">
            <thread-details :thread="thread" :user="user"></thread-details>
            <div class="p-4 mt-4 bg-white rounded shadow">
                <p class="mt-6 text-sm text-gray-600">
                    This thread has {{ replies.data.length }}
                    replies.
                </p>
                <post-reply :user="user" :thread="thread" @replyPosted="addReply" @flash="handleFlash"></post-reply>
                <replies :replies="replies" :thread="thread" :user="user" :key="repliesKey"></replies>
                <pagination :links="replies.links"></pagination>
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
            flashMessage: ""
        }
    },
    methods: {
        addReply(reply) {
            this.replies.data.push(reply)
            this.repliesKey++
        },
        handleFlash(message) {
            this.flashMessage = message
        },
    }
}
</script>
