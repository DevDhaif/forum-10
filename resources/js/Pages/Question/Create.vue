<template>
    <div class="container mx-auto mt-6 space-y-4">
        <div>
            <h1 class="text-2xl font-bold">Create a Question</h1>
        </div>
        <form v-if="user" @submit.prevent="submitForm" class="space-y-4">
            <div class="mt-6">
                title
                <input type="text" v-model="form.title" placeholder="Title" required
                    class="w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-800 dark:text-white">
            </div>
            <div class="mt-4">
                <my-editor v-model="form.body" :editor="editor" :modelValue="body" />
            </div>
            <select v-model="form.channel_id" required
                class="w-full border border-gray-300 dark:border-slate-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 ">
                <option value="">Choose One...</option>
                <option v-for="channel in channels" :key="channel.id" :value="channel.id">
                    {{ channel.name }}
                </option>
            </select>
            <button type="submit" class="px-2 py-2 mt-4 text-white bg-blue-500 rounded hover:bg-blue-600"> Ask </button>
            <ul v-if="errors.length" class="mt-4">
                <li v-for="error in errors" :key="error" class="text-sm text-red-500">
                    {{ error }}
                </li>
            </ul>
        </form>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import MyEditor from "../../components/Editor/MyEditor.vue";
import { route } from "ziggy-js"
export default {
    components: {
        MyEditor,
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
            Inertia.post(route("questions.store"), this.form.data())
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
