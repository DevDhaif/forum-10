<template>
    <div class="mx-auto">
        <h1 class="p-6 my-10 text-4xl font-bold text-blue-700 bg-blue-100 border-2 border-blue-200 rounded-md">
            {{ channel || 'All' }} Content
        </h1>

        <div v-if="content.length === 0" class="px-4 py-3">
            <p class="text-sm leading-5">No content yet.</p>
        </div>

        <div class="max-w-[52rem] mx-auto px-4 pb-28 sm:px-6 md:px-8 xl:px-12 lg:max-w-6xl">
            <div
                class="relative sm:pb-12 sm:ml-[calc(2rem+1px)] md:ml-[calc(3.5rem+1px)] lg:ml-[max(calc(14.5rem+1px),calc(100%-48rem))]">
                <div
                    class="hidden absolute top-3 bottom-0 right-full mr-7 md:mr-[3.25rem] w-px bg-slate-200 dark:bg-slate-800 sm:block">
                </div>
                <div class="space-y-16">
                    <!-- Loop through the combined content -->
                    <template v-for="item in content.data" :key="item.id">
                        <thread-card v-if="item.hasOwnProperty('replies_count')" :thread="item"></thread-card>
                        <question-card v-else :question="item"></question-card>
                    </template>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <Pagination :links="content.links"></Pagination>
    </div>
</template>

<script>
import ThreadCard from '../../components/ThreadCard.vue';
import QuestionCard from '../../components/QuestionCard.vue';
import Pagination from '../../Shared/Pagination.vue';

export default {
    components: {
        ThreadCard,
        QuestionCard,
        Pagination,
    },
    props: {
        content: Object,
        channel: String,
    },
}
</script>
