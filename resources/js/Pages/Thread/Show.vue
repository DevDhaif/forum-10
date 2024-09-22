<template>
    <div class="container flex items-start justify-between mx-auto mt-6 space-x-8">
        <div class="w-3/4">
            <thread-details :thread="thread" :user="user"></thread-details>
            <div class="p-4 mt-4 bg-slate-50 dark:bg-slate-900 rounded shadow">
                <p class="mt-6 text-sm text-gray-600"> {{ $t('threadHasReplies', { count: thread.replies_count }) }}
                </p>
                <post-reply :user="user" :thread="thread" @replyPosted="addReply" @posted="posted"></post-reply>
                <replies :replies="replies" :thread="thread" :user="user" @flash="flash">
                </replies>
                <pagination :links="replies.links"></pagination>
            </div>
        </div>
        <div class="w-1/4 flex flex-col ">
            <thread-info :thread="thread" :user="thread.creator" />
            <Related :items="relatedThreads" type="threads" />
        </div>
    </div>
</template>

<script>
import Pagination from '../../Shared/Pagination.vue'
import Related from "../../components/Related.vue"
export default {
    components: {
        Pagination,
        Related,
    },
    props: ['thread', 'user', 'replies', 'relatedThreads'],
    data() {
        return {
            // replies: this.replies,
            flashMessage: "",
            errorMessage: "",
            body: "",
        }
    },
    methods: {
        flash(flash) {
            this.flashMessage = null
            this.$nextTick(() => {
                this.flashMessage = flash
            })
        },
        posted(thread, replies, flash) {
            Object.assign(this.thread, thread);
            Object.assign(this.replies, replies);
            window.history.pushState({}, '', `/threads/${this.thread.channel.slug}/${this.thread.id}?page=${this.replies.current_page}`);
            this.flashMessage = null
            this.$nextTick(() => {
                this.flashMessage = flash
            })
        },
        addReply() {
            if (this.body === "") {
                this.errorMessage = "Please enter a valid reply"
                return
            }
            this.errorMessage = null

            if (this.thread.channel) {
                axios.post(`/threads/${this.thread.channel.slug}/${this.thread.id}/replies`, {
                    body: this.body,
                })
                    .then((response) => {
                        Object.assign(this.thread, response.data.thread);
                        Object.assign(this.replies, response.data.replies);
                        window.history.pushState({}, '', `/threads/${this.thread.channel.slug}/${this.thread.id}?page=${this.replies.current_page}`);
                        this.flashMessage = null
                        this.$nextTick(() => {
                            this.flashMessage = response.data.flash
                        })
                        this.body = ""
                    })
                    .catch((error) => {
                        console.error(error)
                        this.errorMessage = "Something went wrong. Please try again"
                    })
            }
        },
    }
}
</script>
<style scoped lang="scss">
:deep(.bg-gray-200) {
    background-color: #edf2f7;
}

:deep(.rounded) {
    border-radius: 0.375rem;
}

:deep(.tiptap) {
    table {
        border-collapse: collapse;
        margin: 0;
        overflow: hidden;
        table-layout: fixed;
        width: 100%;

        td,
        th {
            border: 2px solid #ced4da;
            box-sizing: border-box;
            min-width: 1em;
            height: 2em;
            padding: 3px 5px;
            position: relative;
            vertical-align: top;

            >* {
                margin-bottom: 0;
            }
        }

        th {
            background-color: #f1f3f5;
            font-weight: bold;
            text-align: left;
        }

        .selectedCell:after {
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

        .column-resize-handle {
            background-color: #adf;
            bottom: -2px;
            position: absolute;
            right: -2px;
            pointer-events: none;
            top: 0;
            width: 4px;
        }

        p {
            margin: 0;
        }
    }
}

.tableWrapper {
    padding: 1rem 0;
    overflow-x: auto;
}

.resize-cursor {
    cursor: ew-resize;
    cursor: col-resize;
}
</style>
