<template>
    <div class="mt-4">
        <v-dialog v-model="updateDialog" persistent max-width="600px">
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
                    <v-btn color="blue darken-1" text @click="updateDialog = false">Close</v-btn>
                    <v-btn color="blue darken-1" text @click="updateProfile">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="deleteDialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">Delete Account</span>
                </v-card-title>
                <v-card-text>
                    <form class="relative " @submit.prevent="updateProfile">
                        <!-- <v-text-field label="Name" v-model="form.name"></v-text-field> -->
                        <!-- enter password to delete account -->
                        <v-text-field label="Password" v-model="form.password" type="password"></v-text-field>
                        <!-- show error  -->
                        <v-alert v-if="showAlert && errors.password" type="error">{{ errors.password }}</v-alert>
                    </form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="deleteDialog = false">Close</v-btn>
                    <v-btn color="blue darken-1" text @click="confirmDelete">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <div class="flex items-center space-x-4">

            <h1 class="text-2xl font-bold">{{ profileUser.name }}</h1>
            <badge :title="points" color="purple" />
            <badge :title="getRole(profileUser)" />
            <button v-if="canUpdate" @click="updateDialog = !updateDialog"
                class="px-4 py-1 bg-blue-500 text-white rounded-lg">Edit</button>
            <button v-if="canUpdate" class="px-4 py-1 bg-red-500 text-white rounded-lg"
                @click="deleteProfile">Delete</button>
        </div>
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
            <thread-card v-for="( thread, index ) in  threads " :key="thread.id" :thread="thread" :index="index" />
            <h1 v-if="threads.length === 0">no threads yet</h1>
        </div>
        <h2 class="text-2xl font-bold mt-8">Activities</h2>
        <time-line>

            <div class="space-y-12" v-for="( activitiesOnDate, date ) in  activities " :key="date">
                <component v-for="( activity ) in  activitiesOnDate " :key="activity.id" :date="date"
                    :is="getComponentName(activity.type)" v-bind="activityProps(activity)" :user="profileUser">
                </component>
            </div>
            <h1 v-if="activities.length === 0">no activities yet</h1>

        </time-line>
    </div>
</template>

<script>
import CreatedFavorite from '../../Shared/Activity/CreatedFavorite.vue';
import CreatedVote from '../../Shared/Activity/CreatedVote.vue';
import CreatedThread from '../../Shared/Activity/CreatedThread.vue';
import CreatedQuestion from '../../Shared/Activity/CreatedQuestion.vue';
import CreatedReply from '../../Shared/Activity/CreatedReply.vue';
import CreatedAnswer from '../../Shared/Activity/CreatedAnswer.vue';
import ActivityIcon from '../../Shared/Activity/ActivityIcon.vue';
import { formatDate } from '../../Utils/helpers.js';
import axios from 'axios';
import Dropdown from '../../Shared/Dropdown.vue';

export default {
    props: ['profileUser', 'threads', 'activities', 'universities', 'fields', 'user', 'points'],
    components: {
        CreatedFavorite,
        CreatedVote,
        CreatedThread,
        CreatedQuestion,
        CreatedReply,
        CreatedAnswer,
        ActivityIcon,
        Dropdown,
    },
    data() {
        return {
            editing: false,
            updateDialog: false,
            deleteDialog: false,
            canUpdate: false,
            form: {
                name: this.profileUser.name,
                email: this.profileUser.email,
                university_id: this.profileUser.university.id,
                field_id: this.profileUser.field.id,
                password: '',
            },
            errors: {},
            showAlert: false,
        }
    },
    watch: {
        profileUser(newProfileUser) {
            this.canUpdate = this.$page.props.user.id === newProfileUser.id;
        },
        errors: {
            handler() {
                if (this.errors.password) {
                    this.showAlert = true;
                    setTimeout(() => {
                        this.showAlert = false;
                    }, 3000);
                }
            },
            deep: true
        }
    },
    methods: {
        updateProfile() {
            const oldName = this.profileUser.name;
            axios.patch(`/profile/${this.profileUser.name}`, { ...this.form, user_id: this.profileUser.id })
                .then(response => {
                    this.profileUser.name = response.data.name;
                    this.profileUser.email = response.data.email;
                    this.profileUser.field = response.data.field;
                    this.profileUser.university = response.data.university;
                    this.updateDialog = false;
                    if (oldName !== response.data.name) {
                        this.$inertia.visit(`/profiles/${response.data.name}`);
                    }
                })
                .catch(error => {
                    // Handle error
                });
        },
        deleteProfile() {
            if (this.isAdmin) {
                axios.delete(`/profile/${this.profileUser.name}`)
                    .then(response => {
                        this.$inertia.visit(`/`);
                    })
                    .catch(error => {
                        // Handle error
                        this.errors = error.response.data.errors;
                    });
            } else {
                this.deleteDialog = true;
            }
        },
        confirmDelete() {
            axios.delete(`/profile/${this.profileUser.name}`, { data: { password: this.form.password } })
                .then(response => {
                    this.deleteDialog = false;
                    this.$inertia.visit(`/`);
                })
                .catch(error => {
                    // Handle error
                    this.errors = error.response.data.errors;
                });
        },
        getComponentName(type) {
            switch (type) {
                case 'created_favorite':
                    return 'CreatedFavorite';
                case 'created_vote':
                    return 'CreatedVote';
                case 'created_thread':
                    return 'CreatedThread';
                case 'created_question':
                    return 'CreatedQuestion';
                case 'created_reply':
                    return 'CreatedReply';
                case 'created_answer':
                    return 'CreatedAnswer';
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
        console.log(this.activities);
        this.canUpdate = (this.$page.props.user.id === this.profileUser.id) || this.isAdmin;
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
