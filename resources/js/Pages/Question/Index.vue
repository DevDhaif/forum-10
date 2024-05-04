<template>
    <div class="mx-auto">
        <h1 class="p-6 my-10 text-4xl font-bold text-blue-700 bg-blue-100 border-2 border-blue-200 rounded-md">
            {{ channel || 'All' }} Questions
        </h1>

        <div v-if="questions.length === 0" class="px-4 py-3">
            <p class="text-sm leading-5">No questions yet.</p>
        </div>

        <div class="max-w-[52rem] mx-auto px-4 pb-28 sm:px-6 md:px-8 xl:px-12 lg:max-w-6xl">
            <div
                class="relative sm:pb-12 sm:ml-[calc(2rem+1px)] md:ml-[calc(3.5rem+1px)] lg:ml-[max(calc(14.5rem+1px),calc(100%-48rem))]">
                <div
                    class="hidden absolute top-3 bottom-0 right-full mr-7 md:mr-[3.25rem] w-px bg-slate-200 dark:bg-slate-800 sm:block">
                </div>
                <div class="space-y-16">
                    <QuestionCard v-for="question in questions.data" :key="question.id" :question="question">
                    </QuestionCard>
                </div>
            </div>

        </div>
        <Pagination :links="questions.links"></Pagination>
    </div>
    <!--
    </div> -->
</template>

<script>
import QuestionCard from '../../components/QuestionCard.vue';

import Pagination from '../../Shared/Pagination.vue'
export default {
    components: {
        Pagination,
        QuestionCard,
    },
    props: {
        questions: Object,
        channel: String,
    },
    mounted() {
        console.log(this.questions);
    },
}
</script>
