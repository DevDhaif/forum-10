<template>
    <div
        class="bg-slate-50 dark:bg-slate-900 p-4 rounded shadow outline outline-1 outline-slate-200 dark:outline-slate-800">
        <p class="text-slate-600 dark:text-slate-200 text-sm">{{ $t('threadPublished') }} {{
            formatRelativeTime(thread.created_at) }} {{ $t('by') }}
            <a :href="userPath()" class="text-sm text-blue-600 dark:text-blue-400">
                {{ thread.creator.name }}
            </a>
            {{ $t('threadHasReplies', { count: thread.replies_count }) }}.
        </p>
    </div>
</template>

<script>
import moment from "moment";
export default {
    props: ["thread"],

    methods: {
        userPath() {
            return `/profiles/${this.thread.creator.name}`;
        }
    },
    computed: {
        diffForHumans() {
            return moment(this.thread.created_at).fromNow();
        },
    },
}
</script>
