<template>
    <div class="relative">

        <div class=" px-4 py-2 outline-blue-300/50 max-w-fit rounded-lg  outline outline-1 items-center text-center"
            :class="{ 'flex flex-col space-y-4': type === 'question', 'flex space-x-4 justify-between w-full': type === 'answer' }">

            <button @click="toggleUpvote" class="text-sm text-white">
                <svg aria-hidden="true" class=" hover:fill-blue-400"
                    :class="{ 'fill-blue-300': !isUpvoted, ' fill-blue-600': isUpvoted }" width="18" height="18"
                    viewBox="0 0 18 18">
                    <path d="M1 12h16L9 4l-8 8Z"></path>
                </svg>
            </button>
            <span class="text-sm">{{ item.votes_count }}</span>
            <button @click="toggleDownVote" class="text-sm text-white">
                <svg aria-hidden="true" class=" hover:fill-red-400"
                    :class="{ 'fill-red-300': !isDownvoted, ' fill-red-600': isDownvoted }" width="18" height="18"
                    viewBox="0 0 18 18">
                    <path d="M1 6h16l-8 8-8-8Z"></path>
                </svg>
            </button>

        </div>
        <p v-if="errorMessage" class="text-red-500 absolute ">{{ errorMessage }}</p>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    props: {
        item: {
            type: Object,
            required: true,
        },
        type: {
            type: String,
            required: true,
        },
        user: {
            type: Object,
        },
    },

    data() {
        return {
            isUpvoted: this.item.isUpvoted || false,
            isDownVoted: this.item.isDownVoted || false,
            errorMessage: "",
        };
    },

    methods: {
        async toggleUpvote() {
            if (!this.user) {
                window.location.href = '/login';
                return;
            }
            try {
                const method = this.isUpvoted ? 'delete' : 'post';
                const response = await axios[method](`/${this.type}/${this.item.id}/upvotes`);
                this.isUpvoted = response.data.isUpvoted;
                this.item.votes_count = response.data.votes_count;
                console.log(response.data);
            } catch (error) {
                this.errorMessage = "could not toggle upvote";
            }
        },
        async toggleDownVote() {
            if (!this.user) {
                window.location.href = '/login';
                return;
            }
            try {
                const method = this.isDownVoted ? 'delete' : 'post';
                const response = await axios[method](`/${this.type}/${this.item.id}/downvotes`);
                this.isDownVoted = !this.isDownVoted;
                this.isUpvoted = false;
                this.item.votes_count = response.data.votes_count;
            } catch (error) {
                this.errorMessage = "could not toggle downvote";
            }
        },

    },
};
</script>
