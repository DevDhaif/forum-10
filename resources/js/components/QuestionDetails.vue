<template>
    <div
        class="container flex items-start mx-auto  space-x-4 p-4  bg-slate-50 dark:bg-slate-900 rounded shadow outline outline-1 outline-slate-200 dark:outline-slate-800 text-slate-900 dark:text-slate-100">
        <Vote :item="question" type="question" :user="user"></Vote>
        <div class=" ">
            <div>
                <h2 class="text-2xl font-bold">{{ question.title }}</h2>
                <div class="flex flex-col lg:flex-row items-center justify-between mt-4">
                    <div class="flex items-center space-x-2">
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ $t('questionPublished') }} {{ formatRelativeTime(question.created_at) }} {{ $t('by') }}
                            <a :href="userPath()" class="text-sm text-blue-600 dark:text-blue-400">
                                {{ question.creator.name }}
                            </a>
                            {{ $t('in') }}
                            <a v-if="question.channel" :href="`/questions/${question.channel.slug}`"
                                class="text-sm text-blue-600 dark:text-blue-400">
                                {{ question.channel.name }}
                            </a>
                            {{ $t('hasAnswers', { count: question.answers_count }) }}
                        </p>
                    </div>
                    <div class="flex mt-4 lg:mt-0 ">
                        <Visits :item="question"></Visits>
                        <div v-if="canUpdate" class="flex items-center">
                            <form @submit.prevent="deleteQuestion">
                                <button :title="$t('deleteQuestion')" type="submit" class="bg-red-50  rounded p-1  hover:outline hover:outline-1 hover:outline-red-500 mx-2 ring-1 ring-red-400 dark:ring-red-700 dark:bg-red-500 bg-text-red-700 dark:text-red-50
                            group">
                                    <svg class="w-6 h-6 text-red-700 group-hover:text-red-500 dark:text-red-200 dark:group-hover:text-red-300 group-hover:scale-95"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 6l3-3m0 0l3 3m-3-3v14a2 2 0 002 2h10a2 2 0 002-2V6m-3 0h6m-9 0v0">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                            <Link :title="$t('updateQuestion')"
                                :href="route('questions.edit', { channel: question.channel.slug, question: question.id })"
                                class=" bg-blue-50 text-blue-700 dark:bg-blue-500 dark:text-blue-200  rounded p-1  hover:outline hover:outline-1 hover:outline-blue-500 dark:hover:outline-blue-200 ring-1 ring-blue-400 dark:ring-blue-700 group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6 group-hover:text-blue-500 dark:group-hover:text-blue-200 group-hover:scale-95">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>

                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4 border-gray-200" />
            <div class="p-2 relative">
                <div class="mt-6 tiptap prose prose-pre:pr-8 prose-pre:w-fit  w-full max-w-full "
                    v-html="highlighted" />
            </div>
            <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
        </div>
    </div>
</template>
<script>
import { Inertia } from "@inertiajs/inertia";
import Visits from "../Shared/Visits.vue";
import { route } from "ziggy-js";
import moment from "moment";
import { highlightCode } from "../Utils/highlightCode";
import { Link } from '@inertiajs/inertia-vue3'
import Vote from "./Vote.vue";

export default {
    props: ["question", "user"],
    components: {
        Visits,
        Link,
        Vote,
    },
    data() {
        return {
            errorMessage: "",
            form: this.$inertia.form({
                question_id: this.question.id,
            })
        };
    },
    setup() {
        return {
            route,
        };
    },
    methods: {
        userPath() {
            return `/profiles/${this.question.creator.name}`;
        },
        deleteQuestion() {
            return this.form.delete(route("questions.destroy", {
                channel: this.question.channel.slug,
                question: this.question.id,
            }), {
                preserveScroll: true,
                onSuccess: () => {
                    Inertia.visit(route("questions"));
                },
                onError: (errors) => {
                    this.errorMessage = errors.message;
                },
            });
        },
        decodeHtml(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        },
    },
    computed: {
        diffForHumans() {
            return moment(this.question.created_at).fromNow();
        },
        canUpdate() {
            return (this.user && this.question.creator.id === this.user.id) || this.isAdmin;
        },
        highlighted() {
            return highlightCode(this.question.body, this.decodeHtml);
        },
    },
};
</script>
<style scoped>
.tiptap table {
    border-collapse: collapse;
    margin: 0;
    overflow: hidden;
    table-layout: fixed;
    width: 100%;
}

.tiptap td,
.tiptap th {
    border: 2px solid #ced4da;
    box-sizing: border-box;
    min-width: 1em;
    padding: 3px 5px;
    position: relative;
    vertical-align: top;
}

.tiptap th {
    background-color: #f1f3f5;
    font-weight: bold;
    text-align: left;
}

.tiptap .selectedCell:after {
    background: rgba(200, 200, 255, 0.4);
    content: '';
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    pointer-events: none;
    position: absolute;
    z-index: 2;
}

.tiptap .column-resize-handle {
    background-color: #adf;
    bottom: -2px;
    position: absolute;
    right: -2px;
    pointer-events: none;
    top: 0;
    width: 4px;
}

.tiptap p {
    margin: 0;
}
</style>
