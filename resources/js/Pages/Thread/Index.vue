<template>
    <div class="mx-auto">
        <h1 class="p-6 my-10 text-4xl font-bold text-blue-700 bg-blue-100 border-2 border-blue-200 rounded-md">
            {{ channel || "All" }} threads
        </h1>
        <div v-if="threads.length === 0" class="px-4 py-3">
            <p class="text-sm leading-5">No threads yet.</p>
        </div>
        <div v-for="thread in threads.data" :key="thread.id" class="p-6 mb-4 bg-white rounded-lg shadow">
            <thread-card class="prose" :thread="thread" :channel="channel"></thread-card>
        </div>
    </div>
    <Pagination :links="threads.links"></Pagination>
</template>

<script>
import Pagination from "../../Shared/Pagination.vue";
export default {
    components: {
        Pagination,
    },
    props: {
        threads: Array,
        channel: String,
    },


};
</script>
