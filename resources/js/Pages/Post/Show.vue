<template>
    <div>
        {{ post }}
    </div>
</template>
<script setup>
const props = defineProps({
    post: Object,
    required: true,
});
</script>
<style></style>
