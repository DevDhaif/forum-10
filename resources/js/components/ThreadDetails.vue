<template>
    <div class="container p-4 mx-auto mt-6 bg-white rounded shadow">
        <div>
            <h2 class="text-2xl font-bold">{{ thread.title }}</h2>
            <div class="flex items-center justify-between mt-4 ">
                <div class="flex items-center space-x-2 ">
                    <p class="text-sm text-gray-600">
                        This thread was published {{ diffForHumans }} ago by
                        <a :href="userPath()" class="text-sm text-blue-600">
                            {{ thread.creator.name }}
                        </a>
                        in <a v-if="thread.channel" :href="`/threads/${thread.channel.slug}`" class="text-sm text-blue-600">
                            {{ thread.channel.name }}
                        </a>
                        and currently has {{ thread.replies_count }} replies .
                    </p>
                </div>
                <div v-if="canUpdate">
                    <form @submit.prevent="deleteThread">
                        <button title="Delete this thread" type="submit"
                            class="px-2 py-2 text-white bg-red-500 rounded hover:bg-red-600">
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
            <div class="mt-6 prose  prose-em:text-red-700 prose-code:prose-lg
            " v-html="thread.body"></div>
        </div>
        <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
    </div>

</template>
<script>
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import moment from "moment";
export default {
    props: ["thread", "user"],
    data(){
        return {
            errorMessage: ""
        }
    },
    methods: {
        userPath() {
            return `/profiles/${this.thread.creator.name}`;
        },
        deleteThread() {
            Inertia.delete(`/threads/${this.thread.channel.slug}/${this.thread.id}`)
                .then(() => {
                    flash("Thread deleted");
                })
                .catch((error) => {
                    this.errorMessage = "Could not delete the thread";
                });

            // axios
            //     .delete(`/threads/${this.thread.channel.slug}/${this.thread.id}`)
            //     .then((response) => {
            //         if (response.status === 204) {
            //             flash("Thread deleted");
            //             window.location.href = '/threads';
            //         }
            //     })
            //     .catch((error) => {
            //         this.errorMessage = "Could not delete the thread";
            //     });
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
