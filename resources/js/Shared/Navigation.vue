<template>
    <div class="flex py-4 px-8 bg-white shadow-md justify-around">
        <!-- Logo -->
        <div class="flex items-center flex-shrink-0">
            <Link href="#">
            <Logo class="block w-12 text-gray-800 fill-current h-12" />
            </Link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex sm:items-center">
            <Link
                class="px-4 py-2 leading-4 border border-1 rounded cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-transparent  text-sm font-medium text-gray-900 hover:text-gray-700 hover:bg-gray-100"
                :href="route('threads.create')">
            New Thread
            </Link>
            <Dropdown title="Filter">
                <DropdownLink :href="route('threads')" title="All Threads" />
                <DropdownLink :href="route('threads', { 'popular': '1' })" title="By Popularity" />
                <DropdownLink v-if="user" :href="userRoute" title="My Threads" />
            </Dropdown>
            <Dropdown title="Channels">
                <DropdownLink v-for="channel in channels" :key="channel.id" :href="'/threads/' + channel.slug"
                    :title="channel.name" />
            </Dropdown>
        </div>
        <div v-if="user" class="hidden sm:flex sm:items-center sm:ml-6">
            <Dropdown :title="user.name">
                <DropdownLink :href="route('profile.show', { user: user })" title="Profile" />
                <DropdownLink :href="route('logout')" method="post" title="Logout" />
            </Dropdown>
        </div>
        <div v-else class="flex justify-center space-x-4">
            <a :href="route('login')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Login
            </a>
            <a :href="route('register')"
                class="border border-blue-500 hover:border-blue-700 text-blue-500 hover:text-blue-700 font-bold py-2 px-4 rounded">
                Register
            </a>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import Dropdown from './Dropdown.vue'
import DropdownLink from './DropdownLink.vue'
import Icon from './Icon.vue'
import Logo from './Logo.vue'
import { route } from "ziggy-js";
import DropdownItemVue from './DropdownItem.vue'

export default {
    components: {
        Dropdown,
        DropdownLink,
        Icon,
        Logo,
        Link,
        DropdownItemVue
    },
    props: ['channels', 'user'],
    setup() {
        return {
            route,
        }
    },
    computed: {
        userRoute() {
            return route('threads', { 'by': this.user.name })
        }
    }
}
</script>
