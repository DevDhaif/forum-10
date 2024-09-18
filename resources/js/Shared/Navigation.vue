<template>
    <div class="flex py-4 px-8 bg-slate-50 dark:bg-slate-900 shadow-md justify-around">
        <!-- Logo -->
        <div class="flex items-center flex-shrink-0">
            <Link href="#">
            <Logo class="block w-12 text-slate-800 fill-current h-12" />
            </Link>
        </div>

        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex sm:items-center">
            <!-- New Dropdown -->
            <Dropdown title="New">
                <DropdownLink :href="route('threads.create')" title="New Thread" />
                <DropdownLink :href="route('questions.create')" title="New Question" />
            </Dropdown>
            <Dropdown title="Filter">
                <DropdownLink @click="handleFilterChange('all')" title="All Content" />
                <DropdownLink @click="handleFilterChange('popular')" title="By Popularity" />
                <DropdownLink v-if="user" @click="handleFilterChange('byMe')" title="By Me" />
            </Dropdown>
            <!-- All Dropdown -->
            <Dropdown :title="selectedContentType">
                <DropdownLink @click="() => { selectedContentType = 'all'; handleContentTypeChange(); }" title="All" />
                <DropdownLink @click="() => { selectedContentType = 'threads'; handleContentTypeChange(); }"
                    title="Threads" />
                <DropdownLink @click="() => { selectedContentType = 'questions'; handleContentTypeChange(); }"
                    title="Questions" />
            </Dropdown>

            <Dropdown :title="selectedChannel ? selectedChannel.name : 'All Channels'">
                <DropdownLink @click="() => { selectedChannel = null; handleContentTypeChange(); }"
                    title="All Channels" />
                <DropdownLink v-for="channel in channels" :key="channel.id"
                    @click="() => { selectedChannel = channel; handleContentTypeChange(); }" :title="channel.name" />
            </Dropdown>
        </div>

        <!-- User Section -->
        <div v-if="user" class="hidden sm:flex sm:items-center sm:ml-6">
            <Dropdown :title="user.name">
                <DropdownLink :href="route('profile.show', { user: user })" title="Profile" />
                <DropdownLink :href="route('logout')" method="post" title="Logout" />
            </Dropdown>
        </div>

        <!-- Login / Register Links -->
        <div v-else class="flex justify-center space-x-4">
            <a :href="route('login')"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</a>
            <a :href="route('register')"
                class="border border-blue-500 hover:border-blue-700 text-blue-500 hover:text-blue-700 font-bold py-2 px-4 rounded">Register</a>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Dropdown from './Dropdown.vue';
import DropdownLink from './DropdownLink.vue';
import Logo from './Logo.vue';
import { route } from 'ziggy-js';

export default {
    components: {
        Dropdown,
        DropdownLink,
        Logo,
        Link,
    },
    props: ['channels', 'user'],
    setup() {
        return {
            route,
        };
    },
    data() {
        return {
            selectedContentType: 'all',
            selectedChannel: null,
        };
    },
    methods: {
        getChannelRoute(channelSlug = '') {
            switch (this.selectedContentType) {
                case 'threads':
                    return channelSlug ? `/threads/${channelSlug}` : '/threads';
                case 'questions':
                    return channelSlug ? `/questions/${channelSlug}` : '/questions';
                default:
                    return channelSlug ? `/all/${channelSlug}` : '/all';
            }
        },

        handleFilterChange(filter) {
            const channelSlug = this.selectedChannel ? this.selectedChannel.slug : '';
            let baseRoute = this.getChannelRoute(channelSlug);

            switch (filter) {
                case 'popular':
                    baseRoute += '?popular=1';
                    break;
                case 'byMe':
                    baseRoute += `?by=${this.user.name}`;
                    break;
                default:
                    break;
            }

            this.$inertia.visit(baseRoute);
        },

        handleContentTypeChange() {
            const channelSlug = this.selectedChannel ? this.selectedChannel.slug : '';
            const newRoute = this.getChannelRoute(channelSlug);

            this.$inertia.visit(newRoute);
        },

        selectContentType(type) {
            this.selectedContentType = type;
            this.handleContentTypeChange();
        },

        selectChannel(channel) {
            this.selectedChannel = channel;
            this.handleContentTypeChange();
        },
    },

};
</script>
