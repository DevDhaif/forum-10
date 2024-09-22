<template>
    <div>
        <reply v-for="reply in this.replies.data" :key="reply.id" :reply="reply" :user="user"
            @replyDeleted="updateReplies"></reply>
        <flash :flash="flashMessage"></flash>
    </div>
</template>
<script>
import Reply from "./Reply.vue";
export default {
    components: {
        Reply,
    },
    props: ["replies", "thread", "user"],
    data() {
        return {
            // replies: this.replies,
            // thread: this.thread,
            flashMessage: null,
            errorMessage: "",
            body: "",
        }
    },
    methods: {

        updateReplies(replyId, thread, replies, flash) {
            Object.assign(this.thread, thread);
            Object.assign(this.replies, replies);
            console.log(flash)
            this.flashMessage = null;
            this.flashMessage = { message: flash, type: "success" }
            // this.flashMessage = null;
        }
    }
};
</script>
