<script setup>
const props = defineProps({
    tabs: {
        type: Array,
        required: true
    },
    modelValue: {
        type: String,
        required: true
    }
})

const emit = defineEmits(['update:modelValue'])

const selectTab = (tabId) => {
    emit('update:modelValue', tabId)
}
</script>

<template>
    <div class="border-b border-gray-200">
        <nav class="flex space-x-8">
            <button
                v-for="tab in tabs"
                :key="tab.id"
                @click="selectTab(tab.id)"
                :class="[
          'py-4 px-1 border-b-2 font-medium text-sm',
          modelValue === tab.id
            ? 'border-black text-black'
            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
        ]"
            >
                {{ tab.label }}
            </button>
        </nav>
    </div>
</template>
