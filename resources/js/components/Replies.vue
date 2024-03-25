<template>
    <div>
        <h1>replies all here </h1>
        <reply v-for="reply in this.replies.data" :key="reply.id" :reply="reply" :user="user"
            @replyDeleted="updateReplies"></reply>
        <flash v-if="flashMessage" :flash="flashMessage"></flash>
    </div>
</template>
<script>
import Reply from "./Reply.vue";
export default {
    components: {
        Reply,
    },
    props: ["replies", "thread", "user", "key"],
    data() {
        return {
            replies: this.replies,
            thread: this.thread,
            flashMessage: null,
            errorMessage: "",
            body: "",
        }
    },
    methods: {

        updateReplies(replyId, thread, replies, flash) {
            Object.assign(this.thread, thread);
            Object.assign(this.replies, replies);
            this.flashMessage = null;
            this.$nextTick(() => {
                this.flashMessage = flash;
            });
        }
    }

};
</script>
