<template>
        <div
            class="bg-slate-50 dark:bg-slate-900 p-4 rounded shadow outline outline-1 outline-slate-200 dark:outline-slate-800">
            <p class="text-slate-600 dark:text-slate-200 text-sm">This question was published {{ diffForHumans }} ago by
                <a :href="userPath()" class="text-sm text-blue-600 dark:text-blue-400">
                    {{ question.creator.name }}
                </a>
                and currently has {{ question.answers_count }} answers .
            </p>
        </div>
</template>

<script>
import moment from "moment";
export default {
    props: ["question"],

    methods: {
        userPath() {
            return `/profiles/${this.question.creator.name}`;
        }
    },
    computed: {
        diffForHumans() {
            return moment(this.question.created_at).fromNow();
        },
    },
}
</script>
