<template>
    <div class="w-1/4">
        <div
            class="bg-slate-50 dark:bg-slate-900 p-4 rounded shadow outline outline-1 outline-slate-200 dark:outline-slate-800">
            <p class="text-slate-600 dark:text-slate-200 text-sm">This thread was published {{ diffForHumans }} ago by
                <a :href="userPath()" class="text-sm text-blue-600 dark:text-blue-400">
                    {{ thread.creator.name }}
                </a>
                and currently has {{ thread.replies_count }} replies .
            </p>
        </div>
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
