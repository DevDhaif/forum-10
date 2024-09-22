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
    props: ['profileUser', 'threads', 'questions', 'activities', 'answers', 'replies', 'votes', 'favorites', 'user', 'points', 'allAchievements', 'unlockedAchievements', 'currentProgress'],
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
            activeTab: 'threads',
            tabs: ['threads', 'questions', 'activities', 'answers', 'replies', 'votes', 'favorites', 'achievements'],
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
    },
    mounted() {
        console.log(this.questions);
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
