<!-- resources/js/Pages/Course/Show.vue -->
<script>
import SuperCardWrapper from "@/Components/SuperCardWrapper.vue";
import CourseReferences from "@/Components/CourseReferences.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import TabComponent from "@/Components/TabComponent.vue";

export default {
    components: {
        TabComponent,
        SuperCardWrapper,
        CourseReferences,
        MainLayout,
    },
    props: {
        course: Object,
    },
};
</script>

<template>
    <MainLayout>
        <template #links>
            <TabComponent
                :href="`/courses/${course.id}/slides`"
                label="Slides"
                :defaultActive="
                    $page.url == `/courses/${course.id}/slides` ||
                    $page.url == `/courses/${course.id}`
                        ? true
                        : false
                "
            />
            <TabComponent
                :href="`/courses/${course.id}/assignments`"
                label="Assignments"
            />
            <TabComponent
                :href="`/courses/${course.id}/quizzes`"
                label="Quizzes"
            />
            <TabComponent
                :href="`/courses/${course.id}/forum_posts`"
                label="Forum"
            />
        </template>

        <div class="flex gap-6">
            <div
                :class="
                    $page.url.split('/')[3] === 'slides'
                        ? 'w-full lg:w-4/5'
                        : 'w-full'
                "
            >
                <div
                    class="grid lg:grid-cols-3 md:grid-cols-2 gap-6 justify-items-center sm:px-0 mt-6"
                >
                    <SuperCardWrapper
                        v-for="slide in course.slides"
                        :card="slide"
                        :key="slide.id"
                        :cardType="
                            $page.url.split('/')[3]
                                ? $page.url.split('/')[1] +
                                  '/' +
                                  $page.url.split('/')[3]
                                : $page.url.split('/')[1] + '/slides'
                        "
                    />
                </div>
            </div>

            <div
                v-if="$page.url.split('/')[3] === 'slides'"
                class="lg:block hidden w-full lg:w-1/5"
            >
                <CourseReferences :references="course.quick_links" />
            </div>
        </div>
    </MainLayout>
</template>
