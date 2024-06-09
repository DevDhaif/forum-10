<template>
    <svg v-if="show" aria-hidden="true" class="fill-green-600" width="36" height="36" viewBox="0 0 36 36">
        <path d="m6 14 8 8L30 6v8L14 30l-8-8v-8Z"></path>
    </svg>
</template>
<script>
export default {
    name: 'Checkmark',
    props: ['show'],
}
</script>
