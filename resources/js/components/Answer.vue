<template v-cloak>

    <div class="flex border-b py-4">

        <Vote :item="answer" type="answer" :user="user" />
        <div :id="'answer-' + answer.id" name="fade" class="mt-4 p-4 flex-1"
            :class="{ 'border  outline-blue-600 dark:outline-blue-300 outline outline-1 bg-blue-50 dark:bg-slate-800/10 rounded-lg': answer.is_best }">
            <div class="flex items-center justify-between mt-4">
                <div v-if="editing" class="flex flex-col w-full ">
                    <textarea class="border" v-model="editText"></textarea>
                    <div class="mt-2">
                        <Btn color="blue" @click="saveEdit">{{ $t('save') }}</Btn>
                        <Btn color="red" @click="cancelEdit">{{ $t('cancel') }}</Btn>
                    </div>
                </div>
                <div v-else class="flex space-x-4 justify-between w-full">
                    <p>{{ answer.body }}</p>
                    <div v-if="(user?.id === answer.user_id) || this.isAdmin">
                        <Btn color="blue" @click="editAnswer">{{ $t('edit') }}</Btn>
                        <Btn color="red" @click="deleteAnswer">{{ $t('delete') }}</Btn>
                    </div>
                </div>

                <button @click="markAsBest" v-if="(user?.id === answer.question.creator.id)"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                    {{ answer.is_best ? $t('unmarkAsBest') : $t('markAsBest') }}
                </button>
            </div>
            <!-- <Flash :flash="flashMessage"></Flash> -->
            <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
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
