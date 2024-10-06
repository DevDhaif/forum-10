<template>
    <h1 class="capitalize">{{ $t('a' + type) }} {{ $t('related') }} </h1>
    <div class="lg:max-h-[540px] overflow-y-scroll space-y-4 py-2 shadow-md">

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
