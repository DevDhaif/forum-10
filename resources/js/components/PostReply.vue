<template>
    <div v-if="user">
        <p class="text-gray-600 text-sm mt-6">
            This thread has {{ thread.replies_count }} replies.
        </p>
        <form @submit.prevent="postReply" class="mt-6">
            <div class="mt-6">
                <textarea v-model="body" name="body" class="w-full" placeholder="Have something to say?" rows="5"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white rounded py-2 px-2 hover:bg-blue-600 mt-4">Post
            </button>
        </form>
        <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    name: "PostReply",
    props: ["thread", "user"],
    data() {
        return {
            body: "",
            errorMessage: "",
        };
    },
    methods: {
        async postReply() {
            if (this.body === "") {
                this.errorMessage = "Please enter a valid reply";
                return;
            }
            this.errorMessage = null;
            await axios.post(`/threads/${this.thread.channel.slug}/${this.thread.id}/replies`, {
                body: this.body,
            })
                .then((response) => {
                    this.$emit('replyPosted', response.data);
                    this.body = "";
                    flash("Reply posted");
                })
                .catch((error) => {
                    this.errorMessage = "Something went wrong. Please try again";
                    console.error(error);
                });
        }
    }
}
</script>
