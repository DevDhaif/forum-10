<template>
<!--    <div class="container px-6 py-6 mx-auto text-white bg-gray-700">-->

<!--        <button class="bg-red-500" @click="show = ! show">-->
<!--            {{show}}-->
<!--            <slot>-->
<!--                <p>{{Message}}</p>-->
<!--            </slot> &lt;!&ndash; slot outlet &ndash;&gt;-->
<!--        </button>-->
<!--        <p class="bg-black text-white">userId : {{userId}}</p>-->

<!--    </div>-->
    <div class="p-4 bg-red-100 text-red-800 rounded-md shadow-md ">
        <p>{{message}} {{editing}}</p>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props:['message' , 'editing'],
        data() {
            return {
                show: false,
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
