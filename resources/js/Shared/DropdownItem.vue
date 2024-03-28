<template>
    <v-list-item value="index">
        <v-list-item-title>
            <slot />
        </v-list-item-title>
    </v-list-item>
</template>

<script>
import DropdownLink from './DropdownLink.vue'
import { route } from "ziggy-js";

export default {
    components: {
        DropdownLink
    },
    setup() {
        return {
            route,
        }
    },
}
</script>

<style></style>
