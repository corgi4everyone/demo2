<!-- resources/js/Pages/Course/CourseListing.vue -->
<template>
    <div>
        <!-- Header -->

        <!-- Card -->
        <section class="grid lg:grid-cols-3 gap-3" v-if="courses.length">
            <CourseCard v-for="course in courses" :key="course.id" :course="course"/>
        </section>

    </div>
</template>

<script>
import CourseCard from "@/Components/CourseCard.vue";

export default {
    components: {CourseCard},
    props: {
        courses: { type: Array, required: true}
    }
};
</script>
