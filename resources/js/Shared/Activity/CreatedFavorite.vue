<template>
    <Activity>
        <template #heading>
            <div class="flex items-center space-x-2 justify-between">
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl font-bold">{{ user.name }}</h1>
                    <p class="text-sm" v-if="activity.subject">
                        liked a {{ type }} on
                        <a :href="path" class="text-blue-500"
                            v-if="activity.subject.favorited_type === 'App\\Models\\Thread'">
                            {{ activity.subject.favorited.title }}
                        </a>
                        <a :href="path" class="text-blue-500"
                            v-else-if="activity.subject.favorited_type === 'App\\Models\\Reply'">
                            {{ activity.subject.favorited.body }} what the
                        </a>
                    </p>
                </div>
                <div class="text-sm flex space-x-2">
                    <Heart class="text-red-500" />
                    <span> {{ formattedDate }} </span>
                </div>
            </div>
        </template>
        <template #body>
            <p class="text-sm" v-if="activity.subject" v-html="activity.subject.favorited.body"></p>
            <p class="text-sm" v-else>
                The favorited item has been deleted
            </p>
        </template>
    </Activity>
</template>

<script>
import Activity from './Activity.vue';
import { getFavoritedType, formatDate, getPath } from '../../Utils/helpers.js'
import Heart from 'vue-material-design-icons/Heart.vue';
export default {
    components: {
        Activity,
        Heart
    },
    props: ['activity', 'user'],
    computed: {
        type() {
            return getFavoritedType(this.activity.subject.favorited_type);
        },
        formattedDate() {
            return formatDate(this.activity.created_at);
        },
        path() {
            return getPath(this.activity.subject.favorited, this.type);
        },

    }
};
</script>
