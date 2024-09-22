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
                    {{ question.title }}
                </h3>
                <Link :href="'questions/' + question.channel.slug"
                    class="text-sm font-medium text-sky-500 dark:text-sky-400 hover:underline">
                <badge :title="question.channel.name || ''" :channelId="question.channel.id" />
                </Link>
            </div>
            <div
                class="mt-2 mb-4 prose dark:prose-invert prose-slate prose-a:relative prose-a:z-10 dark:prose-dark line-clamp-2">
                <p v-html="truncatedBody"></p>
            </div>

        </div>
        <div class="flex justify-betweenw items-center my-4">
            <div class="flex w-fit">
                <div class="flex items-center text-sm font-medium text-sky-500 dark:text-sky-400">
                    <svg class="fill-blue-500 mx-2" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M5.486 0c-1.92 0-2.881 0-3.615.373A3.428 3.428 0 0 0 .373 1.871C-.001 2.605 0 3.566 0 5.486v9.6c0 1.92 0 2.88.373 3.613c.329.645.853 1.17 1.498 1.498c.734.374 1.695.375 3.615.375h11.657V24l.793-.396c2.201-1.101 3.3-1.652 4.105-2.473a6.852 6.852 0 0 0 1.584-2.56C24 17.483 24 16.251 24 13.79V5.486c0-1.92 0-2.881-.373-3.615A3.428 3.428 0 0 0 22.129.373C21.395-.001 20.434 0 18.514 0H5.486zm1.371 10.285h10.286a5.142 5.142 0 0 1-10.286.024v-.024z" />
                    </svg>
                    <span class="sr-only">View answers to</span><span>{{ question.answers_count }}</span>
                </div>
                <div class="flex items-center text-sm font-medium text-rose-500 dark:text-rose-400">
                    <svg v-if="question.votes_count >= 0" aria-hidden="true" class="w-6 h-6 mx-2 fill-green-400 "
                        viewBox="0 0 18 18">
                        <path d="M1 12h16L9 4l-8 8Z"></path>
                    </svg>
                    <svg v-else aria-hidden="true" class="w-6 h-6 fill-red-400 mx-2 " viewBox="0 0 18 18">
                        <path d="M1 6h16l-8 8-8-8Z"></path>
                    </svg>
                    <span class="sr-only">View likes for</span><span
                        :class="question.votes_count > 0 ? 'text-green-500' : 'text-red-500'">{{ question.votes_count
                        }}</span>
                </div>
                <div class="flex  items-center text-sm font-medium text-slate-500 dark:text-slate-400">
                    <VisitIcon class="mx-2 text-slate-500 dark:text-slate-400"></VisitIcon>
                    <span class="sr-only">View likes for</span><span>{{ question.visits }}</span>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-200
            ">{{ formatRelativeTime(question.created_at) }}</p>
        </div>
        <div class="flex justify-between">
            <Link class="flex items-center text-sm text-sky-500 font-medium" :href="question.creator.path">
            <span class="sr-only">View profile of</span>
            <span>{{ question.creator.name }}</span>
            </Link>

            <Link class="flex items-center text-sm text-sky-500 font-medium" :href="question.path">
            <!-- <span class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl"></span> -->
            <span class="relative">Read more<span class="sr-only">,
                    {{ question.title }}
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
    props: ['question', 'channel', 'channels', 'index'],

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
            let body = this.question.body
            if (body.length > 100) {
                body = body.substring(0, 100) + '...'
            }
            return highlightCode(body)
        },

    },
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
