<template>
    <div class="p-4 bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-2">Reply to: {{ reply.thread.title }}</h2>
        <p class="text-gray-700">{{ reply.body }}</p>
        <p class="text-sm text-gray-500 mt-2">Replied by: {{ reply.owner.name }}</p>
        <p class="text-sm text-gray-500 mt-2">Replied on: {{ formatDate(reply.created_at) }}</p>
    </div>
</template>

<script>
import { formatDate } from '../Utils/helpers';
export default {
    props: {
        reply: Object,
    },
    methods: {
        formatDate(date) {
            return formatDate(date);
        }
    }
};
</script>
