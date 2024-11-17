<template>
    <div>
        <PostList :posts="posts" />
    </div>
</template>
<script setup>
import PostList from "@/Components/PostList.vue";

const props = defineProps({
    posts: Array,
    required: true,
});
</script>
<style></style>
