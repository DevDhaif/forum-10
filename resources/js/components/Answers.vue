<template>
    <div>
        <h1>answers all here </h1>
        <Answer v-for="answer in this.answers.data" :key="answer.id" :answer="answer" :user="user"
            @answerDeleted="updateAnswers"></Answer>
        <flash :flash="flashMessage"></flash>
    </div>
</template>
<script>
import Answer from "./Answer.vue";
export default {
    components: {
        Answer,
    },
    props: ["answers", "question", "user", "key"],
    data() {
        return {
            answers: this.answers,
            question: this.question,
            flashMessage: null,
            errorMessage: "",
            body: "",
        }
    },
    methods: {

        updateAnswers(answerId, question, answers, flash) {
            Object.assign(this.question, question);
            Object.assign(this.answers, answers);
            console.log(flash)
            this.flashMessage = null;
            this.flashMessage = { message: flash, type: "success" }
            // this.flashMessage = null;
        }
    },
    mounted() {
        // console.log(this.question)
    }

};
</script>
