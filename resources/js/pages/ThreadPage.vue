<template>
    <div class="container mx-auto  mt-6 flex space-x-8 justify-between items-start">

<div class="w-3/4">
    <thread-details :thread="thread" :user="user"></thread-details>
        <div class="bg-white p-4 rounded shadow mt-4">
            <post-reply :user="user" :thread="thread" @replyPosted="addReply"></post-reply>
            <replies :replies="replies" :thread="thread" :user="user"></replies>
        </div>

</div>
<thread-info :thread=" thread" :user=" thread.creator" />
</div>
</template>
<script>
export default{
    props: ['thread', 'user','replies'],
    methods: {
        addReply(reply) {
            this.replies.data.push(reply);
        }
    }
}
</script>

