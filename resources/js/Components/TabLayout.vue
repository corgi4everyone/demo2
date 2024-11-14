<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    tabs: {
        type: Array,
        required: true,
    },
    variant: {
        type: String,
        default: 'primary',
    },
});

const tabClasses = computed(() => (tab) => {
    const baseClasses = 'inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium transition-colors duration-200 ease-in-out';

    if (props.variant === 'primary') {
        return tab.active
            ? `${baseClasses} border-indigo-400 text-gray-900`
            : `${baseClasses} border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300`;
    }

    // Secondary variant (content tabs)
    return tab.active
        ? `${baseClasses} border-black text-gray-900`
        : `${baseClasses} border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300`;
});

const containerClasses = computed(() => {
    return props.variant === 'primary'
        ? 'border-b border-gray-200'
        : 'border-b border-gray-100';
});
</script>

<template>
        <div class="overflow-hidden sm:rounded-lg">
            <!-- Tab Navigation -->
            <div class="sm:block mb-8">
                <div class="sm:border-b border-gray-200">
                    <div :class="containerClasses">
                        <nav class="flex space-x-8 justify-center sm:justify-start">
                            <Link
                                v-for="tab in tabs"
                                :key="tab.name"
                                :href="tab.href"
                                :class="tabClasses(tab)"
                                :preserve-scroll="true"
                            >
                                {{ tab.name }}
                            </Link>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

</template>
