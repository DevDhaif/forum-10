<template>
    <article
        class="relative h-full overflow-hidden justify-between  flex flex-col group p-4 rounded-md bg-slate-50 dark:bg-slate-900 shadow-lg outline outline-1 outline-slate-200 dark:outline-slate-800"
        :class="index === 0 ? 'col-span-3 bg-gradient-to-b from-black/50 via-white/50 to-green-500/50 dark:from-black/50 dark:via-white/50 dark:to-green-900/50 shadow-lg' : index === 1 ? 'col-span-2 bg-gradient-to-bl from-indigo-500/30 via-white/10 to-blue-700/10 dark:from-indigo-900/10 dark:via-white/10 dark:to-blue-800/30  shadow-lg' : ''">

        <div class="pointer-events-none blur-sm"
            :class="index === 0 ? ' absolute left-0 w-0 h-0 top-0 border-t-[170px] border-t-transparent border-l-[200px] border-l-red-500/30 border-b-[170px] border-b-transparent' : ''">
        </div>

        <div
            class="absolute inset-0 sm:rounded-2xl group-hover:bg-slate-50/10 dark:group-hover:bg-slate-800/20 pointer-events-none">
        </div>

        <div class="relative">
            <div class="flex justify-between items-center pt-8 lg:pt-0">
                <h3 class="text-base font-semibold tracking-tight text-slate-900 dark:text-slate-200 ">
                    {{ thread.title }}
                </h3>
                <Link :href="'/threads/' + thread.channel.slug"
                    class="text-sm font-medium text-sky-500 dark:text-sky-400 hover:underline">
                <badge :title="thread.channel.name || ''" :channelId="thread.channel.id" />
                </Link>
            </div>
            <div
                class="mt-2 mb-4 prose dark:prose-invert prose-slate prose-a:relative prose-a:z-10 dark:prose-dark line-clamp-2">
                <p v-html="truncatedBody"></p>
            </div>

        </div>
        <div class="flex justify-between space-x-4 items-center my-4">
            <div class="flex space-x-4 w-fit">
                <div class="flex  space-x-2 items-center text-sm font-medium text-sky-500 dark:text-sky-400">
                    <reply-icon class=" text-sky-500 dark:text-sky-400"></reply-icon>
                    <span class="sr-only">View replies to</span><span>{{ thread.replies_count }}</span>
                </div>
                <div class="flex  space-x-2 items-center text-sm font-medium text-rose-500 dark:text-rose-400">
                    <Heart class=" text-rose-500 dark:text-rose-400"></Heart>
                    <span class="sr-only">View likes for</span><span>{{ thread.favorites_count }}</span>
                </div>
                <div class="flex  space-x-2 items-center text-sm font-medium text-slate-500 dark:text-slate-400">
                    <VisitIcon class=" text-slate-500 dark:text-slate-400"></VisitIcon>
                    <span class="sr-only">View likes for</span><span>{{ thread.visits }}</span>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-200
            ">{{ formatDate(thread.created_at) }}</p>
        </div>
        <div class="flex justify-between">
            <Link class="flex items-center text-sm text-sky-500 font-medium" :href="thread.creator.path">
            <span class="sr-only">View profile of</span>
            <span>{{ thread.creator.name }}</span>
            </Link>

            <Link class="flex items-center text-sm text-sky-500 font-medium" :href="thread.path">
            <!-- <span class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl"></span> -->
            <span class="relative">Read more<span class="sr-only">,
                    {{ thread.title }}
                </span>
            </span>
            <svg class="relative mt-px overflow-visible ml-2.5 text-sky-300 dark:text-sky-700" width="3" height="6"
                viewBox="0 0 3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M0 0L3 3L0 6"></path>
            </svg>
            </Link>
        </div>

    </article>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
import moment from 'moment'
import { highlightCode } from '../Utils/highlightCode.js'
import Badge from '../Shared/Badge.vue'
import ReplyIcon from 'vue-material-design-icons/MessageReply.vue';
import Heart from 'vue-material-design-icons/Heart.vue';
import VisitIcon from 'vue-material-design-icons/Eye.vue';

export default {
    components: {
        Link,
        Badge,
        ReplyIcon,
        Heart,
        VisitIcon
    },
    props: ['thread', 'channel', 'channels', 'index'],

    computed: {
        formatDate() {
            return date => moment(date).fromNow()
        },
        mounted() {
            console.log("Mounted")
            this.$nextTick(() => {
                const blocks = this.$el.querySelectorAll('pre code')
                blocks.forEach(block => {
                    this.$hljs.highlightBlock(block)
                })
            })
        },
        truncatedBody() {
            let body = this.thread.body
            if (body.length > 100) {
                body = body.substring(0, 100) + '...'
            }
            return highlightCode(body)
        },

    },
}
</script>
<!-- <style scoped>
.article::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 25%;
    background: red;
    transform: skewX(-30deg);
}

.left-triangle {
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 0;
    border-top: 20% solid transparent;
    border-left: 75px solid red;
    border-bottom: 20% solid transparent;

}
</style> -->
<style scoped>
.triangle {
    position: absolute;
    top: 0;
    left: 0;
    width: 50%;
    height: 100%;
    z-index: 100;
}
</style>
