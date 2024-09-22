<template>
    <div class="inline-flex p-2 space-x-2 border rounded">
        <button @click="toggleFavorite" class="text-sm text-white">
            <svg :class="{
                ' fill-blue-500': !isFavorited,
                ' fill-red-500': isFavorited,
            }" class="size-5 transition-colors duration-500 ml-2 rtl:mr-2" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M10 18l-1.45-1.32C4.53 12.18 1 9.19 1 5.5 1 3.02 3.02 1 5.5 1c1.54 0 3.04.78 3.95 2.05C10.46 1.78 11.96 1 13.5 1 16.43 1 19 3.57 19 6.5c0 3.69-3.53 6.68-8.55 11.18L10 18z">
                </path>
            </svg>
        </button>
        <span class="text-sm">{{ item.favorites_count }}</span>
        <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>

    </div>
</template>
<script>
import axios from 'axios';

export default {
    props: {
        item: {
            type: Object,
            required: true,
        },
        type: {
            type: String,
            required: true,
        },
        user: {
            type: Object,
        },
    },

    data() {
        return {
            isFavorited: this.item.isFavorited || false,
            errorMessage: "",
        };
    },

    methods: {
        async toggleFavorite() {
            if (!this.user) {
                window.location.href = '/login';
                return;
            }
            try {
                const method = this.isFavorited ? 'delete' : 'post';
                const response = await axios[method](`/${this.type}/${this.item.id}/favorites`);
                this.isFavorited = response.data.isFavorited;
                this.item.favorites_count = response.data.favorites_count;
            } catch (error) {
                this.errorMessage = "could not toggle favorite";
            }
        }
    },
};
</script>
