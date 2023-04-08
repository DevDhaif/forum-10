<template>
    <div @click="show = !show">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                show: true
            }
        }
    }

</script>
