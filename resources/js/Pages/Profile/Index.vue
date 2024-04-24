<template>
    <div>
        <h1 class="text-2xl font-bold">{{ profileUser.name }}</h1>
        {{ getRole(profileUser) }}
        <h1 class="text-2xl font-bold">{{ profileUser.email }}</h1>
        <div class="flex mt-4 space-x-2">
            <h1 class="px-4 py-1 font-semibold text-blue-800 bg-blue-100 border border-blue-500 rounded-xl">{{
            profileUser.university.name }}</h1>
            <h1 class="px-4 py-1 font-semibold text-green-800 bg-green-100 border border-green-500 rounded-xl">{{
            profileUser.field.name }}</h1>
        </div>

        <p class="mt-2">Since {{ formattedDate(profileUser.created_at) }}</p>
        <h2 class="text-2xl font-bold mt-8">Threads</h2>
        <div class="mx-auto grid grid-cols-3 gap-4">
            <!-- <div class="p-4 bg-white rounded shadow" >
            </div> -->
            <thread-card v-for="(thread, index) in threads" :key="thread.id" :thread="thread" :index="index" />
            <h1 v-if="threads.length === 0">no threads yet</h1>
        </div>
        <h2 class="text-2xl font-bold mt-8">Activities</h2>
        <time-line>

            <div class="space-y-12" v-for="(activitiesOnDate, date) in activities" :key="date">
                <component v-for="(activity) in activitiesOnDate" :key="activity.id" :date="date"
                    :is="getComponentName(activity.type)" v-bind="activityProps(activity)" :user="profileUser">
                </component>
            </div>
            <h1 v-if="activities.length === 0">no activities yet</h1>

        </time-line>

        <!-- <div class="py-8 mt-8">
            <h2 class="text-2xl font-bold">Activities</h2>
            <div class="space-y-4" v-for="(activitiesOnDate, date) in activities" :key="date">
                <h1 class="text-xl font-bold mt-4">{{ date }}</h1>
                <component v-for="(activity) in activitiesOnDate" :key="activity.id"
                    :is="getComponentName(activity.type)" v-bind="activityProps(activity)" :user="profileUser">
                </component>
            </div>
            <h1 v-if="activities.length === 0">no activities yet</h1>
        </div> -->
    </div>
</template>

<script>
import CreatedFavorite from '../../Shared/Activity/CreatedFavorite.vue';
import CreatedThread from '../../Shared/Activity/CreatedThread.vue';
import CreatedReply from '../../Shared/Activity/CreatedReply.vue';
import ActivityIcon from '../../Shared/Activity/ActivityIcon.vue';
import { formatDate } from '../../Utils/helpers.js';

export default {
    props: ['profileUser', 'threads', 'activities'],
    components: {
        CreatedFavorite,
        CreatedThread,
        CreatedReply,
        ActivityIcon
    },
    methods: {
        getComponentName(type) {
            switch (type) {
                case 'created_favorite':
                    return 'CreatedFavorite';
                case 'created_thread':
                    return 'CreatedThread';
                case 'created_reply':
                    return 'CreatedReply';
                default:
                    return null;
            }
        },
        formattedDate(date) {
            return formatDate(date);
        },
        activityProps(activity) {
            return {
                activity: activity,
            };
        },
        getRole(user) {
            if (user.roles.some(role => role.name === 'admin')) {
                return 'Admin';
            } else {
                return 'User';
            }
        }
    },
    created() {
        // console.log(this.threads);
    },
}
</script>
