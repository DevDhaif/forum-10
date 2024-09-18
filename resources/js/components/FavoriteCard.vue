<template>
    <div class="p-4 bg-white rounded-lg shadow-md ">
        <h2 class="text-xl font-bold mb-2 truncate">Favorited a {{ favoritedType }} {{ title }}</h2>
        <p class="text-sm text-gray-500 mt-2 ">Favorited on: {{ formatDate(favorite.created_at) }}</p>
        <Link :href="path" class="text-blue-500 hover:text-blue-700">View {{ favoritedType }}</Link>
    </div>
</template>

<script>
import { formatDate, getPath } from '../Utils/helpers';
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
        Link,
    },
    props: {
        favorite: Object,
    },
    methods: {
        formatDate(date) {
            return formatDate(date);
        }
    },
    computed: {
        favoritedType() {
            switch (this.favorite.favorited_type) {
                case "App\\Models\\Reply":
                    return "reply";
                case "App\\Models\\Thread":
                    return "thread";
                default:
                    return "Unknown";
            }
        },
        path() {
            return getPath(this.favorite.favorited, this.favoritedType);
        },
        title() {
            switch (this.favorite.favorited_type) {
                case "App\\Models\\Reply":
                    return this.favorite.favorited.thread.title;
                case "App\\Models\\Thread":
                    return this.favorite.favorited.title;
                default:
                    return "Unknown";
            }
        }
    }
};
</script>
