<template>
    <h1 class="text-2xl font-bold"> {{ this.user.name }}</h1>
    <h1 class="text-2xl font-bold"> {{ user.email }}</h1>
        <div class="flex mt-4 space-x-2">
            <h1 class="px-4 py-1 font-semibold text-blue-800 bg-blue-100 border border-blue-500 rounded-xl">{{ user.university.name }}</h1>
            <h1 class="px-4 py-1 font-semibold text-green-800 bg-green-100 border border-green-500 rounded-xl">{{ user.field.name }}</h1>
        </div>
<p class="mt-2">Since {{ diffForHumans }}</p>
        
</template>

<script>
import moment from 'moment';
export default {
    props: ['user'],
    computed: {
        diffForHumans() {
            return moment(this.user.created_at).fromNow();
        },
    }
}
</script>


