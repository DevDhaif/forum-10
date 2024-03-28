<template>
    <main class="relative" id="dropdown">
        <header>
            <navigation :user="user" :channels="channels"></navigation>
        </header>
        <article class="container mx-auto ">
            <slot />
        </article>
        <FlashMessages v-if="$page.props.flash.success || $page.props.flash.error">
        </FlashMessages>
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
