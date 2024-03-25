<template>
    <span
        class="bg-blue-50 text-blue-900 text-sm font-medium inline-flex items-center px-4 py-2 rounded  border border-blue-400">
        <Eye :classes="'w-5 h-5 me-1.5'" />
        {{ item.visits }}
    </span>
</template>
<script>
import Eye from './Icons/Eye.vue';
export default {
    components: {
        Eye,
    },
    props: {
        item: {
            type: Object,
            required: true,
        },
    },
};
</script>
