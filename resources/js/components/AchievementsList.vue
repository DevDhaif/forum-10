<template>
    <div class="mb-4 w-full mx-auto">

        <ul class="flex border-b overflow-scroll pb-2">
            <li v-for="type in achievementTypes" :key="type"
                :class="{ 'border-blue-500 text-blue-500': activeTab === type }"
                class="mr-4 cursor-pointer py-2 px-4 border-b-2 flex items-center" @click="setActiveTab(type)">
                <span class="mr-2">{{ translateType(type) }}</span>
                <span v-html="getIcon(type)"></span>
            </li>
        </ul>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 my-4 max-h-96 overflow-y-scroll">
            <Achievement v-for="achievement in filteredAchievements" :key="achievement.id" :achievement="achievement"
                :is-unlocked="isUnlocked(achievement)" :current-progress="currentProgressFor(achievement)" />
        </div>
    </div>
</template>

<script>
import Achievement from './Achievement.vue';
import { getIconForType } from '../Utils/iconMap';

export default {
    components: {
        Achievement
    },
    props: {
        allAchievements: {
            type: Array,
            required: true
        },
        unlockedAchievements: {
            type: Array,
            required: true
        },
        currentProgress: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            activeTab: 'All',
            achievementTypes: []
        };
    },
    mounted() {
        this.achievementTypes = ['All', 'Unlocked', 'Locked', ...new Set(this.allAchievements.map(a => a.type))];

        this.setActiveTab('All');
    },
    computed: {
        filteredAchievements() {
            if (this.activeTab === 'All') {
                return this.allAchievements;
            }

            if (this.activeTab === 'Unlocked') {
                return this.allAchievements.filter(achievement => this.isUnlocked(achievement));
            }

            if (this.activeTab === 'Locked') {
                return this.allAchievements.filter(achievement => !this.isUnlocked(achievement));
            }

            return this.allAchievements.filter(achievement => achievement.type === this.activeTab);
        }
    },
    methods: {
        setActiveTab(type) {
            this.activeTab = type;
        },
        capitalize(word) {
            return word.charAt(0).toUpperCase() + word.slice(1);
        },
        getIcon(type) {
            return getIconForType(type, this.activeTab);
        },
        isUnlocked(achievement) {
            return this.unlockedAchievements.some(unlocked => unlocked.id === achievement.id);
        },
        currentProgressFor(achievement) {
            return this.currentProgress[achievement.type] || 0;
        },
        translateType(type) {
            return this.$t(type.toLowerCase());
        },
    }
};
</script>
