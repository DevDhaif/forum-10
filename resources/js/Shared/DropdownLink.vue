<template>
    <Link
        class="block bg-slate-50 dark:bg-slate-900 w-full px-4 py-2 text-left text-sm leading-5 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:!bg-slate-800 focus:outline-none focus:bg-slate-100 dark:focus:bg-slate-800 transition duration-150 ease-in-out"
        :href="href">
    {{ title }}
    </Link>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link,
    },
    props: ['title', 'href'],
}
</script>
