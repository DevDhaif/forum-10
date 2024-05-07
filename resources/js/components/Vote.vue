<template>
    <div class="relative">

        <div
            class=" flex flex-col space-y-2 px-4 py-2 outline-blue-300/50 max-w-fit rounded-lg  items-center text-center">
            <!-- :class="{ '': type === 'question', 'flex space-x-4 justify-between w-full': type === 'answer' }" -->

            <button @click="toggleUpvote"
                class="text-sm text-white rounded-full p-2 outline outline-1 outline-slate-300 hover:bg-green-100 group">
                <svg aria-hidden="true" class="w-6 h-6 group-hover:fill-green-400 "
                    :class="{ 'fill-slate-500': !isUpvoted, ' fill-green-500': isUpvoted }" viewBox="0 0 18 18">
                    <path d="M1 12h16L9 4l-8 8Z"></path>
                </svg>
            </button>
            <span class="text-lg font-semibold">{{ item.votes_count }}</span>
            <button @click="toggleDownVote"
                class="text-sm text-white rounded-full p-2 outline outline-1 outline-slate-300 hover:bg-red-100 group">
                <svg aria-hidden="true" class=" group-hover:fill-red-400 w-6 h-6 "
                    :class="{ 'fill-slate-500': !isDownvoted, ' fill-red-600': isDownvoted }" viewBox="0 0 18 18">
                    <path d="M1 6h16l-8 8-8-8Z"></path>
                </svg>
            </button>

            <Checkmark :show="item.is_solved || item.is_best" />
        </div>
        <p v-if="errorMessage" class="text-red-500 absolute ">{{ errorMessage }}</p>
    </div>
</template>
<script>
import axios from 'axios';
import Checkmark from './Checkmark.vue';
export default {
    components: {
        Checkmark,
    },
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
            isDownvoted: this.item.isDownvoted || false,
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
                this.isDownvoted = false;
                this.item.votes_count = response.data.votes_count;
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
                const method = this.isDownvoted ? 'delete' : 'post';
                const response = await axios[method](`/${this.type}/${this.item.id}/downvotes`);
                this.isDownvoted = response.data.isDownvoted;
                this.isUpvoted = false;
                this.item.votes_count = response.data.votes_count;
            } catch (error) {
                this.errorMessage = "could not toggle downvote";
            }
        },

    }
};
</script>
