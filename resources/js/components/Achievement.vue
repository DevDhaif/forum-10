<template>
    <div :class="[
        isUnlocked
            ? getAchievementStyle(achievement.level)
            : 'bg-gray-800 text-gray-400',
        'px-4 py-2 rounded-lg shadow-md text-center transition duration-300 transform hover:scale-95'
    ]">
        <!-- Achievement Name and Status Icon -->
        <div class="flex justify-between items-center ">
            <span class="text-sm font-semibold">{{ achievement.name }}</span>
            <div>
                <!-- Unlocked Icon -->
                <template v-if="isUnlocked">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>

                </template>
                <!-- Locked Icon -->
                <template v-else>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>

                </template>
            </div>
        </div>


        <!-- <div class="flex justify-between mb-1">
            <span class="text-xs font-semibold inline-block text-gray-400">
                {{ currentProgress }} / {{ achievement.target }} completed
            </span>
        </div> -->
        <!-- Progress Bar for Locked Achievements -->
        <!-- <div v-if="!isUnlocked" class="mt-2">
            <div class="relative pt-1">
                <div class="overflow-hidden text-xs flex rounded bg-gray-300">
                    <div class="shadow-none flex flex-col  text-center whitespace-nowrap text-white justify-center bg-blue-500"
                        :style="{ width: progressPercentage + '%' }">
                        <span class="text-xs  font-semibold inline-block text-gray-400">
                            {{ currentProgress }} / {{ achievement.target }} completed
                        </span>
                    </div>
                </div>

            </div>

        </div> -->
        <div v-if="!isUnlocked" class="mt-2">
            <div class="relative pt-1">
                <!-- Progress bar container -->
                <div class="overflow-hidden h-3.5 text-xs flex rounded bg-gray-600 relative">
                    <!-- Progress bar -->
                    <div class="bg-blue-600 h-full" :style="{ width: progressPercentage + '%' }"></div>
                    <!-- Centered text inside the progress bar -->
                    <span class="absolute inset-0 flex items-center justify-center text-xs font-bold text-white">
                        {{ currentProgress }} / {{ achievement.target }} completed
                    </span>
                </div>
            </div>
        </div>




        <!-- Achievement Description -->
        <div class="text-xs mt-1">{{ achievement.description }}</div>
    </div>
</template>

<script>
export default {
    props: {
        achievement: {
            type: Object,
            required: true
        },
        isUnlocked: {
            type: Boolean, // Now this is a boolean
            required: true
        },
        currentProgress: {
            type: Number,
            required: true
        }
    },
    computed: {
        progressPercentage() {
            return (this.currentProgress / this.achievement.target) * 100;
        }
    },
    methods: {
        getAchievementStyle(level) {
            switch (level) {
                case 'Beginner':
                    return 'bg-blue-100 text-blue-600';
                case 'Intermediate':
                    return 'bg-green-100 text-green-600';
                case 'Advanced':
                    return 'bg-purple-100 text-purple-600';
                case 'Expert':
                    return 'bg-red-100 text-red-600';
                case 'Master':
                    return 'bg-yellow-100 text-yellow-600';
                case 'Grandmaster':
                    return 'bg-indigo-100 text-indigo-600';
                default:
                    return 'bg-gray-200 text-gray-600';
            }
        }
    }
}
</script>
