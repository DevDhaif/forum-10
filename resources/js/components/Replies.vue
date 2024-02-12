<template>
    <div>
        <h1>replies all here </h1>
        <reply v-for="reply in localReplies" :key="reply.id" :reply="reply" @replyDeleted="removeReply"></reply>
    </div>
</template>
<script>
import Reply from "./Reply.vue";
export default {
    components: {
        Reply,
    },
    props: ["replies", "thread"],
    data() {
        return {
            localReplies: this.replies.data,
        }
    },
    methods: {
        removeReply(replyId) {
            this.localReplies = this.localReplies.filter(reply => reply.id !== replyId);
        },
    },
    created() {
        console.log(this.replies.data);
    },
};
</script>
