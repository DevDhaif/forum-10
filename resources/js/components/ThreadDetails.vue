<template>
    <div class="bg-white p-4 rounded shadow w-full flex justify-between gap-x-4 items-center">
        <p class="text-gray-600 text-sm">This thread was published {{ diffForHumans }} ago by
            <a :href="userPath()" class="text-blue-600 text-sm">
                {{ thread.creator.name }}
            </a>
            and currently has {{ thread.replies_count }} replies .
        </p>
        <div v-if="canUpdate">
            <form @submit.prevent="deleteThread">
                <button type="submit" class="bg-red-500 text-white rounded py-2 px-2 hover:bg-red-600">
                    Delete Thread</button>
            </form>
        </div>
        <div class="bg-white p-4 rounded shadow flex items-start justify-between">
            <p>{{ thread.title }}</p>
            <favorite :item="thread" type="thread" :user="user"></favorite>
        </div>
    </div>
    <div class="bg-white p-4 rounded shadow">

        <p class="text-gray-600 text-sm mt-6">
            {{ thread.body }}
        </p>

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
