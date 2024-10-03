<template>
    <div v-if="user">
        <h1 class="text-2xl font-bold">{{ $t('yourReply') }}</h1>
        <form class="relative my-6" @submit.prevent="postReply">
            <div class="mt-6">
                <textarea v-model="body" name="body" class="w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500
                " :placeholder="$t('haveSomethingToSay')" rows="5"></textarea>
            </div>
            <button type="submit"
                class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                {{ $t('post') }}
            </button>
        </form>
        <Flash :flash="flashMessage"></Flash>
        <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
    </div>
</template>
<script>
import axios from 'axios';
import Flash from './Flash.vue';
export default {
    name: "PostReply",
    components: { Flash },
    props: ["thread", "user"],
    data() {
        return {
            body: "",
            errorMessage: "",
            flashMessage: null
        };
    },
    methods: {
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
                        this.$emit('posted', response.data.thread, response.data.replies, response.data.flash)
                        this.flashMessage = { message: response.data.flash, type: "success" }
                        this.body = ""
                    })
                    .catch((error) => {
                        console.error(error)
                        this.flashMessage = { message: response.data.flash, type: "error" }
                        this.errorMessage = "Something went wrong. Please try again"
                    })
            }
        },
    },
}
</script>
