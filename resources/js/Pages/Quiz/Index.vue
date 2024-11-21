<!-- resources/js/Pages/Quiz/Index.vue -->
<template>
    <AppLayout title="Quizzes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz
            </h2>
        </template>
        <div class="mt-6">
            <TabLayout :tabs="contentTabs" variant="secondary" />
        </div>
        <!-- Content Area -->
        <div v-if="quizzes">
            <div
                v-if="props.currentTab === 'remaining'"
                class="grid lg:grid-cols-3 md:grid-cols-2 gap-6 justify-items-center sm:px-0"
            >
                <SuperCardWrapper
                    v-for="card in quizzes"
                    :card="card"
                    :cardType="'quiz_' + props.currentTab"
                />
            </div>
            <div v-if="props.currentTab === 'results'">
                <TableCOMP class="lg:block hidden" :data="quizzes" />
                <SuperCardWrapper
                    class="lg:hidden mx-auto"
                    v-for="card in quizzes"
                    :card="card"
                    :cardType="'quiz_' + props.currentTab"
                />
            </div>
        </div>

        <div v-else class="text-center text-gray-500">No Quiz found.</div>
    </AppLayout>
</template>
<script setup>
import TabLayout from "@/Components/TabComponent.vue";
import SuperCardWrapper from "@/Components/SuperCardWrapper.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import TableCOMP from "@/Components/TableCOMP.vue";

const props = defineProps({
    quizzes: Object,
    currentTab: {
        type: String,
        default: "Remaining",
    },
});

//console.log(props.quizzes);

const page = usePage();
const contentTabs = computed(() => {
    const currentTab = page.props.tab || props.currentTab;
    return [
        {
            name: "Remaining",
            href: `/quiz/remaining`,
            active: currentTab === "remaining",
        },
        {
            name: "Results",
            href: `/quiz/results`,
            active: currentTab === "results",
        },
    ];
});
</script>
