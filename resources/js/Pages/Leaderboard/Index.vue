<template>
    <div class="leaderboard container mx-auto p-6 ">
        <h1 class="text-4xl font-bold mb-6 text-center">{{ $t('leaderboard') }}</h1>

        <!-- Time Range Dropdown -->
        <div class="flex justify-center mb-6 ">
            <label for="timeRange" class="mr-4 rtl:ml-4 font-semibold"> اختر الفترة: </label>
            <select v-model="selectedRange" @change="fetchLeaderboardData"
                class=" rounded-md bg-white border border-gray-300 shadow-sm w-48">
                <option value="7"> 7 ايام</option>
                <option value="14"> 14 يوم</option>
                <option value="30"> 30 يوم</option>
                <option value="60"> 60 يوم</option>
                <option value="180"> 180 يوم</option>
                <option value="365"> السنة</option>
                <option value="all"> الكل</option>
            </select>
        </div>

        <ul class="flex border-b overflow-scroll pb-2 my-4 ">
            <li v-for="tab in tabs" :key="tab" :class="{ 'border-blue-500 text-blue-500': activeTab === tab }"
                class="mr-4 cursor-pointer py-2 px-4 border-b-2 flex items-center" @click="setActiveTab(tab)">
                <span class="mr-2">{{ $t(tab) }}</span>
            </li>
        </ul>
        <div v-if="activeTab === 'users'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="user in leaderboardData.topUsers" :key="user.id"
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                <h2 class="text-2xl font-semibold mb-2">
                    <a :href="user.path" class="text-blue-500 hover:underline capitalize">{{ user.name }}</a>
                </h2>
                <p class="text-gray-700">{{ user.points }} نقطة</p>
            </div>
        </div>

        <div v-if="activeTab === 'threads'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="thread in leaderboardData.topThreads" :key="thread.id"
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                <h2 class="text-2xl font-semibold mb-2">
                    <a :href="thread.path" class="text-blue-500 hover:underline">{{ thread.title }}</a>
                </h2>
                <p class="text-gray-700">{{ thread.favorites }} مفضلة</p>
            </div>
        </div>

        <div v-if="activeTab === 'questions'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="question in leaderboardData.topQuestions" :key="question.id"
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                <h2 class="text-2xl font-semibold mb-2">
                    <a :href="question.path" class="text-blue-500 hover:underline">{{ question.title }}</a>
                </h2>
                <p class="text-gray-700">{{ question.upvotes }} تصويت</p>
            </div>
        </div>

        <div v-if="activeTab === 'channels'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="channel in leaderboardData.topChannels" :key="channel.id"
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                <h2 class="text-2xl font-semibold mb-2">
                    <a :href="channel.path" class="text-blue-500 hover:underline">{{ channel.name }}</a>
                </h2>
                <p class="text-gray-700">{{ channel.threads }} موضوع
                    {{ channel.questions }} سؤال </p>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedRange: '7',
            tabs: ['users', 'threads', 'questions', 'channels'],
            activeTab: 'users',
            leaderboardData: {}
        };
    },
    methods: {
        setActiveTab(tab) {
            this.activeTab = tab;
        },
        fetchLeaderboardData() {
            console.log("Fetching leaderboard data for range:", this.selectedRange);

            const fakeData = {
                topUsers: [
                    { id: 1, name: "Dhaifallah", points: 153, path: "/profiles/Dhaifallah" },
                    { id: 2, name: "ali", points: 90, path: "/profiles/ali" },
                    { id: 3, name: "thanna", points: 80, path: "/profiles/thanna" },
                    { id: 4, name: "thanna", points: 75, path: "/profiles/thanna" },
                    { id: 5, name: "fatima", points: 72, path: "/profiles/fatima" },
                    { id: 6, name: "khaled", points: 68, path: "/profiles/khaled" },
                    { id: 7, name: "maryam", points: 65, path: "/profiles/maryam" },
                    { id: 8, name: "ahmed", points: 60, path: "/profiles/ahmed" },
                    { id: 9, name: "noura", points: 55, path: "/profiles/noura" },
                    { id: 10, name: "abdullah", points: 50, path: "/profiles/abdullah" }
                ],
                topThreads: [
                    { id: 1, title: "كيفية استخدام علامات HTML", favorites: 73, path: "/threads/html/1", creator: "ضيف الله", creatorPath: "/profiles/Dhaifallah" },
                    { id: 2, title: "كيفية استخدام CSS", favorites: 65, path: "/threads/css/2", creator: "علي", creatorPath: "/profiles/ali" },
                    { id: 3, title: "هل الجافا سكريبت سهلة", favorites: 60, path: "/threads/js/3", creator: "ثنا", creatorPath: "/profiles/thanna" },
                    { id: 4, title: "كيفية استخدام Vue", favorites: 55, path: "/threads/vue/4", creator: "ضيف الله", creatorPath: "/profiles/Dhaifallah" },
                    { id: 5, title: "خريطة الطريق لتعلم React", favorites: 50, path: "/threads/react/5", creator: "علي", creatorPath: "/profiles/ali" },
                    { id: 6, title: "نصائح وحيل Laravel", favorites: 45, path: "/threads/laravel/6", creator: "ثنا", creatorPath: "/profiles/thanna" },
                    { id: 7, title: "أفضل الممارسات في UML", favorites: 40, path: "/threads/uml/7", creator: "ضيف الله", creatorPath: "/profiles/Dhaifallah" },
                    { id: 8, title: "كيفية استخدام TailwindCSS", favorites: 35, path: "/threads/tailwindcss/8", creator: "محمد", creatorPath: "/profiles/mohammed" },
                    { id: 9, title: "مقدمة في أنظمة التحكم في الإصدارات", favorites: 33, path: "/threads/version-control/9", creator: "فاطمة", creatorPath: "/profiles/fatima" },
                    { id: 10, title: "أفضل الأدوات لتطوير الويب", favorites: 30, path: "/threads/web-tools/10", creator: "خالد", creatorPath: "/profiles/khaled" }
                ],
                topQuestions: [
                    { id: 1, title: "ما هو React؟", upvotes: 25, path: "/questions/1" },
                    { id: 2, title: "كيفية التعامل مع قواعد البيانات في Laravel؟", upvotes: 23, path: "/questions/2" },
                    { id: 3, title: "ما الفرق بين CSS و SCSS؟", upvotes: 22, path: "/questions/3" },
                    { id: 4, title: "كيف أبدأ تعلم Vue.js؟", upvotes: 20, path: "/questions/4" },
                    { id: 5, title: "ما هي أفضل ممارسات الأمان في الويب؟", upvotes: 18, path: "/questions/5" },
                    { id: 6, title: "ما هي الفروقات بين Node.js و PHP؟", upvotes: 17, path: "/questions/6" },
                    { id: 7, title: "ما هي الفروقات بين React و Angular؟", upvotes: 15, path: "/questions/7" }
                ],
                topChannels: [
                    { id: 1, name: "قناة تعلم البرمجة", threads: 12, questions: 8, path: "/channels/programming" },
                    { id: 2, name: "قناة تطوير الويب", threads: 10, questions: 7, path: "/channels/web-development" },
                    { id: 3, name: "قناة تطوير البرمجيات", threads: 8, questions: 5, path: "/channels/software-development" },
                    { id: 4, name: "قناة الجافا سكريبت", threads: 9, questions: 6, path: "/channels/javascript" },
                    { id: 5, name: "قناة PHP", threads: 7, questions: 5, path: "/channels/php" },
                    { id: 6, name: "قناة التصميم", threads: 6, questions: 4, path: "/channels/design" },
                    { id: 7, name: "قناة DevOps", threads: 5, questions: 3, path: "/channels/devops" }
                ]
            };


            // Update leaderboardData with fake data
            this.leaderboardData = fakeData;
        }
    },
    mounted() {
        // Fetch data when component is mounted
        this.fetchLeaderboardData();
    }
};
</script>
