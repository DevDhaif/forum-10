<template>
    <div class="w-1/4">
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600 text-sm">This thread was published {{ diffForHumans }} ago by
                <a :href="userPath()" class="text-blue-600 text-sm">
                    {{ thread.creator.name }}
                </a>
                and currently has {{ thread.replies_count }} replies .
            </p>
        </div>
    </div>
</template>

<script>
import moment from "moment";
export default {
    props: ["thread"],

    methods: {
        userPath() {
            return `/profiles/${this.thread.creator.name}`;
        }
    },
    computed: {
        diffForHumans() {
            return moment(this.thread.created_at).fromNow();
        },
    },
}
</script>
