<template>
    <main id="dropdown">
        <header>
            <navigation :user="user" :channels="channels"></navigation>
        </header>
        <article>
            <slot />
        </article>
    </main>
</template>

<script>
import Navigation from './Navigation.vue'
export default {
    props: ['user', 'channels'],
    components: {
        Navigation
    },
}
</script>
