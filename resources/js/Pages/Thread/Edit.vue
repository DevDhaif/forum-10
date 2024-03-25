<template>
    <div class="container mx-auto mt-6 space-y-4">
        <div>
            <h1 class="text-2xl font-bold">Edit a Thread</h1>
        </div>

        <form v-if="user" @submit.prevent="submitForm" class="space-y-4">
            <div class="mt-6">
                title
                <input type="text" v-model="title" placeholder="Title" required
                    class="w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <!-- <div class="mt-6">
                <textarea v-model="body" class="w-full" placeholder="Have something to say?" rows="5"
                    required></textarea>
            </div> -->
            <div class="mt-6">
                <my-editor v-model="body" :editor="editor" :modelValue="body" />
            </div>
            <select v-model="channel_id" class="w-full" required>
                <option value="">Choose One...</option>
                <option v-for="channel in channels" :key="channel.id" :value="channel.id">
                    {{ channel.name }}
                </option>
            </select>
            <button type="submit" class="px-2 py-2 mt-4 text-white bg-blue-500 rounded hover:bg-blue-600">Save</button>
            <ul v-if="errors.length" class="mt-4">
                <li v-for="error in errors" :key="error" class="text-sm text-red-500">{{ error }}</li>
            </ul>
        </form>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
export default {
    props: ['channels', 'user', 'thread'],
    data() {
        return {
            title: this.thread.title,
            body: this.thread.body,
            channel_id: this.thread.channel_id,
            errors: []
        }
    },
    methods: {
        submitForm() {
            Inertia.patch(`/threads/${this.thread.channel.slug}/${this.thread.id}`, {
                title: this.title,
                body: this.body,
                channel_id: this.channel_id
            }).then(() => {
                this.title = '';
                this.body = '';
                this.channel_id = '';
            }).catch((error) => {
                this.errors = error.response.data.errors;
            });
        }
    },

}
</script>
