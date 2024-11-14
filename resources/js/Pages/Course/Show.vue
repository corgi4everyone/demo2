<!-- resources/js/Pages/Course/Show.vue -->
<script setup>
import { computed } from 'vue';
import TabLayout from '@/Components/TabLayout.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from "@inertiajs/vue3";
import SuperCardWrapper from "@/Components/SuperCardWrapper.vue";
import CourseReferences from "@/Components/CourseReferences.vue";

const props = defineProps({
    course: Object,
    currentTab: {
        type: String,
        default: 'slides'
    }
});

const page = usePage();
const contentTabs = computed(() => {
    const currentTab = page.props.tab || props.currentTab;
    return [
        { name: 'Slides', href: route('course.show', { course: props.course.id, tab: 'slides' }), active: currentTab === 'slides' },
        { name: 'Assignments', href: route('course.show', { course: props.course.id, tab: 'assignments' }), active: currentTab === 'assignments' },
        { name: 'Quizzes', href: route('course.show', { course: props.course.id, tab: 'quizzes' }), active: currentTab === 'quizzes' },
        { name: 'Forum', href: route('course.show', { course: props.course.id, tab: 'forum_posts' }), active: currentTab === 'forum_posts' },
    ];
});

const cardsData = computed(() => {
    return props.course[props.currentTab] || [];
});
</script>

<template>
    <AppLayout :title="course.name">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ course.name }}</h2>
        </template>
        <div class="mt-6">
            <TabLayout :tabs="contentTabs" variant="secondary" />
        </div>
        <div class="flex gap-6">
        <div :class="props.currentTab === 'slides' ? 'w-full lg:w-4/5' : 'w-full'">
        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-6 justify-items-center sm:px-0">
           <SuperCardWrapper v-for="card in cardsData" :card="card" :cardType="'course_'+props.currentTab" />

        </div>
        </div>

        <div v-if="props.currentTab === 'slides'" class="lg:block hidden w-full lg:w-1/5 ">
        <CourseReferences :references="course.quick_links" />
        </div>
        </div>

    </AppLayout>
</template>
