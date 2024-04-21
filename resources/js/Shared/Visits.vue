<template>
    <div
        class="mr-4 flex items-center bg-blue-50 dark:bg-blue-200 text-blue-900 dark:text-blue-600 text-sm font-medium  px-4 py-2 rounded  border border-blue-400">
        <svg width="19" height="13" viewBox="0 0 19 13" class="mr-1 mb-0.5 text-blue-800 dark:text-blue-600">
            <g fill="none" fill-rule="evenodd">
                <path d="M0-3h19v19H0z"></path>
                <path class="fill-current"
                    d="M9.5.562C5.542.562 2.161 3.025.792 6.5c1.37 3.475 4.75 5.937 8.708 5.937s7.339-2.462 8.708-5.937C16.838 3.025 13.458.562 9.5.562zm0 9.896A3.96 3.96 0 0 1 5.542 6.5 3.96 3.96 0 0 1 9.5 2.542 3.96 3.96 0 0 1 13.458 6.5 3.96 3.96 0 0 1 9.5 10.458zm0-6.333A2.372 2.372 0 0 0 7.125 6.5 2.372 2.372 0 0 0 9.5 8.875 2.372 2.372 0 0 0 11.875 6.5 2.372 2.372 0 0 0 9.5 4.125z">
                </path>
            </g>
        </svg>
        <span class=" font-semibold text-blue-800 dark:text-blue-600">{{ item.visits }}</span>
    </div>
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
