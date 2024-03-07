<template>
    <div class="container mx-auto  mt-6 flex space-x-8 justify-between items-start">

        <div class="w-3/4">
            <thread-details :thread="thread" :user="user"></thread-details>
            <div class="bg-white p-4 rounded shadow mt-4">
                <p class="text-gray-600 text-sm mt-6">
                    This thread has {{ replies.data.length }}
                    replies.
                </p>
                <post-reply :user="user" :thread="thread" @replyPosted="addReply"></post-reply>
                <replies :replies="replies" :thread="thread" :user="user" :key="repliesKey"></replies>
            </div>

        </div>
        <thread-info :thread="thread" :user="thread.creator" />
    </div>
</template>

<script>
export default {
    props: ['thread', 'user', 'replies'],
    data() {
        return {
            repliesKey: 0,
        }
    },
    methods: {
        addReply(reply) {
            this.replies.data.push(reply);
            this.repliesKey++;
        },
    },
}
</script>
