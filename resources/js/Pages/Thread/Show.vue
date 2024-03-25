<template>
    <div class="container flex items-start justify-between mx-auto mt-6 space-x-8">
        <div class="w-3/4">
            <thread-details :thread="thread" :user="user"></thread-details>
            <div class="p-4 mt-4 bg-white rounded shadow">
                <p class="mt-6 text-sm text-gray-600"> This thread has {{ thread.replies_count }} replies. </p>
                <post-reply :user="user" :thread="thread" @replyPosted="addReply" @flash="handleFlash"
                    @posted="posted"></post-reply>
                <replies :replies="replies" :thread="thread" :user="user" @flash="flash">
                </replies>
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
            flashMessage: "",
            errorMessage: "",
            body: "",
        }
    },
    methods: {
        flash(flash) {
            this.flashMessage = null
            this.$nextTick(() => {
                this.flashMessage = flash
            })
        },
        posted(thread, replies, flash) {
            Object.assign(this.thread, thread);
            Object.assign(this.replies, replies);
            window.history.pushState({}, '', `/threads/${this.thread.channel.slug}/${this.thread.id}?page=${this.replies.current_page}`);
            this.flashMessage = null
            this.$nextTick(() => {
                this.flashMessage = flash
            })
        },
        postReply() {
            if (this.body === "") {
                this.errorMessage = "Please enter a valid reply"
                return
            }
            this.errorMessage = null

            if (this.thread.channel) {
                axios.post(`/threads/${this.thread.channel.slug}/${this.thread.id}/replies`, {
                    body: this.body,
                })
                    .then((response) => {
                        Object.assign(this.thread, response.data.thread);
                        Object.assign(this.replies, response.data.replies);
                        window.history.pushState({}, '', `/threads/${this.thread.channel.slug}/${this.thread.id}?page=${this.replies.current_page}`);
                        this.flashMessage = null
                        this.$nextTick(() => {
                            this.flashMessage = response.data.flash
                        })
                        this.body = ""
                    })
                    .catch((error) => {
                        console.error(error)
                        this.errorMessage = "Something went wrong. Please try again"
                    })
            }
        },
    }
}
</script>
