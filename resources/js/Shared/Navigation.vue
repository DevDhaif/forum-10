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
            <Link class="flex items-center p-2 text-sm space-x-4 cursor-pointer font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none" href="/threads/create">
            New Thread
            </Link>
            <Dropdown :align="'bottom-right'" :width="'32'">
                <template #trigger>
                    <button
                        class="inline-flex items-center  text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white  rounded-md hover:text-gray-700 focus:outline-none">
                        Filter
                    </button>
                </template>
                <template #content>
                    <Link tabindex="0" href="/threads"
                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                    All Threads</Link>
                    <Link tabindex="0" href="/threads?popular=1"
                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                    By Popularity</Link>
                    <Link tabindex="0" v-if="user" :href="'/threads?by=' + user.name"
                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                    My Threads</Link>
                </template>
            </Dropdown>
            <Dropdown :align="'bottom-right'">
                <template #trigger>
                    <button
                        class="inline-flex items-center  text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white  rounded-md hover:text-gray-700 focus:outline-none">
                        Channels
                    </button>
                </template>
                <template #content>
                    <Link tabindex="0" v-for="channel in channels" :key="channel.id" :href="'/threads/' + channel.slug"
                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                        >
                    {{ channel.name }}
                    </Link>
                </template>
            </Dropdown>

        </div>
    </div>
</template>

<script>
import { InertiaLink, Link } from '@inertiajs/inertia-vue3'
import Dropdown from './Dropdown.vue'
import Icon from './Icon.vue'
import Logo from './Logo.vue'

export default {
    components: {
        InertiaLink,
        Dropdown,
        Icon,
        Logo,
        Link
    },
    props: ['channels', 'user'],
}
</script>
