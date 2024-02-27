<template>
    <div class="container mx-auto  mt-6 bg-white shadow rounded p-4">
    <div>
        <h2 class="text-2xl font-bold">{{ thread.title }}</h2>
        <div class="flex justify-between items-center mt-4 ">
            <div class="flex space-x-2 items-center ">
                <p class="text-gray-600 text-sm">
                    This thread was published {{ diffForHumans }} ago by
                    <a :href="userPath()" class="text-blue-600 text-sm">
                        {{ thread.creator.name }}
                    </a>
                    in <a :href="`/threads/${thread.channel.slug}`" class="text-blue-600 text-sm">
                        {{ thread.channel.name }}
                    </a>
                    and currently has {{ thread.replies_count }} replies .

                    <a :href="`/threads/${thread.channel.slug}`" class="text-blue-600 text-sm">
                        {{ thread.channel.name }}
                    </a>
                </p>
            </div>
            <div v-if="canUpdate">
                <form @submit.prevent="deleteThread">
                    <button title="Delete this thread" type="submit" class="bg-red-500 text-white rounded py-2 px-2 hover:bg-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 6l3-3m0 0l3 3m-3-3v14a2 2 0 002 2h10a2 2 0 002-2V6m-3 0h6m-9 0v0"></path>
                        </svg>
                    </button>
                </form>
            </div>
            <favorite :item="thread" type="thread" :user="user"></favorite>
        </div>

    </div>
    <hr class="my-4 border-gray-200">
    <div class="p-2 ">
        <p class="text-gray-600 text-sm mt-6">
            {{ thread.body }}
        </p>
    </div>
</div>

</template>
<script>
import axios from "axios";
import moment from "moment";
export default {
    props: ["thread", "user"],
    methods: {
        userPath() {
            return `/profiles/${this.thread.creator.name}`;
        },
        deleteThread() {
            axios
                .delete(`/threads/${this.thread.channel.slug}/${this.thread.id}`)
                .then((response) => {
                    if (response.status === 204) {
                        flash("Thread deleted");
                        window.location.href = '/threads';
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    computed: {
        diffForHumans() {
            return moment(this.thread.created_at).fromNow();
        },
        canUpdate() {
            return this.user && this.thread.creator.id === this.user.id;
        },
    },

}
</script>
