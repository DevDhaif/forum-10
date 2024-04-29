<template>
    <div>
        <button v-if="canUpdate" @click="dialog = !dialog"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg">Edit</button>
        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">Edit Profile</span>
                </v-card-title>
                <v-card-text>
                    <form class="relative " @submit.prevent="updateProfile">
                        <v-text-field label="Name" v-model="form.name"></v-text-field>
                        <v-text-field label="Email" v-model="form.email"></v-text-field>

                        <div class="col-md-6">
                            <select v-model="form.field_id"
                                class="w-full text-base px-4 py-2 roundede-md border border-1 bg-slate-50 my-2 "
                                required>
                                <option class="hover:bg-green-600" v-for="field in fields" :key="field.id"
                                    :value="field.id">
                                    {{ field.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select v-model="form.university_id"
                                class="w-full text-base px-4 py-2 roundede-md border border-1 bg-slate-50 my-2 "
                                required>
                                <option class="hover:bg-green-600" v-for="university in universities"
                                    :key="university.id" :value="university.id">
                                    {{ university.name }}
                                </option>
                            </select>
                        </div>

                    </form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                    <v-btn color="blue darken-1" text @click="updateProfile">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
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
    </div>
</template>

<script>
import CreatedFavorite from '../../Shared/Activity/CreatedFavorite.vue';
import CreatedThread from '../../Shared/Activity/CreatedThread.vue';
import CreatedReply from '../../Shared/Activity/CreatedReply.vue';
import ActivityIcon from '../../Shared/Activity/ActivityIcon.vue';
import { formatDate } from '../../Utils/helpers.js';
import axios from 'axios';
import Dropdown from '../../Shared/Dropdown.vue';

export default {
    props: ['profileUser', 'threads', 'activities', 'universities', 'fields'],
    components: {
        CreatedFavorite,
        CreatedThread,
        CreatedReply,
        ActivityIcon,
        Dropdown
    },
    data() {
        return {
            editing: false,
            dialog: false,
            canUpdate: false,
            form: {
                name: this.profileUser.name,
                email: this.profileUser.email,
                university_id: this.profileUser.university.id,
                field_id: this.profileUser.field.id,
            },
        }
    },
    watch: {
        profileUser(newProfileUser) {
            this.canUpdate = this.$page.props.user.id === newProfileUser.id;
        }
    },
    methods: {
        updateProfile() {
            const oldName = this.profileUser.name;
            axios.patch('/profile', this.form)
                .then(response => {
                    console.log(this.profileUser)
                    this.profileUser.name = response.data.name;
                    this.profileUser.email = response.data.email;
                    this.profileUser.field = response.data.field;
                    this.profileUser.university = response.data.university;
                    console.log(this.profileUser)
                    this.dialog = false;
                    if (oldName !== response.data.name) {
                        this.$inertia.visit(`/profiles/${response.data.name}`);
                    }
                })
                .catch(error => {
                    // Handle error
                });
        },
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
        },
    },
    mounted() {
        this.canUpdate = this.$page.props.user.id === this.profileUser.id;
    }
}
</script>
<style>
option {
    background-color: #f8f9fa !important;
    color: #343a40 !important;
}

option:hover {
    background-color: #343a40 !important;
    color: #f8f9fa !important;
}
</style>
