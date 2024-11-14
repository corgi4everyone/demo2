<!-- resources/js/Components/CourseCard.vue -->
<template>
    <div class="w-full max-w-sm p-5 bg-white rounded-lg border border-gray-300">
        <h2 class="text-xl font-bold text-gray-900">{{ course.name }}</h2>
        <p class="text-sm text-gray-500 mt-1">{{course.course_code}}</p>

        <div class="mt-5">
            <div class="relative w-full h-2 bg-gray-200 rounded-full">
                <div
                    class="absolute top-0 left-0 h-full bg-black rounded-full"
                    :style="{ width: `${course.progress}%` }"
                ></div>
            </div>
            <p class="text-sm text-gray-600 mt-2">{{course.progress}}%</p>
            <p class="text-sm text-gray-500">Courses Completed</p>
        </div>

        <a :href="route('course.show', { course: course.id, tab: 'slides' })" class="mt-6 w-full bg-black text-white px-4 py-3 rounded-lg flex items-center justify-between hover:bg-gray-800 transition-colors">
            <span>View Course</span>
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
</template>

<script>
export default {
    props: {

        course: {
            type: Object,
            required: true
        },


    }
};
</script>

