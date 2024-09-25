<template>
    <div class="mt-4">
        <ul class="flex border-b overflow-scroll pb-2">
            <li v-for="tab in tabs" :key="tab" :class="{ 'border-blue-500 text-blue-500': activeTab === tab }"
                class="mr-4 cursor-pointer py-2 px-4 border-b-2 flex items-center" @click="setActiveTab(tab)">
                <span class="mr-2">{{ $t(tab) }}</span>
            </li>
        </ul>

        <div v-if="activeTab === 'threads'">
            <h2 class="text-2xl font-bold mt-8">{{ $t('threads') }}</h2>
            <div class="mx-auto grid grid-cols-3 gap-4">
                <thread-card v-for="( thread ) in threads" :key="thread.id" :thread="thread" />
                <h1 v-if="threads.length === 0">{{ $t('noThreads') }}</h1>
            </div>
        </div>

        <div v-if="activeTab === 'questions'">
            <h2 class="text-2xl font-bold mt-8">{{ $t('questions') }}</h2>
            <div class="mx-auto grid grid-cols-3 gap-4">
                <QuestionCard v-for="( question ) in questions" :key="question.id" :question="question" />
                <h1 v-if="questions.length === 0">{{ $t('noQuestions') }}</h1>
            </div>
        </div>

        <div v-if="activeTab === 'activities'">
            <h2 class="text-2xl font-bold mt-8">{{ $t('activities') }}</h2>
            <time-line>
                <div class="space-y-12" v-for="( activitiesOnDate, date ) in activities" :key="date">
                    <component v-for="( activity ) in activitiesOnDate" :key="activity.id" :date="date"
                        :is="getComponentName(activity.type)" v-bind="activityProps(activity)" :user="profileUser">
                    </component>
                </div>
                <h1 v-if="activities.length === 0">{{ $t('noActivities') }}</h1>
            </time-line>
        </div>

        <div v-if="activeTab === 'answers'">
            <h2 class="text-2xl font-bold mt-8"> {{ $t('answers') }}</h2>
            <div class="mx-auto grid grid-cols-3 gap-4">
                <AnswerCard v-for="( answer ) in answers" :key="answer.id" :answer="answer" />
                <h1 v-if="answers.length === 0">{{ $t('noAnswers') }}</h1>
            </div>
        </div>

        <div v-if="activeTab === 'replies'">
            <h2 class="text-2xl font-bold mt-8">{{ $t('replies') }}</h2>
            <div class="mx-auto grid grid-cols-3 gap-4">
                <ReplyCard v-for="( reply ) in replies" :key="reply.id" :reply="reply" />
                <h1 v-if="replies.length === 0">{{ $t('noReplies') }}</h1>
            </div>
        </div>

        <div v-if="activeTab === 'votes'">
            <h2 class="text-2xl font-bold mt-8">{{ $t('votes') }}</h2>
            <div class="mx-auto grid grid-cols-3 gap-4">
                <VoteCard v-for="( vote ) in votes" :key="vote.id" :vote="vote" />
                <h1 v-if="votes.length === 0">{{ $t('noVotes') }}</h1>
            </div>
        </div>

        <div v-if="activeTab === 'favorites'">
            <h2 class="text-2xl font-bold mt-8">{{ $t('favorites') }}</h2>
            <div class="mx-auto grid grid-cols-3 gap-4">
                <FavoriteCard v-for="( favorite ) in favorites" :key="favorite.id" :favorite="favorite" />
                <h1 v-if="favorites.length === 0">{{ $t('noFavorites') }}</h1>
            </div>
        </div>

        <div v-if="activeTab === 'achievements'">
            <AchievementsList :all-achievements="allAchievements" :unlocked-achievements="unlockedAchievements"
                :current-progress="currentProgress" />
        </div>
        <div v-if="activeTab === 'details'">
            <div class="mt-8">
                <h2 class="text-2xl font-bold">{{ $t('details') }}</h2>
                <div class="mt-4">
                    <div class="flex items-start ">
                        <div class="flex flex-col items-center">
                            <span class="text-2xl font-bold">{{ points }}</span>
                            <span class="text-sm">{{ $t('points') }}</span>
                        </div>
                        <div class="flex flex-col mx-4 items-center">
                            <span class="text-2xl font-bold">{{ threads.length }}</span>
                            <span class="text-sm">{{ $t('threads') }}</span>
                        </div>
                        <div class="flex flex-col mx-4 items-center">
                            <span class="text-2xl font-bold">{{ questions.length }}</span>
                            <span class="text-sm">{{ $t('questions') }}</span>
                        </div>
                        <div class="flex flex-col mx-4 items-center">
                            <span class="text-2xl font-bold">{{ answers.length }}</span>
                            <span class="text-sm">{{ $t('answers') }}</span>
                        </div>
                        <div class="flex flex-col mx-4 items-center">
                            <span class="text-2xl font-bold">{{ replies.length }}</span>
                            <span class="text-sm">{{ $t('replies') }}</span>
                        </div>
                        <div class="flex flex-col mx-4 items-center">
                            <span class="text-2xl font-bold">{{ votes.length }}</span>
                            <span class="text-sm">{{ $t('votes') }}</span>
                        </div>
                        <div class="flex flex-col mx-4 items-center">
                            <span class="text-2xl font-bold">{{ favorites.length }}</span>
                            <span class="text-sm">{{ $t('favorites') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <p><strong>{{ $t('name') }}:</strong> {{ profileUser.name }}</p>
                <p><strong>{{ $t('email') }}:</strong> {{ profileUser.email }}</p>
                <p><strong>{{ $t('university') }}:</strong> {{ profileUser.university.name }}</p>
                <p><strong>{{ $t('field') }}:</strong> {{ profileUser.field.name }}</p>
                <p><strong>{{ $t('joinedOn') }}:</strong> {{ formattedDate(profileUser.created_at) }}</p>

                <div class="flex mt-4">
                    <button @click="updateDialog = true" class="px-4 mx-2 py-2 bg-blue-600 text-white rounded-md">{{
                        $t('editAccount') }}</button>
                    <button @click="deleteDialog = true" class="px-4 mx-2 py-2 bg-red-600 text-white rounded-md">{{
                        $t('deleteAccount') }}</button>
                </div>
            </div>
        </div>
        <v-dialog v-model="updateDialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('editAccount') }}</span>
                </v-card-title>
                <v-card-text>
                    <form @submit.prevent="updateProfile">
                        <v-text-field :label="$t('name')" v-model="form.name"></v-text-field>
                        <v-text-field :label="$t('email')" v-model="form.email"></v-text-field>

                        <div class="col-md-6">
                            <label for="field_id">{{ $t('field') }}</label>
                            <select v-model="form.field_id" class="w-full px-4 py-2 bg-gray-100 border rounded-md"
                                required>
                                <option v-for="field in fields" :key="field.id" :value="field.id">{{ field.name }}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="university_id">{{ $t('university') }}</label>
                            <select v-model="form.university_id" class="w-full px-4 py-2 bg-gray-100 border rounded-md"
                                required>
                                <option v-for="university in universities" :key="university.id" :value="university.id">
                                    {{ university.name }}</option>
                            </select>
                        </div>
                    </form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="updateDialog = false">{{ $t('cancel') }}</v-btn>
                    <v-btn text @click="updateProfile">{{ $t('save') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Delete Account Dialog -->
        <v-dialog v-model="deleteDialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('deleteAccount') }}</span>
                </v-card-title>
                <v-card-text>
                    <form @submit.prevent="confirmDelete">
                        <v-text-field :label="$t('password')" v-model="form.password" type="password"></v-text-field>
                        <v-alert v-if="showAlert && errors.password" type="error">{{ errors.password }}</v-alert>
                    </form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="deleteDialog = false">Close</v-btn>
                    <v-btn text @click="confirmDelete">Confirm</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
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
import AchievementsList from '../../components/AchievementsList.vue';
import QuestionCard from '../../components/QuestionCard.vue';
import AnswerCard from '../../components/AnswerCard.vue';
import ReplyCard from '../../components/ReplyCard.vue';
import FavoriteCard from '../../components/FavoriteCard.vue';
import VoteCard from '../../components/VoteCard.vue';
export default {
    props: ['profileUser', 'threads', 'questions', 'activities', 'answers', 'replies', 'votes', 'favorites', 'user', 'points', 'allAchievements', 'unlockedAchievements', 'currentProgress', 'fields', 'universities'],
    components: {
        CreatedFavorite,
        CreatedVote,
        CreatedThread,
        CreatedQuestion,
        CreatedReply,
        CreatedAnswer,
        ActivityIcon,
        AchievementsList,
        QuestionCard,
        AnswerCard,
        ReplyCard,
        FavoriteCard,
        VoteCard,

    },
    data() {
        return {
            activeTab: 'details',
            tabs: ['threads', 'questions', 'activities', 'answers', 'replies', 'votes', 'favorites', 'achievements', 'details'],
            updateDialog: false,
            deleteDialog: false,
            form: {
                name: this.profileUser.name,
                email: this.profileUser.email,
                university_id: this.profileUser.university.id,
                field_id: this.profileUser.field.id,
                password: '',
            },
            errors: {},
            showAlert: false,
        };
    },
    methods: {
        setActiveTab(tab) {
            this.activeTab = tab;
        },
        capitalize(word) {
            return word.charAt(0).toUpperCase() + word.slice(1);
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
        activityProps(activity) {
            return {
                activity: activity,
            };
        },
        updateProfile() {
            axios.patch(`/profile/${this.profileUser.id}`, { ...this.form, user_id: this.profileUser.id })
                .then(response => {
                    this.updateDialog = false;
                    if (this.profileUser.name !== response.data.name) {
                        this.$inertia.visit(`/profiles/${response.data.name}`);
                    }
                }).catch(error => {
                    // Handle error
                });
        },
        confirmDelete() {
            axios.delete(`/profile/${this.profileUser.id}`, { data: { password: this.form.password } })
                .then(() => {
                    this.deleteDialog = false;
                    // this.$inertia.visit('/all');
                }).catch(error => {
                    // Handle error
                    this.errors = error.response.data.errors;
                });
        },
        formattedDate(date) {
            return new Date(date).toLocaleDateString();
        }
    },
    mounted() {
        console.log(this.universities);
        console.log(this.fields);
        this.canUpdate = (this.$page.props.user.id === this.profileUser.id);
    }
};
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
