<template v-cloak>
    <div :id="'reply-' + reply.id" name="fade" class="mt-4 ">
        <div v-if="!replyDeleted" class="flex items-center justify-between mt-4">
            <div v-if="editing" class="flex flex-col ">
                <textarea v-model="editText"></textarea>
                <div class="mt-2">
                    <btn color="blue" @click="saveEdit">Save</btn>
                    <btn color="red" @click="cancelEdit">Cancel</btn>
                </div>
            </div>
            <div v-else class="flex space-x-4">
                <p>{{ reply.body }}</p>
                <div v-if="user?.id === reply.user_id">
                    <btn color="blue" @click="editReply">Edit</btn>
                    <btn color="red" @click="deleteReply">Delete</btn>
                </div>
            </div>
            <favorite :item="reply" type="reply" :user="user" />
        </div>
        <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
    </div>
</template>

<script>
import axios from "axios";
import Favorite from "./Favorite.vue";
export default {
    components: {
        Favorite,
    },
    props: ["reply", "user"],
    data() {
        return {
            editing: false,
            editText: this.reply.body,
            replyDeleted: false,
            errorMessage: ""
        };
    },
    methods: {
        editReply() {
            this.editing = true;
        },
        deleteReply() {
            axios
                .delete(`/replies/${this.reply.id}`)
                .then(() => {
                    this.$emit('replyDeleted', this.reply.id);
                    this.replyDeleted = true;
                    flash("Reply deleted");
                })
                .catch((error) => {
                    this.errorMessage = "Could not delete the reply";
                });
        },
        saveEdit() {
            axios.patch(`/replies/${this.reply.id}`, {
                body: this.editText,
            });
            this.body = this.editText;
            this.reply.body = this.editText;
            this.editing = false;
            flash("Reply updated");
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
