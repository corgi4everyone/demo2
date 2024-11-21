<template>
    <NavLink
        :href="href"
        :active="defaultActive === true ? defaultActive : $page.url == href"
    >
        {{ label }}</NavLink
    >
</template>

<script>
import NavLink from "./NavLink.vue";
export default {
    components: {
        NavLink,
    },
    props: {
        href: String,
        label: String,
        defaultActive: Boolean,
    },
};
</script>
