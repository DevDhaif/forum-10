<template>
    <div class="container flex items-start justify-between mx-auto mt-6 space-x-8">
        <div class="w-3/4">
            <QuestionDetails :question="question" :user="user"></QuestionDetails>
            <div class="p-4 mt-4 bg-slate-50 dark:bg-slate-900 rounded shadow">
                <p class="mt-6 text-sm text-gray-600"> This question has {{ question.answers_count }} answers. </p>
                <Answers :answers="answers" :question="question" :user="user" @flash="flash" />
                <PostAnswer :user="user" :question="question" @answerPosted="addAnswer" @flash="handleFlash"
                    @posted="posted"></PostAnswer>
                <pagination :links="answers.links"></pagination>
            </div>
        </div>
        <!-- <thread-info :thread="thread" :user="thread.creator" /> -->
    </div>
</template>

<script>
import Pagination from '../../Shared/Pagination.vue'
import Answers from '../../components/Answers.vue'
import PostAnswer from '../../components/PostAnswer.vue'
import QuestionDetails from '../../components/QuestionDetails.vue'
export default {
    components: {
        Pagination,
        QuestionDetails,
        Answers,
        PostAnswer,
    },
    props: ['question', 'user', 'answers'],
    data() {
        return {
            answers: this.answers,
            flashMessage: "",
            errorMessage: "",
            body: "",
        }
    },
    mounted() {
        // console.log(this.question)
    },
    methods: {
        flash(flash) {
            this.flashMessage = null
            this.$nextTick(() => {
                this.flashMessage = flash
            })
        },
        posted(question, answers, flash) {
            Object.assign(this.question, question);
            Object.assign(this.answers, answers);
            window.history.pushState({}, '', `/questions/${this.question.channel.slug}/${this.question.id}?page=${this.answers.current_page}`);
            this.flashMessage = null
            this.$nextTick(() => {
                this.flashMessage = flash
            })
        },
        postAnswer() {
            if (this.body === "") {
                this.errorMessage = "Please enter a valid answer"
                return
            }
            this.errorMessage = null

            if (this.question.channel) {
                axios.post(`/questions/${this.question.channel.slug}/${this.question.id}/answers`, {
                    body: this.body,
                })
                    .then((response) => {
                        Object.assign(this.question, response.data.question);
                        Object.assign(this.answers, response.data.answers);
                        window.history.pushState({}, '', `/questions/${this.question.channel.slug}/${this.question.id}?page=${this.answers.current_page}`);
                        this.flashMessage = null
                        this.$nextTick(() => {
                            this.flashMessage = response.data.flash
                        })
                        this.body = ""
                    })
                    .catch((error) => {
                        console.error(error)
                        this.errorMessage = "Something went wrong. Please try again"
                    })
            }
        },
    }

}
</script>
<style scoped lang="scss">
:deep(.bg-gray-200) {
    background-color: #edf2f7;
}

:deep(.rounded) {
    border-radius: 0.375rem;
}

:deep(.tiptap) {
    table {
        border-collapse: collapse;
        margin: 0;
        overflow: hidden;
        table-layout: fixed;
        width: 100%;

        td,
        th {
            border: 2px solid #ced4da;
            box-sizing: border-box;
            min-width: 1em;
            height: 2em;
            padding: 3px 5px;
            position: relative;
            vertical-align: top;

            >* {
                margin-bottom: 0;
            }
        }

        th {
            background-color: #f1f3f5;
            font-weight: bold;
            text-align: left;
        }

        .selectedCell:after {
            background: rgba(200, 200, 255, 0.4);
            content: '';
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            pointer-events: none;
            position: absolute;
            z-index: 2;
        }

        .column-resize-handle {
            background-color: #adf;
            bottom: -2px;
            position: absolute;
            right: -2px;
            pointer-events: none;
            top: 0;
            width: 4px;
        }

        p {
            margin: 0;
        }
    }
}

.tableWrapper {
    padding: 1rem 0;
    overflow-x: auto;
}

.resize-cursor {
    cursor: ew-resize;
    cursor: col-resize;
}
</style>
