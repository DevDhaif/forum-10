<template>
    <div>
        <Reply v-for="reply in this.replies.data" :key="reply.id" :reply="reply" :user="user"
            @replyDeleted="updateReplies"></Reply>
        <!-- <Flash :flash="flashMessage"></Flash> -->
    </div>
</template>
<script>
import Reply from "./Reply.vue";
import Flash from "./Flash.vue";
export default {
    components: {
        Reply,
        Flash,
    },
    props: ["replies", "thread", "user"],
    data() {
        return {
            flashMessage: null,
            errorMessage: "",
            body: "",
        }
    },
    methods: {

        updateReplies(replyId, thread, replies, flash) {
            Object.assign(this.thread, thread);
            Object.assign(this.replies, replies);
        }
    }
};
</script>
