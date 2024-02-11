<template v-cloak>
    <div>
        <div v-if="editing">
            <textarea v-model="editText"></textarea>
            <button @click="saveEdit">Save</button>
            <button @click="cancelEdit">Cancel</button>
        </div>
        <div v-else>
            <p>{{ reply.body }}</p>
            <button @click="editReply">Edit</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    props: ['reply'],
    data() {
        return {
            editing: false,
            editText: this.reply.body,
        }
    },
    methods: {
        editReply() {
            this.editing = true;
        },
        saveEdit() {
            // Here you can send the updated text to the server
            axios.patch(`/replies/${this.reply.id}`, {
                body: this.editText
            });
            this.body = this.editText;
            this.reply.body = this.editText;
            this.editing = false;
            flash('Reply updated');
        },
        cancelEdit() {
            this.editing = false;
        }
    }
}
</script>
<style>
[v-cloak] {
    display: none;
}
</style>
