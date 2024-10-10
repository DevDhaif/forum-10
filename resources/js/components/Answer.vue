<template v-cloak>

    <div class="mt-8 relative flex border-b py-4 rtl:text-right ltr:text-left"
        :class="{ 'rounded outline outline-blue-400 outline-1 bg-blue-50 dark:border-blue-300': answer.by_ai }">
        <div v-if="answer.by_ai"
            class="absolute -top-4 font-semibold right-0 bg-blue-100 dark:bg-slate-800/10 text-blue-500 dark:text-blue-300 text-xs px-2 py-1 rounded-bl-lg">
            {{ $t('aiAnswer') }}
        </div>
        <div class="flex items-center justify-between w-full px-2"
            :class="{ 'border  outline-green-600 dark:outline-green-300 outline outline-1 bg-green-50 dark:bg-slate-800/10 rounded-lg': answer.is_best }">

            <Vote v-if="!answer.by_ai" :item="answer" type="answer" :user="user" />
            <div :id="'answer-' + answer.id" name="fade" class="py-2 px-4 flex-1  flex justify-between"
                :class="{ '': answer.is_best }">
                <div class="flex items-center justify-between mt-4  w-full ">
                    <div v-if="editing" class="flex flex-col w-full ">
                        <textarea class="border" v-model="editText"></textarea>
                        <div class="mt-2">
                            <Btn color="blue" @click="saveEdit">{{ $t('save') }}</Btn>
                            <Btn color="red" @click="cancelEdit">{{ $t('cancel') }}</Btn>
                        </div>
                    </div>

                    <div v-else class="w-full" :class="{ 'flex  space-x-4 justify-between ': !answer.by_ai }">
                        <!-- show  answer in markdown -->
                        <div class="whitespace-pre-wrap  !self-start !justify-self-start"
                            :class="getAlignment(answer.body)" v-html="answer.body" />

                        <div v-if="((user?.id === answer.user_id) || this.isAdmin) && !answer.by_ai"
                            class="cursor-pointer">
                            <v-menu>
                                <template v-slot:activator="{ props }">
                                    <button v-bind="props"
                                        class="hover:bg-gray-100 cursor-pointer rounded-lg  p-1 outline outline-gray-300 outline-1 shadow-sm ">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" class="size-6 cursor-pointer hover:cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                        </svg>

                                    </button>
                                </template>
                                <v-list>
                                    <v-list-item class="hover:bg-gray-100 cursor-pointer  px-4 py-2">
                                        <v-list-item-title @click="editAnswer"> {{ $t('edit') }}</v-list-item-title>
                                    </v-list-item>
                                    <v-list-item class="hover:bg-gray-100 cursor-pointer mt-2 px-4 py-2">
                                        <v-list-item-title @click="deleteAnswer"> {{ $t('delete') }}</v-list-item-title>
                                    </v-list-item>
                                    <v-list-item class="hover:bg-gray-100 cursor-pointer mt-2 px-4 py-2">
                                        <v-list-item-title @click="markAsBest">
                                            {{ answer.is_best ? $t('unmarkAsBest') : $t('markAsBest') }}
                                        </v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </div>
                    </div>
                </div>
                <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
            </div>
        </div>

    </div>
</template>

<script>
import axios from "axios";
import Vote from "./Vote.vue";
import Flash from "./Flash.vue";
import Btn from "./Btn.vue";
import { useToast } from 'vue-toastification';

