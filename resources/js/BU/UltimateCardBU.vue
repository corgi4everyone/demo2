<!-- resources/js/Components/CourseCard.vue -->

<template>
    <div class="w-full max-w-sm p-5 bg-white rounded-lg border border-gray-300">
        <!-- Title Area -->
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900">{{ title }}</h2>
            <!-- Tag Area -->
            <div v-if="tag">
                <p class="p-1 text-sm text-gray-900 bg-yellow-300 rounded-lg">{{tag}}</p>
            </div>
        </div>
        <!-- Subtitle Area -->
        <div class="text-sm text-gray-500 mt-1">
            <div v-for="text in subtitle" class="flex flex-col">
                    <p class="mr-2">{{text}}</p>
            </div>
        </div>
        <!-- Content Area -->
        <div class="mt-5">
            <div v-if="contentType === 'notify'" v-for="item in content">
                {{item.text}}
            </div>
            <div v-else-if="contentType === 'progress'" v-for="item in content">
                <div class="relative w-full h-2 bg-gray-200 rounded-full">
                    <div
                        class="absolute top-0 left-0 h-full bg-black rounded-full"
                        :style="{ width: `${item.progress}%` }"
                    ></div>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{item.label}} {{item.progress}}%</p>
            </div>

            <div v-else-if="contentType === 'singleText'" v-for="item in content">
                {{item.text}}
            </div>
            <div v-else-if="contentType === 'linkText'" v-for="item in content" :key="item">
                <a :href="item.link" class="text-sm text-gray-600 mt-2">{{item.text}}</a>
            </div>


        </div>

        <!-- Button Area -->

        <div v-if="button?.length > 1" class="mt-6 space-x-3 flex items-center justify-center">
            <div v-for="(btn, index) in button" :key="index"
                 class="bg-black w-1/3 text-sm text-white px-3 py-1 rounded-lg hover:bg-gray-800 transition-colors text-center">
                <a :href="btn.link" class="w-full flex justify-center">
                    <span>{{ btn.label }}</span>
                </a>
            </div>
        </div>
        <div v-else>
            <a v-for="(btn, index) in button" :key="index" :href="btn.link" class="mt-6 w-full bg-black text-white px-4 py-3 rounded-lg flex items-center justify-between hover:bg-gray-800 transition-colors">
                <span>{{btn.label}}</span>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </a>
        </div>

    </div>
</template>

<script>

export default {
    props: {

        title: {
            type: String,
            required: true
        },
        subtitle: {
            type: Array,
        },
        content: {
            type: Array,
            required: true
        },
        contentType: {
            type: String,
            required: true, // options: 'notify', 'progress', 'singleText'
        },
        button: {
            type: Array,
        },
        tag: {
            type: String,
        }

    }
};
</script>

