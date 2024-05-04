<template>
    <div class="relative">

        <div
            class="flex flex-col space-y-4 px-4 py-2 outline-blue-300/50 max-w-fit rounded-lg  outline outline-1 items-center text-center">
            <button @click="toggleVote" class="text-sm text-white">
                <svg aria-hidden="true" class=" hover:fill-blue-400"
                    :class="{ 'fill-blue-300': !isVoted, ' fill-blue-600': isVoted }" width="18" height="18"
                    viewBox="0 0 18 18">
                    <path d="M1 12h16L9 4l-8 8Z"></path>
                </svg>
            </button>
            <span class="text-sm">{{ item.votes_count }}</span>
            <button @click="toggleDownVote" class="text-sm text-white">
                <svg aria-hidden="true" class=" hover:fill-red-400"
                    :class="{ 'fill-red-300': !isVoted, ' fill-red-600': isVoted }" width="18" height="18"
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
            isVoted: this.item.isVoted || false,
            isDownVoted: this.item.isDownVoted || false,
            errorMessage: "",
        };
    },

    methods: {
        async toggleVote() {
            if (!this.user) {
                window.location.href = '/login';
                return;
            }
            try {
                const method = this.isVoted ? 'delete' : 'post';
                const response = await axios[method](`/${this.type}/${this.item.id}/votes`);
                this.isVoted = response.data.isVoted;
                this.item.votes_count = response.data.votes_count;
            } catch (error) {
                this.errorMessage = "could not toggle vote";
            }
        },
        toggleDownVote() {
            if (!this.user) {
                window.location.href = '/login';
                return;
            }
            try {
                const method = this.isDownVoted ? 'delete' : 'post';
                axios[method](`/${this.type}/${this.item.id}/downvotes`);
                this.isDownVoted = !this.isDownVoted;
            } catch (error) {
                this.errorMessage = "could not toggle downvote";
            }
        },

    },
};
</script>

<!-- <svg :class="{
            ' text-blue-500': !isVoted,
            ' text-red-500': isVoted,
        }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-4 h-4 transition-colors duration-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
            </svg> -->
