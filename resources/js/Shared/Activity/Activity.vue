<template>
    <article
        class="relative group flex flex-col gap-2 w-full bg-slate-50 rounded-md shadow-md dark:bg-slate-900 ml-4 dark:text-slate-100 p-4">
        <div
            class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl group-hover:bg-slate-50/70 dark:group-hover:bg-slate-800/50">
        </div>
        <svg viewBox="0 0 9 9"
            class="hidden absolute right-full mr-10 top-2 text-slate-200 dark:text-slate-600 md:mr-12 w-[calc(0.5rem+1px)] h-[calc(0.5rem+1px)] overflow-visible sm:block">
            <circle cx="4.5" cy="4.5" r="4.5" stroke="currentColor" class="fill-white dark:fill-slate-900"
                stroke-width="2">
            </circle>
        </svg>
        <div class="relative">
            <h3 class="text-base font-semibold tracking-tight text-slate-900 dark:text-slate-200 pt-8 lg:pt-0">
                <slot class="flex" name="heading"></slot>
            </h3>
            <div class="mt-2 mb-4 prose prose-slate prose-a:relative prose-a:z-10 dark:prose-dark line-clamp-2">
                <slot name="body"></slot>
            </div>
            <dl class="absolute left-0 top-0 lg:left-auto lg:right-full lg:mr-[calc(6.5rem+1px)]">
                <dt class="sr-only">Date</dt>
                <dd class="whitespace-nowrap text-sm leading-6 dark:text-slate-400">
                    <time :datetime="date">{{ date }}</time>
                </dd>
            </dl>
        </div>


        <!-- <div class="flex flex-col gap-2 w-full bg-slate-50 rounded-md shadow-md dark:bg-slate-800 dark:text-slate-100
        ">
            <div class="p-2 flex gap-x-2 items-center">
                <slot name="heading"></slot>
            </div>
            <div class="border-b border-gray-300"></div>
            <div class="p-4 text-sm overflow-hidden line-clamp-2 leading-[1.25em]">
                <slot name="body"></slot>
            </div>
        </div> -->
    </article>
</template>
<script>
export default {
    name: 'Activity',
    props: ['date'],

    mounted() {
        // console.log(this.date)
    }
}
</script>
