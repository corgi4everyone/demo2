<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import TabLayout from '@/Components/TabLayout.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import SuperCardWrapper from "@/Components/SuperCardWrapper.vue";

const props = defineProps({
    courses: Object,
    currentTab: {
        type: String,
        default: 'ongoing'
    }
});
const page = usePage();

const contentTabs = computed(() => {
    const currentTab = page.props.tab || props.currentTab;
    return [
        { name: 'Ongoing', href: `/course/ongoing`, active: currentTab === 'ongoing' },
        { name: 'Completed', href: `/course/completed`, active: currentTab === 'completed'}
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
        <div v-if="courses" class="grid lg:grid-cols-3 md:grid-cols-2 gap-6 justify-items-center sm:px-0">
            <SuperCardWrapper v-for="card in courses" :card="card" :cardType="'course_'+props.currentTab" />
        </div>
        <div v-else class="text-center text-gray-500">
            No courses found.
        </div>
    </AppLayout>
</template>

