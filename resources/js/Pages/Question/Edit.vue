<template>
    <div class="container mx-auto mt-6 space-y-4">
        <div>
            <h1 class="text-2xl font-bold">{{ $t('editQuestion') }}</h1>
        </div>

        <form v-if="user" @submit.prevent="submitForm" class="space-y-4">
            <div class="mt-6">
                {{ $t('title') }}
                <input type="text" v-model="form.title" :placeholder="$t('editQuestion')" required
                    class="w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="mt-6">
                <my-editor v-model="form.body" :editor="editor" :modelValue="form.body" />
            </div>
            <select v-model="form.channel_id" class="w-full" required>
                <option value="">{{ $t('chooseChannel') }}</option>
                <option v-for="channel in channels" :key="channel.id" :value="channel.id">
                    {{ channel.name }}
                </option>
            </select>
            <button type="submit" class="px-2 py-2 mt-4 text-white bg-blue-500 rounded hover:bg-blue-600">{{ $t('save')
                }}</button>
            <ul v-if="errors.length" class="mt-4">
                <li v-for="error in errors" :key="error" class="text-sm text-red-500">{{ $t('requiredField') }}</li>
            </ul>
        </form>
    </div>
</template>

<script>
export default {
    props: ['channels', 'user', 'question'],
    data() {
        return {
            form: this.$inertia.form({
                title: this.question.title,
                body: this.question.body,
                channel_id: this.question.channel_id,
            }),
            errors: []
        }
    },
    methods: {
        submitForm() {
            this.form.patch(`/questions/${this.question.channel.slug}/${this.question.id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset();
                },
                onError: (errors) => {
                    this.errors = errors.title || errors.body || errors.channel_id;
                },
            });
        }
    },

}
</script>
