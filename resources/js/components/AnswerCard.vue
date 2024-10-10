<template>
    <div class="p-4 bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-2 text-wrap">{{ $t('answer_to') }}: {{ answer.question.title }}</h2>
        <p class="text-gray-700">{{ answer.body }}</p>
        <p class="text-sm text-gray-500 mt-2">{{ $t('answer_by') }}: {{ answer.owner.name }}</p>
        <p class="text-sm text-gray-500 mt-2">{{ $t('answer_on') }}: {{ formatDate(answer.created_at) }}</p>
        <Link class="text-sm text-blue-500 hover:underline" :href="`${answer.question.path}#answer-${answer.id}`">{{
            $t('view_answer') }}
        </Link>
    </div>
</template>

<script>
import { formatDate } from '../Utils/helpers';
import { Link } from '@inertiajs/inertia-vue3';
export default {
    props: {
        answer: Object,
    },
    components: {
        Link,
    },
    methods: {
        formatDate(date) {
            return formatDate(date);
        }
    }
};
</script>
