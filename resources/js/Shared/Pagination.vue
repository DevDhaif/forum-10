<template>
    <div class="flex flex-col items-center">
    <div v-if="links.length > 1">
        <div class="flex flex-wrap -mb-1">
            <!-- Previous Button -->
            <Link v-if="previousLink"
                class="px-4 py-3 mb-1 mr-1 text-sm leading-4 border rounded focus:text-blue-500 hover:bg-white focus:border-blue-500"
                :href="previousLink.url"
                :class="!previousPage ? 'cursor-not-allowed opacity-50 pointer-events-none' : ''">
            {{ $t('previous') }}
            </Link>

            <!-- One Page Before the Current Page -->
            <Link v-if="previousPage && previousPage.url"
                class="px-4 py-3 mb-1 mr-1 text-sm leading-4 border rounded focus:text-blue-500 hover:bg-white focus:border-blue-500"
                :href="previousPage.url" v-html="previousPage.label" />

            <!-- Current Page -->
            <div v-if="currentPage"
                class="px-4 py-3 mb-1 mr-1 text-sm leading-4 text-white bg-blue-500 border-blue-500 border rounded"
                v-html="currentPage.label" />

            <!-- One Page After the Current Page -->
            <Link v-if="nextPage && nextPage.url"
                class="px-4 py-3 mb-1 mr-1 text-sm leading-4 border rounded focus:text-blue-500 hover:bg-white focus:border-blue-500"
                :href="nextPage.url" v-html="nextPage.label" />

            <!-- Next Button -->
            <Link v-if="nextLink"
                class="px-4 py-3 mb-1 mr-1 text-sm leading-4 border rounded focus:text-blue-500 hover:bg-white focus:border-blue-500"
                :href="nextLink.url" :class="!nextPage ? 'cursor-not-allowed opacity-50 pointer-events-none' : ''">
            {{ $t('next') }}
            </Link>
        </div>

        <!-- Display Current Page and Total Pages -->
        <div class="text-center mt-2 text-sm text-gray-600">
            {{ $t('page') }} {{ currentPageNumber }} {{ $t('of') }} {{ totalPages }}
        </div>
    </div>
</div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link,
    },
    props: {
        links: Array, // links is passed in from the parent
    },
    computed: {
        // Find the "Previous" link object
        previousLink() {
            return this.links.find((link) => link.label.includes('&laquo;'));
        },

        // Find the "Next" link object
        nextLink() {
            return this.links.find((link) => link.label.includes('&raquo;'));
        },

        // Find the current page object
        currentPage() {
            return this.links.find((link) => link.active);
        },

        // Find the previous page relative to the current page
        previousPage() {
            const currentPageIndex = this.links.findIndex((link) => link.active);
            return currentPageIndex > 1 ? this.links[currentPageIndex - 1] : null;
        },

        // Find the next page relative to the current page
        nextPage() {
            const currentPageIndex = this.links.findIndex((link) => link.active);
            return currentPageIndex < this.links.length - 2 ? this.links[currentPageIndex + 1] : null;
        },

        // Get the current page number
        currentPageNumber() {
            return this.currentPage ? this.currentPage.label : 1;
        },

        // Get the total number of pages excluding the Previous and Next buttons
        totalPages() {
            return this.links.length - 2;
        },
    },
};
</script>
