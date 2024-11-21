<template>
    <AppLayout>
        <div class="flex items-center justify-center mt-6">
            <div class="w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                <nav>
                    <ul class="flex justify-start">
                        <li class="space-x-8">
                            <slot name="links" />
                        </li>
                    </ul>
                </nav>

                <div class="mt-3">
                    <slot />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "./AppLayout.vue";

export default {
    components: {
        AppLayout,
    },
};
</script>
