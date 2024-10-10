<template>
    <h1 class="capitalize text-center">{{ $t('a' + type) }} {{ $t('related') }} </h1>
    <div class="lg:max-h-screen overflow-y-scroll space-y-4 py-2 shadow-md ltr:border-l-blue-500 ltr:pl-2 rtl:border-r-blue-500 rtl:pr-2">

        <div v-if="type === 'threads'">
            <thread-card class="my-2" v-for="item in items" :key="item.id" :thread="item"></thread-card>
        </div>
        <div v-if="type === 'questions'">
            <question-card class="my-2" v-for="item in items" :key="item.id" :question="item"></question-card>
        </div>
    </div>
</template>
<script>
import QuestionCard from "./QuestionCard.vue";
export default {
    components: {
        QuestionCard,
    },
    props: ['items', 'type']
}
</script>
