<template>
    <!-- slide effecf from the right outside to the left  -->

    <Transition name="toast" enter-active-class="transition toast ease-out duration-200"
        enter-class="transform translate-x-full" enter-to-class="transform translate-x-0"
        leave-active-class="transition ease-in duration-200" leave-class="transform translate-x-0"
        leave-to-class="transform translate-x-full">
        <div class="before:h-full before:rounded before:w-1 before:bg-green-600 before:absolute before:top-0 before:right-0 p-4 bg-green-100 text-green-800 rounded-md shadow-lg fixed bottom-20 right-20"
            v-show="show">
            <div class="alert" v-if="body">
                {{ body }}
            </div>
        </div>

        <!-- <div class="p-4 bg-green-100 text-green-800 rounded-md shadow-md fixed bottom-20 right-20" v-show="show">
        <div class="alert" v-if="body">
            {{ body }}
        </div>
    </div> -->
    </Transition>
</template>

<script>
export default {
    props: {
        flash: String
    },
    data() {
        return {
            body: this.flash || '',
            show: !!this.flash,
            hideTimeout: null
        }
    },
    watch: {
        'flash': function (newMessage) {
            console.log("watching flash");
            if (newMessage) {
                this.showFlash(newMessage);
            }
        }
    },
    methods: {
        showFlash(flash) {
            console.log("showing flash");
            this.show = true;
            this.body = flash;
            this.hide();
        },
        hide() {
            console.log("hiding flash");
            clearTimeout(this.hideTimeout);
            this.hideTimeout = setTimeout(() => {
                this.show = false;
            }, 1500);
            immediate: true
        }
    },
    mounted() {
        console.log("mounted");
        this.hide();
    }
}
</script>
<style scoped>
.toast {
    opacity: 0;
    /* Initial opacity to hide the element */
    transform: translateX(100%);
    /* Start off-screen on the right */
    transition: all 0.3s ease-in-out;
    /* Transition for both enter and leave */
}

.toast-enter-active,
.toast-leave-active {
    transition: opacity 0.5s ease;
}
</style>
