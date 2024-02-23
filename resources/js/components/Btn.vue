<template>
    <button :class="`bg-${color}-500 hover:bg-${color}-700 text-white font-semibold py-0.5 px-2 rounded mx-1`" @click="onClick">
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        color: {
            type: String,
            default: 'blue'
        },
        onClick: {
            type: Function,
            default: () => { }
        }
    }
};
</script>
