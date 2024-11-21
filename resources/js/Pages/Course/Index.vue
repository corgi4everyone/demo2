<script>
import NavLink from "@/Components/NavLink.vue";
import SuperCardWrapper from "@/Components/SuperCardWrapper.vue";
import TabComponent from "@/Components/TabComponent.vue";
import MainLayout from "@/Layouts/MainLayout.vue";

export default {
    components: {
        SuperCardWrapper,
        MainLayout,
        NavLink,
        TabComponent,
    },
    props: {
        courses: Array,
    },
};
</script>

<template>
    <!-- Content Tabs -->
    <MainLayout>
        <template #links>
            <TabComponent
                href="/courses/ongoing"
                label="Ongoing"
                :defaultActive="
                    $page.url == '/courses/ongoing' || $page.url == '/courses'
                        ? true
                        : false
                "
            />
            <TabComponent href="/courses/completed" label="Completed" />
        </template>

        <!-- Content Area -->
        <div
            v-if="courses"
            class="grid lg:grid-cols-3 md:grid-cols-2 gap-6 justify-items-center sm:px-0 mt-6"
        >
            <SuperCardWrapper
                v-for="course in courses"
                :card="course"
                :key="course.id"
                :cardType="
                    $page.url.split('/')[2]
                        ? $page.url.split('/')[1] +
                          '/' +
                          $page.url.split('/')[2]
                        : $page.url.split('/')[1] + '/ongoing'
                "
            />
        </div>
        <div v-else class="text-center text-gray-500">No courses found.</div>
    </MainLayout>
</template>
