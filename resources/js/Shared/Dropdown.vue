<template>
    <div class="relative" ref="dropdown">
        <div class="flex items-center p-2 text-sm space-x-4 cursor-pointer font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none"
            @click="toggle" @keydown.enter.prevent="toggle" tabindex="0">

            <slot name="trigger"></slot>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="mt-1 w-4 h-4">
                <path v-if="!open" stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                <path v-else stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
            </svg>

        </div>
        <transition enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-200" leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95">
            <div v-show="open"
                :class="['absolute bg-white z-50 mt-1 shadow-md', widthClass, 'rounded-md shadow-lg', alignmentClasses]"
                @click="open = false" @keydown.esc="open = false" @keydown="handleKeyDown" ref="dropdownMenu"
                tabindex="0">
                <div class="rounded-md max-h-64 overflow-y-scroll ring-1 ring-black ring-opacity-5">
                    <slot name="content"></slot>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    props: ['align', 'width', 'contentClasses'],
    data() {
        return {
            open: false,
            focusedOptionIndex: 0,

        };
    },
    methods: {
        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => {
                    const options = this.$refs.dropdownMenu.querySelectorAll('a');
                    options[this.focusedOptionIndex].focus();
                });
            }
        },

        handleKeyDown(event) {
            const options = this.$refs.dropdownMenu.querySelectorAll('a');
            if (event.key === 'ArrowDown') {
                this.focusNextOption();

            } else if (event.key === 'ArrowUp') {
                this.focusPreviousOption();
            }
            else if (event.key === 'Enter') {
                this.selectOption(this.focusedOptionIndex);
            }
        },
        focusNextOption() {
            const options = this.$refs.dropdownMenu.querySelectorAll('a');
            console.log(options)
            if (this.focusedOptionIndex < options.length - 1) {
                this.focusedOptionIndex++;
            } else {
                this.focusedOptionIndex = 0;
            }
            this.focusOption(this.focusedOptionIndex);

        },
        focusPreviousOption() {
            const options = this.$refs.dropdownMenu.querySelectorAll('a');
            if (this.focusedOptionIndex > 0) {
                this.focusedOptionIndex--;
            } else {
                this.focusedOptionIndex = options.length - 1;
            }
            this.focusOption(this.focusedOptionIndex);
        },
        focusOption(index) {
            const link = this.$refs.dropdownMenu.querySelectorAll('a')[index];
            link.focus();
        },
        selectOption(index) {
            const link = this.$refs.dropdownMenu.querySelectorAll('a')[index];
            link.click();
        },

        handleClickOutside(event) {
            if (!this.$el.contains(event.target) && this.open) {
                this.open = false;
            }
        },

    },
    computed: {
        alignmentClasses() {
            return {
                'origin-top-right': this.align === 'top-right',
                'origin-top-left': this.align === 'top-left',
                'origin-bottom-right': this.align === 'bottom-right',
                'origin-bottom-left': this.align === 'bottom-left',
                'right-0': this.align === 'top-right' || this.align === 'bottom-right',
                'left-0': this.align === 'top-left' || this.align === 'bottom-left'
            };
        },
        widthClass() {
            return this.width ? `w-${this.width}` : 'w-48';
        }
    },
    mounted() {
        document.addEventListener('click', this.hide);
        document.addEventListener('click', this.handleClickOutside);
    },
    beforeDestroy() {
        document.removeEventListener('click', this.hide);
        document.removeEventListener('click', this.handleClickOutside);
    }
};
</script>
