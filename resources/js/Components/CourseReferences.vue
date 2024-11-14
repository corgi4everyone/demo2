<script setup>
defineProps({
    references: {
        type: Array,
        required: true
    },

})

const truncateText = (text, maxLength) => {
            return text.length > maxLength ? text.slice(0, maxLength) + '...' : text
}

</script>

<template>
    <div class="w-80 flex-shrink-0">
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Course References</h2>
            <ul class="space-y-3">
                <li v-for="reference in references" :key="reference.id">
                    <a
                        :href="reference.url"
                        class="flex items-start space-x-3 text-sm text-blue-600 hover:text-blue-800"
                    >
                        <span>{{ truncateText(reference.text, 15) }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
