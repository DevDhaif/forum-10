<template>
    <div class="flex py-4 px-8 bg-slate-50 dark:bg-slate-900 shadow-md justify-around">
        <!-- Logo -->
        <div class="flex items-center flex-shrink-0">
            <Link href="#">
            <Logo class="block w-12 text-slate-800 fill-current h-12" />
            </Link>
        </div>
        <Dropdown :title="$t('language')">
            <DropdownLink @click="switchLocale('en')" title="English" />
            <DropdownLink @click="switchLocale('ar')" title="العربية" />
        </Dropdown>
        <div class="hidden sm:-my-px sm:ml-10  sm:flex sm:items-center">
            <!-- New Dropdown -->
            <Dropdown class="mx-2" :title="$t('new')">
                <DropdownLink :href="route('threads.create')" :title="$t('newThread')" />
                <DropdownLink :href="route('questions.create')" :title="$t('newQuestion')" />
            </Dropdown>
            <Dropdown class="mx-2" :title="$t('filter')">
                <DropdownLink @click="handleFilterChange('all')" :title="$t('allContent')" />
                <DropdownLink @click="handleFilterChange('popular')" :title="$t('byPopularity')" />
                <DropdownLink v-if="user" @click="handleFilterChange('byMe')" :title="$t('byMe')" />
            </Dropdown>
            <!-- All Dropdown -->
            <Dropdown class="mx-2" :title="$t(selectedContentType)">
                <DropdownLink @click="() => { selectedContentType = 'all'; handleContentTypeChange(); }"
                    :title="$t('all')" />
                <DropdownLink @click="() => { selectedContentType = 'threads'; handleContentTypeChange(); }"
                    :title="$t('threads')" />
                <DropdownLink @click="() => { selectedContentType = 'questions'; handleContentTypeChange(); }"
                    :title="$t('questions')" />
            </Dropdown>

            <Dropdown class="mx-2" :title="selectedChannel ? selectedChannel.name : $t('allChannels')">
                <DropdownLink @click="() => { selectedChannel = null; handleContentTypeChange(); }"
                    :title="$t('allChannels')" />
                <DropdownLink v-for="channel in channels" :key="channel.id"
                    @click="() => { selectedChannel = channel; handleContentTypeChange(); }" :title="channel.name" />
            </Dropdown>
        </div>

        <!-- User Section -->
        <div v-if="user" class="hidden sm:flex sm:items-center sm:ml-6">
            <Dropdown :title="user.name">
                <DropdownLink :href="route('profile.show', { user: user })" :title="$t('profile')" />
                <DropdownLink :href="route('logout')" method="post" :title="$t('logout')" />
            </Dropdown>
        </div>

        <!-- Login / Register Links -->
        <div v-else class="flex justify-center space-x-4">
            <a :href="route('login')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{
                $t('login') }}</a>
            <a :href="route('register')"
                class="border border-blue-500 hover:border-blue-700 text-blue-500 hover:text-blue-700 font-bold py-2 px-4 rounded">{{
                    $t('register') }}</a>
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
        switchLocale(locale) {
            this.$i18n.locale = locale;
            localStorage.setItem('locale', locale);

            // Update the direction
            const htmlTag = document.documentElement;
            htmlTag.setAttribute('dir', locale === 'ar' ? 'rtl' : 'ltr');
        },
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
    mounted() {
        const savedLocale = localStorage.getItem('locale') || this.$i18n.locale;
        this.$i18n.locale = savedLocale;

        // Set the direction based on the saved or default locale
        const htmlTag = document.documentElement;
        htmlTag.setAttribute('dir', savedLocale === 'ar' ? 'rtl' : 'ltr');

    }

};
</script>
