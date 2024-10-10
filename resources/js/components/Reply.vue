<template v-cloak>
    <div :id="'reply-' + reply.id" name="fade"
        class="my-2 relative  border-b border-b-gray-200 py-4 rtl:text-right ltr:text-left ">
        <div class="flex items-center justify-between mt-4">
            <div v-if="editing" class="flex flex-col ">
                <textarea v-model="editText"></textarea>
                <div class="mt-2">
                    <Btn color="blue" @click="saveEdit">{{ $t('save') }}</Btn>
                    <Btn color="red" @click="cancelEdit">{{ $t('cancel') }}</Btn>
                </div>
            </div>
            <div v-else class="flex justify-between w-full">
                <p>{{ reply.body }}</p>

                <div class="flex items-stretch">
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <button v-bind="props"
                                class="hover:bg-gray-100 cursor-pointer rounded  p-1 outline outline-gray-200 outline-1 shadow-sm ">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" class="size-6 cursor-pointer hover:cursor-pointer">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                </svg>

                            </button>
                        </template>
                        <v-list>
                            <v-list-item class="hover:bg-gray-100 cursor-pointer  px-4 py-2">
                                <v-list-item-title @click="editReply"> {{ $t('edit') }}</v-list-item-title>
                            </v-list-item>
                            <v-list-item class="hover:bg-gray-100 cursor-pointer mt-2 px-4 py-2">
                                <v-list-item-title @click="deleteReply"> {{ $t('delete') }}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    <Favorite :item="reply" type="reply" :user="user" />
                </div>
            </div>
        </div>
        <!-- <Flash :flash="flashMessage"></Flash> -->
        <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
    </div>
</template>

<script>
import axios from "axios";
import Favorite from "./Favorite.vue";
import Flash from "./Flash.vue";
import Btn from "./Btn.vue";
import { useToast } from 'vue-toastification';

export default {
    components: { Favorite, Flash, Btn },
    props: ["reply", "user"],
    data() { return { editing: false, editText: this.reply.body, errorMessage: "", flashMessage: null }; },
    methods: {
        editReply() { this.editing = true; },
        deleteReply() {
            const toast = useToast();

            axios
                .delete(`/replies/${this.reply.id}`)
                .then((response) => {
                    this.$emit('replyDeleted', this.reply.id, response.data.thread, response.data.replies, response.data.flash);
                    let msg = this.$t(response.data.flash)
                    toast.success(msg);

                    this.errorMessage = null;
                })
                .catch((error) => {
                    this.errorMessage = "Could not delete the reply";
                });
        },
        saveEdit() {
            const toast = useToast();

            axios.patch(`/replies/${this.reply.id}`, {
                body: this.editText,
            })
                .then((response) => {
                    this.body = this.editText;
                    this.reply.body = this.editText;
                    this.editing = false;
                    // this.flashMessage = { message: response.data.flash, type: "success" }
                    let msg = this.$t(response.data.flash)
                    toast.success(msg);
                    this.errorMessage = null;
                })
                .catch((error) => {
                    this.flashMessage = { message: response.data.flash, type: "error" }
                    toast.error("Something went wrong. Please try again.");
                    this.errorMessage = "Could not save the reply";
                });
        },
        cancelEdit
            () {
            this.editing = false;
        },
    },
};
</script>
<style>
[v-cloak] {
    display: none;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