export default {
    props: ["answer", "user"],
    components: {
        Vote,
        Flash,
        Btn,
    },
    data() { return { editing: false, editText: this.answer.body, errorMessage: "", flashMessage: null }; },
    methods: {
        markAsBest() {
            const toast = useToast();

            if (!this.answer.is_best) {
                axios
                    .post(`/questions/${this.answer.question.id}/answers/${this.answer.id}/best`)
                    .then((response) => {
                        this.answer.is_best = !this.answer.is_best;
                        this.$emit('answerMarked', this.answer);
                        this.$emit('bestAnswerChanged', this.answer.is_best, this.answer.id);
                        let msg = this.$t(response.data.flash)
                        toast.success(msg);
                        this.errorMessage = null;
                    })
                    .catch((error) => {
                        this.errorMessage = this.$t('couldNotMarkAsBest');
                    });
            } else {
                this.removeBestMark();
            }
        },
        editAnswer() { this.editing = true; },
        deleteAnswer() {
            const toast = useToast();
            if (this.answer.is_best) {
                this.removeBestMark().then(() => { this.deleteAnswerFromServer(); })
            }
            else { this.deleteAnswerFromServer(); }
        },
        deleteAnswerFromServer() {
            const toast = useToast();
            axios
                .delete(`/answers/${this.answer.id}`)
                .then((response) => {
                    this.$emit('answerDeleted', this.answer.id, response.data.question, response.data.answers, response.data.flash);
                    let msg = this.$t(response.data.flash)
                    toast.success(msg);
                    this.errorMessage = null;
                })
                .catch((error) => {
                    this.errorMessage = this.$t('couldNotDelete');
                });
        },
        removeBestMark() {
            const toast = useToast();
            return axios
                .delete(`/questions/${this.answer.question.id}/answers/${this.answer.id}/best`)
                .then((response) => {
                    this.answer.is_best = !this.answer.is_best;
                    this.$emit('answerMarked', this.answer);
                    this.$emit('bestAnswerChanged', this.answer.is_best, this.answer.id);
                    let msg = this.$t(response.data.flash)
                    toast.success(msg);
                    this.errorMessage = null;
                })
                .catch((error) => {
                    this.errorMessage = this.$t('couldNotRemoveBestMark');
                });
        },
        saveEdit() {
            const toast = useToast();
            axios.patch(`/answers/${this.answer.id}`, {
                body: this.editText,
            })
                .then((response) => {
                    this.body = this.editText;
                    this.answer.body = this.editText;
                    this.editing = false;
                    this.flashMessage = { message: response.data.flash, type: "success" }
                    let msg = this.$t(response.data.flash)
                    toast.success(msg);
                    this.errorMessage = null;
                })
                .catch((error) => {
                    this.flashMessage = { message: response.data.flash, type: "error" }
                    this.errorMessage = this.$t('couldNotSaveAnswer');
                });
        },
        cancelEdit
            () {
            this.editing = false;
        },
        getAlignment(text) {
            // Check if the first character is Arabic
            const arabicPattern = /[\u0600-\u06FF]/;
            if (arabicPattern.test(text)) {
                return 't-right '; // Apply right alignment for Arabic
            } else {
                return 't-left'; // Apply left alignment for English and other languages
            }
        },
    },
    mounted() {
        console.log(this.answer);
    }
};
</script>
<style>
[v-cloak] {
    display: none;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
<style scoped>
.t-right {
    direction: rtl;
    text-align: right;
}

.t-left {
    direction: ltr;
    text-align: left;
}

.ai-answer {
    background-color: #f0f8ff;
    border-left: 5px solid #2a9d8f;
    padding: 10px;
    margin-bottom: 10px;
}

.answer-actions {
    margin-top: 10px;
}

.ai-label {
    font-size: 0.9em;
    color: #6c757d;
    margin-bottom: 10px;
}

.tiptap table {
    border-collapse: collapse;
    margin: 0;
    overflow: hidden;
    table-layout: fixed;
    width: 100%;
}

.tiptap td,
.tiptap th {
    border: 2px solid #ced4da;
    box-sizing: border-box;
    min-width: 1em;
    padding: 3px 5px;
    position: relative;
    vertical-align: top;
}

.tiptap th {
    background-color: #f1f3f5;
    font-weight: bold;
    text-align: left;
}

.tiptap .selectedCell:after {
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

.tiptap .column-resize-handle {
    background-color: #adf;
    bottom: -2px;
    position: absolute;
    right: -2px;
    pointer-events: none;
    top: 0;
    width: 4px;
}

.tiptap p {
    margin: 0;
}
</style>
