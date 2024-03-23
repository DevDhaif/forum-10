<template>
    <div class="flex py-4 px-8 bg-white shadow-md">
        <!-- Logo -->
        <div class="flex items-center flex-shrink-0">
            <Link href="#">
            <Logo class="block w-12 text-gray-800 fill-current h-12" />
            </Link>
        </div>
        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex sm:items-center">
            <Link
                class="flex items-center p-2 text-sm space-x-4 cursor-pointer font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none"
                :href="route('threads.create')">
            New Thread
            </Link>
            <Dropdown :align="'bottom-right'" :width="'32'">
                <template #trigger>
                    <button
                        class="inline-flex items-center text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white rounded-md hover:text-gray-700 focus:outline-none">
                        Filter
                    </button>
                </template>
                <template #content>
                    <DropdownLink :href="route('threads')" title="All Threads"></DropdownLink>
                    <DropdownLink :href='route("threads", { "popular": "1" })' title="By Popularity"></DropdownLink>
                    <DropdownLink v-if="user" :href="route('threads', { 'by': user.name })" title="My Threads">
                    </DropdownLink>
                </template>
            </Dropdown>
            <Dropdown :align="'bottom-right'">
                <template #trigger>
                    <button
                        class="inline-flex items-center text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white rounded-md hover:text-gray-700 focus:outline-none">
                        Channels
                    </button>
                </template>
                <template #content>
                    <DropdownLink :title="channel.name" :href="'/threads/' + channel.slug" v-for="channel in channels"
                        :key="channel.id"></DropdownLink>
                </template>
            </Dropdown>
        </div>
    </div>
</template>

<script>
import { InertiaLink, Link } from '@inertiajs/inertia-vue3'
import Dropdown from './Dropdown.vue'
import DropdownLink from './DropdownLink.vue'
import Icon from './Icon.vue'
import Logo from './Logo.vue'
import { route } from "ziggy-js";

export default {
    components: {
        InertiaLink,
        Dropdown,
        DropdownLink,
        Icon,
        Logo,
        Link,
    },
    props: ['channels', 'user'],
    setup() {
        return {
            route,
        }
    },
}
</script>
