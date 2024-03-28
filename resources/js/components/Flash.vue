<template>
    <Transition name="slide-fade">
        <div class="before:h-full before:rounded before:w-1 before:bg-green-600 before:absolute before:top-0 before:right-0 py-4 px-8 font-medium shadow-green-200 bg-green-200 text-green-900 rounded-md shadow-lg fixed bottom-20 right-20"
            v-if="show">
            <div class="alert" v-if="body">
                {{ body }}
            </div>
        </div>
    </Transition>
    <button @click="show = !show">Toggle </button>
</template>

<script>
export default {

    props: {
        flash: Object
    },
    data() {
        return {
            body: this.flash ? this.flash.message : null,
            show: !!this.flash,
            hideTimeout: null
        }
    },
    watch: {
        'flash': function (newMessage) {
            if (newMessage) {
                this.showFlash(newMessage.message);
            }
            else {
                this.show = false;
            }
        }
    },
    methods: {
        showFlash(message) {
            this.$nextTick(() => {
                this.show = true;
                this.body = message;
                this.hide();
            });
        },
        hide() {
            clearTimeout(this.hideTimeout);
            this.hideTimeout = setTimeout(() => {
                this.show = false;
            }, 1500);
        }
    },
    mounted() {
        this.hide();
    }
}
</script>
<style scoped>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);

}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
</style>
