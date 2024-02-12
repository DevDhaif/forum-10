<template v-cloak>
    <transtiion name="fade" @after-leave="afterLeave">
        <div v-if="!replyDeleted" class="reply">

            <div v-if="editing">
                <textarea v-model="editText"></textarea>
                <button @click="saveEdit">Save</button>
                <button @click="cancelEdit">Cancel</button>
            </div>
            <div v-else>
                <p>{{ reply.body }}</p>
                <button class="bg-blue-500 mx-2 mt-1 hover:bg-blue-700 text-white font-bold py-0.5 px-2 rounded" @click="editReply">
                    Edit
                </button>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-0.5 px-2 rounded" @click="deleteReply">
                    Delete
                </button>
            </div>
        </div>
    </transtiion>
</template>

<script>
import axios from "axios";
export default {
    props: ["reply"],
    data() {
        return {
            editing: false,
            editText: this.reply.body,
            replyDeleted: false
        };
    },
    methods: {
        editReply() {
            this.editing = true;
        },
        deleteReply() {
            axios.delete(`/replies/${this.reply.id}`)
                .then(() => {
                    // this.$emit('replyDeleted', this.reply.id);
                    this.replyDeleted = true;
                    flash("Reply deleted");
                })
                .catch(error => {
                    console.error(error);
                });
        },
        saveEdit() {
            // Here you can send the updated text to the server
            axios.patch(`/replies/${this.reply.id}`, {
                body: this.editText,
            });
            this.body = this.editText;
            this.reply.body = this.editText;
            this.editing = false;
            flash("Reply updated");
        },
        cancelEdit() {
            this.editing = false;
        },
        afterLeave() {
            this.$emit('delete', this.reply.id);
        }
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
}</style>
