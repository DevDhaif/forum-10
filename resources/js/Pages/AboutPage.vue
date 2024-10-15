<template>
    <section id="about" class="relative ">
        <!-- Overlay for dark effect -->
        <div class="absolute w-full h-full  bg-black/70 "></div>

        <div
            class="relative container mx-auto backdrop-blur flex flex-col justify-center min-h-screen px-6 lg:flex-row lg:items-center lg:gap-12">
            <div class="lg:w-1/2">
                <h2 class="text-teal-400 text-xl font-semibold">{{ $t('welcome') }}</h2>
                <h1 class="text-white mt-3 text-4xl font-serif leading-normal font-bold">
                    {{ $t('description') }}
                </h1>
                <!-- Action buttons (explore content and ask a question) -->
                <div class="mt-6 flex items-center gap-4 ">
                    <a href="all" class="p-4 bg-teal-600 hover:bg-teal-700 text-teal-50 font-semibold rounded-md">{{
                        $t('explore_content') }}</a>
                    <a href="/questions/create" class="p-4  text-teal-50 outline outline-1 outline-teal-500 font-semibold rounded-md
                    ">{{ $t('ask_question') }}</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8 text-white">
                    <div
                        class="bg-gray-800/40 px-6 py-4 text-center relative rounded-lg shadow-lg border-[1px] border-teal-700 backdrop-blur-md hover:border-teal-500 transition duration-300">
                        <h3 class="text-4xl font-bold text-teal-400">{{ totalUsers }}</h3>
                        <account-icon
                            class="text-teal-400 absolute z-50  backdrop-blur-md  rounded-full flex items-center justify-center !border border-teal-500/60 -top-3 -left-3 "
                            size="28" />

                        <p class="mt-2 text-sm text-gray-300">{{ $t('totalUsers') }}</p>
                    </div>
                    <div
                        class="bg-gray-800/40 px-6 py-4 text-center relative rounded-lg shadow-lg border-[1px] border-teal-700 backdrop-blur-md hover:border-teal-500 transition duration-300">

                        <h3 class="text-4xl font-bold text-teal-400">{{ totalChannels }}</h3>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="size-8 text-teal-400 absolute z-50  backdrop-blur-md  rounded-full flex items-center justify-center !border border-teal-500/60 -top-3 -left-3 ">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>


                        <p class="mt-2 text-sm text-gray-300">{{ $t('totalChannels') }}</p>

                    </div>

                    <div
                        class="bg-gray-800/40 px-6 py-4 text-center relative rounded-lg shadow-lg border-[1px] border-teal-700 backdrop-blur-md hover:border-teal-500 transition duration-300">


                        <h3 class="text-4xl font-bold text-teal-400">{{ questionsLastMonth }}</h3>
                        <chat-question
                            class="text-teal-400 absolute z-50  backdrop-blur-md  rounded-full flex items-center justify-center !border border-teal-500/60 -top-3 -left-3 "
                            size="28" />

                        <p class="mt-2 text-sm text-gray-300">{{ $t('totalQuestionsLastMonth') }}</p>
                    </div>
                    <div
                        class="bg-gray-800/40 px-6 py-4 text-center relative rounded-lg shadow-lg border-[1px] border-teal-700 backdrop-blur-md hover:border-teal-500 transition duration-300">
                        <post-icon
                            class="text-teal-400 absolute z-50  backdrop-blur-md  rounded-full flex items-center justify-center !border border-teal-500/60 -top-3 -left-3 "
                            size="28" />

                        <h3 class="text-4xl font-bold text-teal-400">{{ threadsLastMonth }}</h3>


                        <p class="mt-2 text-sm text-gray-300">{{ $t('totalThreadsLastMonth') }}</p>
                    </div>
                    <div
                        class="bg-gray-800/40 px-6 py-4 text-center relative rounded-lg shadow-lg border-[1px] border-teal-700 backdrop-blur-md hover:border-teal-500 transition duration-300">
                        <head-question-icon
                            class="text-teal-400 absolute z-50  backdrop-blur-md  rounded-full flex items-center justify-center !border border-teal-500/60 -top-3 -left-3 "
                            size="28" />

                        <h3 class="text-4xl font-bold text-teal-400">{{ totalQuestions }}</h3>


                        <p class="mt-2 text-sm text-gray-300">{{ $t('totalQuestions') }}</p>
                    </div>
                    <div
                        class="bg-gray-800/40 px-6 py-4 text-center relative rounded-lg shadow-lg border-[1px] border-teal-700 backdrop-blur-md hover:border-teal-500 transition duration-300">
                        <comment-icon
                            class="text-teal-400 absolute z-50  backdrop-blur-md  rounded-full flex items-center justify-center !border border-teal-500/60 -top-3 -left-3 "
                            size="28" />

                        <h3 class="text-4xl font-bold text-teal-400">{{ totalAnswers }}</h3>


                        <p class="mt-2 text-sm text-gray-300">{{ $t('totalAnswers') }}</p>
                    </div>
                    <div
                        class="bg-gray-800/40 px-6 py-4 text-center relative rounded-lg shadow-lg border-[1px] border-teal-700 backdrop-blur-md hover:border-teal-500 transition duration-300">
                        <reply-icon
                            class="text-teal-400 absolute z-50  backdrop-blur-md  rounded-full flex items-center justify-center !border border-teal-500/60 -top-3 -left-3 "
                            size="28" />

                        <h3 class="text-4xl font-bold text-teal-400">{{ totalReplies }}</h3>


                        <p class="mt-2 text-sm text-gray-300">{{ $t('totalReplies') }}</p>
                    </div>

                    <div
                        class="bg-gray-800/40 px-6 py-4 text-center relative rounded-lg shadow-lg border-[1px] border-teal-700 backdrop-blur-md hover:border-teal-500 transition duration-300">

                        <h3 class="text-4xl font-bold text-teal-400">{{ totalAiAnswers }}</h3>
                        <robot-icon
                            class="text-teal-400 absolute z-50  backdrop-blur-md  rounded-full flex items-center justify-center !border border-teal-500/60 -top-3 -left-3  "
                            size="28" />

                        <p class="mt-2 text-sm text-gray-300">{{ $t('totalAIAnswers') }}</p>
                    </div>

                </div>


            </div>


        </div>
    </section>
