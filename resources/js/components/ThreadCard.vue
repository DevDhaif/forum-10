<template>
    <article
        class="relative h-full justify-between  flex flex-col group p-4 rounded-md bg-slate-50 dark:bg-slate-900 shadow-lg outline outline-1 outline-slate-200 dark:outline-slate-800"
        :class="index === 0 ? 'col-span-3 bg-gradient-to-b from-black/50 via-white/50 to-green-500/50 dark:from-black/50 dark:via-white/50 dark:to-green-900/50 shadow-lg' : index === 1 ? 'col-span-2 bg-gradient-to-bl from-indigo-500/30 via-white/10 to-blue-700/10 dark:from-indigo-900/10 dark:via-white/10 dark:to-blue-800/30  shadow-lg' : ''">
        <div class=" absolute right-0 -top-4 ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-8 fill-blue-50 text-blue-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
            </svg>

        </div>
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
        <div class="flex justify-between items-center my-4">
            <div class="flex w-fit">
                <div class="flex items-center text-sm font-medium text-sky-500 dark:text-sky-400">
                    <reply-icon class=" mx-2 text-sky-500 dark:text-sky-400"></reply-icon>
                    <span class="sr-only">View replies to</span><span>{{ thread.replies_count }}</span>
                </div>
                <div class="flex items-center text-sm font-medium text-rose-500 dark:text-rose-400">
                    <Heart class=" mx-2 text-rose-500 dark:text-rose-400"></Heart>
                    <span class="sr-only">View likes for</span><span>{{ thread.favorites_count }}</span>
                </div>
                <div class="flex  items-center text-sm font-medium text-slate-500 dark:text-slate-400">
                    <VisitIcon class=" mx-2 text-slate-500 dark:text-slate-400"></VisitIcon>
                    <span class="sr-only">View likes for</span><span>{{ thread.visits }}</span>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-200
            ">{{ formatRelativeTime(thread.created_at) }}</p>
        </div>
        <div class="flex justify-between">
            <Link class="flex items-center text-sm text-sky-500 font-medium" :href="thread.creator.path">
            <span class="sr-only">View profile of</span>
            <span>{{ thread.creator.name }}</span>
            </Link>

            <Link class="flex items-center text-sm text-sky-500 font-medium" :href="thread.path">
            <!-- <span class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl"></span> -->
            <span class="relative"> {{ $t('readMore') }}
                <span class="sr-only">,
                    {{ thread.title }}
                </span>
            </span>
            <svg class="relative mt-px overflow-visible ml-2.5 rtl:mr-2.5 rtl:-scale-x-100 text-sky-300 dark:text-sky-700"
                width="3" height="6" viewBox="0 0 3 6" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M0 0L3 3L0 6"></path>
            </svg>
            </Link>
        </div>

    </article>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
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
        mounted() {
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

    }
}
</script>
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
