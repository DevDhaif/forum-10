<template>
    <div class="mx-auto">
        <h1 class="text-2xl font-bold">{{ profileUser.name }}</h1>
        <h1 class="text-2xl font-bold">{{ profileUser.email }}</h1>
        <div class="flex mt-4 space-x-2">
            <h1 class="px-4 py-1 font-semibold text-blue-800 bg-blue-100 border border-blue-500 rounded-xl">{{ profileUser.university.name }}</h1>
            <h1 class="px-4 py-1 font-semibold text-green-800 bg-green-100 border border-green-500 rounded-xl">{{ profileUser.field.name }}</h1>
        </div>
        <p class="mt-2">Since {{ profileUser.created_at }}</p>
        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <div class="p-4 bg-white rounded shadow" v-for="thread in threads" :key="thread.id">
                <!-- Thread content here -->
            </div>
            <h1 v-if="threads.length === 0">no threads yet</h1>
        </div>
        <div class="py-8 mt-8">
            <h2 class="text-2xl font-bold">Activities</h2>
            <div v-for="(activity, date) in activities" :key="date">
                <!-- Activity content here -->
            </div>
            <h1 v-if="activities.length === 0">no activities yet</h1>
        </div>
    </div>
</template>

<script>
export default {
    props: ['profileUser', 'threads', 'activities'],

    created() {
        // Fetch data from API and assign to profileUser, threads, and activities
        console.log(this.profileUser);
    }
}
</script>
