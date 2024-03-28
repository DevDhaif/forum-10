<template>
    <div class="text-center">
        <v-btn variant="plain" :ripple="false" @keydown.enter.prevent="event => event.target.click()"
            @click="open = !open" v-click-outside="() => open = false"
            class=" flex items-center text-sm px- font-medium space-x-2 !capitalize leading-4 !text-gray-900
            !opacity-100 !bg-white border border-transparent  hover:!text-gray-700 focus:!outline-none !shadow-none">
            <span> {{ title }} </span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="mt-1 ml-4 w-4 h-4">
                <path v-if="!open" stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                <path v-else stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
            </svg>
            <v-menu activator="parent">
                <v-list class="max-h-64">
                    <slot />
                </v-list>
            </v-menu>
        </v-btn>
    </div>
</template>

<script>

export default {
    props: ['title'],
    data() {
        return {
            open: false
        }
    }
}
</script>
