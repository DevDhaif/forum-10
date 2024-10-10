<template>
    <div>
        <!-- Loop through the sorted answers -->
        <Answer v-for="answer in sortedAnswers" :key="answer.id" :answer="answer" :user="user"
            @answerMarkedAsBest="handleMarkedAsBest" @answerDeleted="updateAnswers"
            @bestAnswerDeleted="handleBestAnswerDeleted" @bestAnswerChanged="handleBestAnswerChanged"></Answer>
        <!-- <FLash :flash="flashMessage"></FLash> -->
    </div>
</template>

<script>
import Answer from "./Answer.vue";
import Flash from "./Flash.vue";
export default {
    components: {
        Answer,
        Flash,
    },
    props: ["answers", "question", "user"],
    data() {
        return {
            flashMessage: null,
            errorMessage: "",
            body: "",
        };
    },
    computed: {
        // Computed property to sort answers
        sortedAnswers() {
            return this.answers.data.sort((a, b) => {
                // Sort by is_best first (best answer on top)
                if (a.is_best && !b.is_best) return -1;
                if (!a.is_best && b.is_best) return 1;

                // Then sort by by_ai (AI answer always after the best answer if exists)
                if (a.by_ai && !b.by_ai) return -1;
                if (!a.by_ai && b.by_ai) return 1;

                // Finally, sort by latest (default sort for user answers)
                return new Date(b.created_at) - new Date(a.created_at);
            });
        },
    },
    methods: {
        updateAnswers(answerId, question, answers, flash) {
            Object.assign(this.question, question);
            Object.assign(this.answers, answers);
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
            this.question.is_solved = false;
        }
    },
};
</script>
