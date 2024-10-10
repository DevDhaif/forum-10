<template>
    <div class="p-4 bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-2 text-wrap">{{ $t('reply_to') }}: {{ reply.thread.title }}</h2>
        <p class="text-gray-700">{{ reply.body }}</p>
        <p class="text-sm text-gray-500 mt-2">{{ $t('reply_by') }}: {{ reply.owner.name }}</p>
        <p class="text-sm text-gray-500 mt-2">{{ $t('reply_on') }}: {{ formatDate(reply.created_at) }}</p>
        <Link class="text-sm text-blue-500 hover:underline" :href="`${reply.thread.path}#reply-${reply.id}`">{{
            $t('view_reply') }}
        </Link>
    </div>
</template>

<script>
import { formatDate } from '../Utils/helpers';
import { Link } from '@inertiajs/inertia-vue3';
export default {
    props: {
        reply: Object,
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
