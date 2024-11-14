<script setup>

defineProps({
    code: {
        type: String,
        required: true
    },
    title: {
        type: String,
        required: true
    }
})

const handleDownload = () => {
    // Implement download functionality
    console.log('Downloading...')
}
</script>

<template>
    <div class="bg-white rounded-lg p-6 shadow-sm">
        <h3 class="text-sm font-medium text-gray-900">{{ code }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ title }}</p>

        <button
            @click="handleDownload"
            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black"
        >
            Download
        </button>
    </div>
</template>
