<template>
    <section class="relative min-h-screen bg-cover bg-center"
        style="background-image: url('https://images.unsplash.com/photo-1613310023042-ad79320c00ff?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80');">
        <!-- Overlay for better contrast with the text -->
        <div class="absolute inset-0 bg-black/30 "></div>

        <div class=" relative z-10 h-full px-6 py-12 grid place-items-center">
            <!-- Text and Button Section with Blur Effect -->
            <div class="w-full lg:w-1/2 backdrop-blur-lg bg-white/30 p-8 rounded-lg shadow-lg">
                <h1 class="mt-3 text-2xl font-semibold text-gray-800 dark:text-white md:text-3xl">{{ $t('404') }}</h1>
                <p class="mt-4 text-gray-100 dark:text-gray-400">{{ $t('sorry404') }}</p>

                <div class="flex items-center mt-6">
                    <Link :href="route('all.content')"
                        class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100 ">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                    </svg>
                    <span>{{ $t('home') }}</span>
                    </Link>
                </div>
            </div>

            <!-- Optional spacing if needed -->
            <div class="w-full mt-8 lg:w-1/2 lg:mt-0"></div>
        </div>
    </section>

</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { route } from 'ziggy-js';

export default {
    name: 'NotFoundPage',
    components: {
        Link
    },
    setup() {
        return {
            route,
        };
    },
};
</script>

<style scoped>
.btn {
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}

.btn-primary {
    background-color: #ef4444;
    /* Red */
}

.btn-secondary {
    background-color: #6366f1;
    /* Blue */
}
</style>
