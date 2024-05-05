<template v-cloak>
    <div :id="'answer-' + answer.id" name="fade" class="mt-4 p-4"
        :class="{ 'border  outline-blue-500 outline outline-1 bg-blue-50 rounded-lg': answer.is_best }">
        <div class="flex items-center justify-between mt-4">
            <div v-if="editing" class="flex flex-col w-full ">
                <textarea class="border" v-model="editText"></textarea>
                <div class="mt-2">
                    <btn color="blue" @click="saveEdit">Save</btn>
                    <btn color="red" @click="cancelEdit">Cancel</btn>
                </div>
            </div>
            <div v-else class="flex space-x-4 justify-between w-full">
                <p>{{ answer.body }}</p>
                <div v-if="(user?.id === answer.user_id) || this.isAdmin">
                    <btn color="blue" @click="editAnswer">Edit</btn>
                    <btn color="red" @click="deleteAnswer">Delete</btn>
                </div>
            </div>
            <Vote :item="answer" type="answer" :user="user"></Vote>
            <!-- <favorite :item="answer" type="answer" :user="user" /> -->
        </div>
        <flash :flash="flashMessage"></flash>
        <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
    </div>
</template>

<script>
import axios from "axios";
import Vote from "./Vote.vue";

export default {
    props: ["answer", "user"],
    components: {
        Vote,
    },
    data() { return { editing: false, editText: this.answer.body, errorMessage: "", flashMessage: null }; },
    methods: {
        editAnswer() { this.editing = true; },
        deleteAnswer() {
            axios
                .delete(`/answers/${this.answer.id}`)
                .then((response) => {
                    this.$emit('answerDeleted', this.answer.id, response.data.question, response.data.answers, response.data.flash);
                    this.errorMessage = null;
                })
                .catch((error) => {
                    this.errorMessage = "Could not delete the answer";
                });
        },
        saveEdit() {
            axios.patch(`/answers/${this.answer.id}`, {
                body: this.editText,
            })
                .then((response) => {
                    this.body = this.editText;
                    this.answer.body = this.editText;
                    this.editing = false;
                    this.flashMessage = { message: response.data.flash, type: "success" }
                    this.errorMessage = null;
                })
                .catch((error) => {
                    this.flashMessage = { message: response.data.flash, type: "error" }
                    this.errorMessage = "Could not save the answer";
                });
        },
        cancelEdit
            () {
            this.editing = false;
        },
    },
    mounted() {
        // console.log(this.answer)
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