</template>

<script>
import ReplyIcon from 'vue-material-design-icons/MessageReply.vue';
// import FaceProfile from 'vue-material-design-icons/FaceProfile.vue';
// import these icons from the vue-material-design-icons package : user , question , reply , channel , ai , thread , answer , i am not sure what are the icons are called or thier names
import MenuIcon from 'vue-material-design-icons/Menu.vue';
import AccountIcon from 'vue-material-design-icons/Account.vue';
import PostIcon from 'vue-material-design-icons/Post.vue';
import Account from 'vue-material-design-icons/Account.vue';
import ChatQuestion from 'vue-material-design-icons/ChatQuestion.vue';
import RobotIcon from 'vue-material-design-icons/Robot.vue';
import CommentIcon from 'vue-material-design-icons/Comment.vue';
import HeadQuestionIcon from 'vue-material-design-icons/HeadQuestion.vue';
import GoogleCirclesCommunities from 'vue-material-design-icons/GoogleCirclesCommunities.vue';
// import link from intertiajs to use the link component
import { Link } from '@inertiajs/inertia-vue3';
export default {
    props: ['totalUsers', 'totalQuestions', 'totalThreads', 'totalAnswers', 'totalReplies', 'totalChannels', 'totalAiAnswers', 'questionsLastMonth', 'threadsLastMonth'],
    components: {
        ReplyIcon,
        MenuIcon,
        AccountIcon,
        PostIcon,
        Account,
        ChatQuestion,
        RobotIcon,
        CommentIcon,
        HeadQuestionIcon,
        GoogleCirclesCommunities,
        Link
        // FaceProfile
    },
    mounted() {
        const aboutSection = document.getElementById("about");

        if (aboutSection) {
            const parent = aboutSection.parentElement;

            // Remove specific Tailwind padding classes from the parent element
            parent.classList.remove('px-4', 'pb-28', 'sm:px-6', 'md:px-8', 'xl:px-12');

            // Apply specific padding and background styles only to this section's parent
            parent.style.padding = "0px !important";
            parent.style.backgroundImage = "url('/about.webp')";
            parent.style.backgroundSize = "cover";
            parent.style.backgroundPosition = "center";
            parent.style.backgroundRepeat = "no-repeat";
        }
        else {
            const parent = document.getElementById(aboutSection);
            // no background image
            parent.style.backgroundImage = "none";
            parent.classList.add('px-4', 'pb-28', 'sm:px-6', 'md:px-8', 'xl:px-12');
        }
    }
};
</script>
