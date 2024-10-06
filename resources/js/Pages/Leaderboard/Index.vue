<template>
    <div class="flex justify-center mb-6">
        <label for="timeRange" class="mr-4 rtl:ml-4 font-semibold">{{ $t('chooseRange') }}:</label>
        <select v-model="selectedRange" @change="fetchLeaderboardData"
            class="rounded-md bg-white border border-gray-300 shadow-sm w-48">
            <option value="7">{{ $t('days7') }}</option>
            <option value="14">{{ $t('days14') }}</option>
            <option value="30">{{ $t('days30') }}</option>
            <option value="60">{{ $t('days60') }}</option>
            <option value="180">{{ $t('days180') }}</option>
            <option value="365">{{ $t('year') }}</option>
            <option value="all">{{ $t('allTime') }}</option>
        </select>
    </div>

    <ul class="flex border-b overflow-scroll pb-2 my-4 ">
        <li v-for="tab in tabs" :key="tab" :class="{ 'border-blue-500 text-blue-500': activeTab === tab }"
            class="mr-4 cursor-pointer py-2 px-4 border-b-2 flex items-center" @click="setActiveTab(tab)">
            <span class="mr-2">{{ $t(tab) }}</span>
        </li>
    </ul>
    <div v-if="activeTab === 'users'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="user in topUsers" :key="user.id"
            class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow">
            <h2 class="text-2xl font-semibold mb-2">
                <a :href="user.path" class="text-blue-500 hover:underline capitalize">{{ user.name }}</a>
            </h2>
            <p class="text-gray-700">{{ user.points_sum_points ? user.points_sum_points : 0
                }} {{ $t('point') }}</p>
        </div>
    </div>
    <div v-if="activeTab === 'threads'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="thread in topThreads" :key="thread.id"
            class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow">
            <h2 class="text-2xl font-semibold mb-2">
                <a :href="'/threads/' + thread.id" class="text-blue-500 hover:underline capitalize">{{ thread.title
                    }}</a>
            </h2>
            <p class="text-gray-700">{{ thread.replies_count }} {{ $t('replies') }}</p>
        </div>
    </div>
    <div v-if="activeTab === 'questions'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="question in topQuestions" :key="question.id"
            class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow">
            <h2 class="text-2xl font-semibold mb-2">
                <a :href="'/questions/' + question.id" class="text-blue-500 hover:underline capitalize">{{
                    question.title
                    }}</a>
            </h2>
            <p class="text-gray-700">{{ question.answers_count }} {{ $t('answers') }}</p>
        </div>
    </div>
    <div v-if="activeTab === 'channels'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="channel in topChannels" :key="channel.id"
            class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow">
            <h2 class="text-2xl font-semibold mb-2">
                {{ channel.name }}
            </h2>
            <p class="text-gray-700">{{ channel.contributions }} {{ $t('contributions') }}</p>
        </div>
    </div>
    <div v-if="!topUsers.length" class="text-center text-gray-600">لا توجد بيانات في الوقت الحالي.</div>
</template>

<script>
export default {
    props: {
        topUsers: {
            type: Array,
            default: () => []
        },
        topThreads: {
            type: Array,
            default: () => []
        },
        topQuestions: {
            type: Array,
            default: () => []
        },
        topChannels: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            tabs: ['users', 'threads', 'questions', 'channels'],
            activeTab: 'users',
            selectedRange: '365', // Default range (7 days)
        };
    },
    methods: {
        setActiveTab(tab) {
            this.activeTab = tab;
        },

        fetchLeaderboardData() {
            // Use this.$inertia.visit instead of axios
            this.$inertia.visit('/leaderboard', {
                method: 'get',
                data: {
                    range: this.selectedRange
                },
                preserveState: true,
                preserveScroll: true,
            });
        }
    },
    mounted() {
        console.log(this.topChannels);
        // Fetch initial data on page load
        this.fetchLeaderboardData();
    }
};
</script>
