<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import TabLayout from "@/Components/TabComponent.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import UltimateCard from "@/Components/UltimateCard.vue";

const props = defineProps({
    courses: Object,
    currentTab: {
        type: String,
        default: "ongoing",
    },
});
//console.log(props.courses)
const page = usePage();

const contentTabs = computed(() => {
    const currentTab = page.props.tab || props.currentTab;
    return [
        {
            name: "Ongoing",
            href: `/course/ongoing`,
            active: currentTab === "ongoing",
        },
        {
            name: "Completed",
            href: `/course/completed`,
            active: currentTab === "completed",
        },
    ];
});
</script>

<template>
    <AppLayout title="Courses">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Course
            </h2>
        </template>
        <!-- Content Tabs -->
        <div class="mt-6">
            <TabLayout :tabs="contentTabs" variant="secondary" />
        </div>

        <!-- Content Area -->

        <div
            v-if="courses"
            class="grid lg:grid-cols-3 md:grid-cols-2 gap-6 justify-items-center sm:px-0"
        >
            <UltimateCard
                v-for="course in courses"
                :key="course.id"
                :title="course.title"
                :content="[
                    { label: 'Course Completed', progress: course.progress },
                ]"
                :button="[
                    {
                        label: 'View Course',
                        link: `${route('course.show', {
                            course: course.id,
                            tab: 'slides',
                        })}`,
                    },
                ]"
                content-type="progress"
                :subtitle="[course.course_code]"
            />
        </div>
        <div v-else class="text-center text-gray-500">No courses found.</div>
    </AppLayout>
</template>
