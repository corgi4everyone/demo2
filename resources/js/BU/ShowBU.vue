<script setup>
import { computed } from "vue";
import TabLayout from "@/Components/TabComponent.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { usePage } from "@inertiajs/vue3";
import UltimateCard from "@/Components/UltimateCard.vue";

const props = defineProps({
    course: Object,
    currentTab: {
        type: String,
        default: "slides",
    },
});

const page = usePage();

// Course content tabs
const contentTabs = computed(() => {
    const currentTab = page.props.tab || props.currentTab;
    return [
        {
            name: "Slides",
            href: route("course.show", {
                course: props.course.id,
                tab: "slides",
            }),
            active: currentTab === "slides",
        },
        {
            name: "Assignments",
            href: route("course.show", {
                course: props.course.id,
                tab: "assignments",
            }),
            active: currentTab === "assignments",
        },
        {
            name: "Quizzes",
            href: route("course.show", {
                course: props.course.id,
                tab: "quizzes",
            }),
            active: currentTab === "quizzes",
        },
        {
            name: "Forum",
            href: route("course.show", {
                course: props.course.id,
                tab: "forum_posts",
            }),
            active: currentTab === "forum_posts",
        },
        {
            name: "Quick Links",
            href: route("course.show", {
                course: props.course.id,
                tab: "quick_links",
            }),
            active: currentTab === "quick_links",
        },
    ];
});
</script>

<template>
    <AppLayout :title="course.name">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ course.name }}
            </h2>
        </template>
        <!-- Content Tabs -->
        <div class="mt-6">
            <TabLayout :tabs="contentTabs" variant="secondary" />
        </div>

        <!-- Content Area -->
        <div
            class="grid lg:grid-cols-3 md:grid-cols-2 gap-6 justify-items-center sm:px-0"
        >
            <!-- <slot></slot>
            [ { "id": 1,
            "course_id": 161,
            "title": "Dolores voluptatum sed omnis aliquid voluptatem.",
            "url": "https://www.kunze.org/eos-veritatis-id-atque-vero-rem",
            "created_at": "2024-11-12T13:34:42.000000Z",
            "updated_at": "2024-11-12T13:34:42.000000Z" } ]
            -->
            {{ course[currentTab] }}

            <!--
            <UltimateCard
                title="Python Do While Loop"
                :content="[{text: 'Due Date: 2023-06-01'}]"
                tag="Pending"
                :button="[{ label: 'View', link: `${route('course.index')}` },
                { label: 'Download', link: `${route('course.index')}`, },
                { label: 'Submit', link: `${route('course.index')}`, },
                ]"
                content-type="singleText"
                :subtitle="['ICT167904', 'Due Date: 2023-06-01']" />

            <UltimateCard
                title="Quick Links"
                :content="[
                    { text: 'Course Syllabus', link: 'https://example.com/course-syllabus' },
                    { text: 'Textbook Resources', link: 'https://example.com/textbook-resources' },
                    { text: 'Office Hours Schedule', link: 'https://example.com/office-hours-schedule' },
                ]"
                content-type="linkText"
            />

            -->
        </div>
    </AppLayout>
</template>
