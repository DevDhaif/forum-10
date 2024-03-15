<template>
    <div class="mx-auto">
        <h1 class="p-6 my-10 text-4xl font-bold text-blue-700 bg-blue-100 border-2 border-blue-200 rounded-md">
            {{ channel || "All" }} threads
        </h1>
        <div v-if="threads.length === 0" class="px-4 py-3">
            <p class="text-sm leading-5">No threads yet.</p>
        </div>
        <div v-for="thread in threads.data" :key="thread.id" class="p-6 mb-4 bg-white rounded-lg shadow">
            <div class="space-y-4">
                <div class="flex items-center justify-between w-full py-4 mt-4">
                    <div>
                        <Link :href="thread.path" class="flex-1 text-sm text-blue-600">
                        {{ thread.title }} tit
                        </Link>
                        <Link :href="'threads/' + thread.channel.slug" class="px-4 text-red-500">
                        {{ thread.channel.name || "" }} yass
                        </Link>
                    </div>
                    <p class="text-sm text-gray-600">
                        Published {{ formatDate(thread.created_at) }} by
                        <Link :href="thread.creator" class="text-sm text-blue-600">
                        {{ thread.creator.name }}
                        </Link>
                        and has {{ thread.replies_count }}
                        {{ thread.replies_count > 1 ? "replies" : "reply" }}.
                    </p>
                </div>
                <p class="mt-6 text-sm text-gray-600">
                    {{
                thread.body.length > 100
                    ? thread.body.substring(0, 100) + "..."
                    : thread.body
            }}
                    <Link v-if="thread.body.length > 100" :href="thread.path" class="text-sm text-blue-600">Read
                    more</Link>
                </p>
            </div>
        </div>
    </div>
    <Pagination :links="threads.links"></Pagination>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import Pagination from "../../Shared/Pagination.vue";
import moment from "moment";
export default {
    components: {
        Link,
        Pagination,
    },
    props: {
        threads: Array,
        channel: String,
    },

    computed: {
        formatDate() {
            return (date) => moment(date).fromNow();
        },
    },
};
</script>
