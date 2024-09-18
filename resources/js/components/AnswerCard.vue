<template>
    <div class="p-4 bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-2">Answer to: {{ answer.question.title }}</h2>
        <p class="text-gray-700">{{ answer.body }}</p>
        <p class="text-sm text-gray-500 mt-2">Answered by: {{ answer.owner.name }}</p>
        <p class="text-sm text-gray-500 mt-2">Answered on: {{ formatDate(answer.created_at) }}</p>
    </div>
</template>

<script>
import { formatDate } from '../Utils/helpers';
export default {
    props: {
        answer: Object,
    },
    methods: {
        formatDate(date) {
            return formatDate(date);
        }
    }
};
</script>
