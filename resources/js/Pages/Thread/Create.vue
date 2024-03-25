<template>
    <div class="container mx-auto mt-6 space-y-4">
        <div>
            <h1 class="text-2xl font-bold">Create a Thread</h1>
        </div>
        <form v-if="user" @submit.prevent="submitForm" class="space-y-4">
            <div class="mt-6">
                title
                <input type="text" v-model="form.title" placeholder="Title" required
                    class="w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="mt-4">
                <my-editor v-model="form.body" :editor="editor" :modelValue="body" />
            </div>
            <select v-model="form.channel_id" required
                class="w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Choose One...</option>
                <option v-for="channel in channels" :key="channel.id" :value="channel.id">
                    {{ channel.name }}
                </option>
            </select>
            <button type="submit" class="px-2 py-2 mt-4 text-white bg-blue-500 rounded hover:bg-blue-600"> Post </button>
            <ul v-if="errors.length" class="mt-4">
                <li v-for="error in errors" :key="error" class="text-sm text-red-500">
                    {{ error }}
                </li>
            </ul>
        </form>
    </div>
</template>

<script>
import Layout from "../../Shared/Layout.vue";
import MyEditor from "../../components/Editor/MyEditor.vue";
import { route } from "ziggy-js"
export default {
    components: {
        MyEditor,
        Layout,
    },
    props: ["channels", "user"],
    data() {
        return {
            form: this.$inertia.form({
                title: "",
                body: "",
                channel_id: "",
            }),
            errors: [],
        };
    },

    methods: {
        submitForm() {

            this.form.post(route("threads.store"))
                .then(() => {
                    this.form.reset();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>
<style scoped>
.editor__content {
    border: 1px solid #ccc;
    padding: 10px;
    min-height: 300px;
}

.tiptap {
    border: 1px solid #ccc;
    margin-top: 0.75em;
    border-radius: 5px;
    overflow: hidden;
}

code {
    background-color: rgba(#616161, 0.1);
    color: #616161;
}

.content {
    padding: 1rem 0 0;
}

.contect h2 {
    margin: 1rem 0 0.5rem;
}

.contect pre {
    border-radius: 5px;
    color: #333;
}

.contect code {
    display: block;
    white-space: pre-wrap;
    font-size: 0.8rem;
    padding: 0.75rem 1rem;
    background-color: #e9ecef;
    color: #495057;
}
</style>
