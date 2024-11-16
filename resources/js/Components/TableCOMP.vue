<template>
    <div class="w-full mx-auto overflow-scroll">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Title
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Course
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Due Date
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Grade
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="item in props.data" :key="item.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ item.title }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ item.course_title }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ item.course_code }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                        >
                            {{ item.due_date }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="p-2 inline-flex text-sm leading-5 font-semibold rounded-md"
                            :class="{
                                'bg-green-100 text-green-800': item.grade,
                                'bg-yellow-100 text-gray-800': !item.grade,
                            }"
                        >
                            {{ item.grade ? item.grade : "pending" }}
                        </span>
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex space-x-2">
                            <a
                                href="#"
                                class="text-indigo-600 hover:text-indigo-900 hidden"
                                >Edit</a
                            >
                            <a
                                href="#"
                                class="text-indigo-600 hover:text-indigo-900"
                                >View</a
                            >
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
const props = defineProps({
    data: Array,
    required: true,
});
</script>
