<template v-cloak>
    <div :id="'reply-' + reply.id" name="fade" class="mt-4 ">
        <div class="flex items-center justify-between mt-4">
            <div v-if="editing" class="flex flex-col ">
                <textarea v-model="editText"></textarea>
                <div class="mt-2">
                    <Btn color="blue" @click="saveEdit">{{ $t('save') }}</Btn>
                    <Btn color="red" @click="cancelEdit">{{ $t('cancel') }}</Btn>
                </div>
            </div>
            <div v-else class="flex flex-col ">
                <p>{{ reply.body }}</p>
                <div class="mt-2" v-if="(user?.id === reply.user_id) || this.isAdmin">
                    <Btn color="blue" @click="editReply">{{ $t('edit') }}</Btn>
                    <Btn color="red" @click="deleteReply">{{ $t('delete') }}</Btn>
                </div>
            </div>
            <Favorite :item="reply" type="reply" :user="user" />
        </div>
        <Flash :flash="flashMessage"></Flash>
        <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
    </div>
</template>

<script>
import axios from "axios";
import Favorite from "./Favorite.vue";
import Flash from "./Flash.vue";
import Btn from "./Btn.vue";

export default {
    components: { Favorite, Flash, Btn },
    props: ["reply", "user"],
    data() { return { editing: false, editText: this.reply.body, errorMessage: "", flashMessage: null }; },
    methods: {
        editReply() { this.editing = true; },
        deleteReply() {
            axios
                .delete(`/replies/${this.reply.id}`)
                .then((response) => {
                    this.$emit('replyDeleted', this.reply.id, response.data.thread, response.data.replies, response.data.flash);
                    this.errorMessage = null;
                })
                .catch((error) => {
                    this.errorMessage = "Could not delete the reply";
                });
        },
        saveEdit() {
            axios.patch(`/replies/${this.reply.id}`, {
                body: this.editText,
            })
                .then((response) => {
                    this.body = this.editText;
                    this.reply.body = this.editText;
                    this.editing = false;
                    this.flashMessage = { message: response.data.flash, type: "success" }
                    this.errorMessage = null;
                })
                .catch((error) => {
                    this.flashMessage = { message: response.data.flash, type: "error" }
                    this.errorMessage = "Could not save the reply";
                });
        },
        cancelEdit
            () {
            this.editing = false;
        },
    },
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
