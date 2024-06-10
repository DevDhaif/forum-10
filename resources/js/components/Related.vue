<template>
    <h1 class="capitalize">Related {{ type }} </h1>
    <div class="max-h-[540px] overflow-y-scroll space-y-4 py-2 shadow-md">

        <thread-card v-if="type === 'threads'" v-for="item in items" :key="item.id" :thread="item"></thread-card>
        <QuestionCard v-if="type === 'questions'" v-for="item in items" :key="item.id" :question="item"></QuestionCard>
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