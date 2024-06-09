<template>
    <div>
        <Answer v-for="answer in this.answers.data" :key="answer.id" :answer="answer" :user="user"
            @answerMarkedAsBest="handleMarkedAsBest" @answerDeleted="updateAnswers"
            @bestAnswerDeleted="handleBestAnswerDeleted" @bestAnswerChanged="handleBestAnswerChanged"></Answer>
        <flash :flash="flashMessage"></flash>
    </div>
</template>
<script>
import Answer from "./Answer.vue";
export default {
    components: {
        Answer,
    },
    props: ["answers", "question", "user"],
    data() {
        return {
            // answers: this.answers,
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
        },
        handleMarkedAsBest(updatedAnswer) {
            const index = this.answers.data.findIndex(answer => answer.id === updatedAnswer.id);
            if (index !== -1) {
                this.answers.data.forEach(answer => {
                    answer.is_best = false;
                });
                this.answers.data[index].is_best = true;
            }
        },
        handleBestAnswerChanged(newIsSolvedValue, answerId) {
            this.question.is_solved = newIsSolvedValue;

            if (newIsSolvedValue) {
                this.answers.data.forEach(answer => {
                    if (answer.id !== answerId) {
                        answer.is_best = false;
                    }
                });
            }
        },
        handleBestAnswerDeleted() {
            console.log("best answer was deleted ");
            console.log(this.question.is_solved);
            this.question.is_solved = false;
            console.log(this.question.is_solved);
        }
    },
};
</script>
