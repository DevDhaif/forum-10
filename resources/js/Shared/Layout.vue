<template>
    <main class="antialiased text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900" id="dropdown">
        <header>
            <navigation :user="user" :channels="channels"></navigation>
        </header>
        <section class="max-w-[52rem] mx-auto px-4 pb-28 sm:px-6 md:px-8 xl:px-12 lg:max-w-6xl">
            <slot />
        </section>
        <!-- <FlashMessages v-if="$page.props.flash.success || $page.props.flash.error">
        </FlashMessages> -->
    </main>
</template>

<script>
import Flash from '../components/Flash.vue';
import FlashMessages from '../Shared/FlashMessages.vue';
import Navigation from './Navigation.vue'
export default {

    props: ['user', 'channels'],
    components: {
        Navigation,
        Flash,
        FlashMessages
    },
}
</script>
