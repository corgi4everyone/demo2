<!-- resources/js/Components/CardWrapper.vue -->
<template>
    <UltimateCard v-bind="check(cardType)" />
</template>

<script setup>
import UltimateCard from "@/Components/UltimateCard.vue";

const props = defineProps({
    card: {
        type: Object,
        required: true,
    },
    cardType: {
        type: String,
        required: true,
    },
});
// #Course Page

// Course - Index {title, course_code, progress, 1 button}

// Course - Slides {title, url, 1 button}
// "title": "Dolores voluptatum sed omnis aliquid voluptatem.",
// "url": "https://www.kunze.org/eos-veritatis-id-atque-vero-rem",
// "created_at": "2024-11-12T13:34:42.000000Z",
// "updated_at": "2024-11-12T13:34:42.000000Z" } ]

// Course - Forum {title, content, tag, 1 button}
// "title": "Inventore reiciendis incidunt cupiditate.",
// "content": "Amet aperiam possimus quis culpa debitis. Deleniti quibusdam commodi voluptatem officia tempora nisi.",
// "created_at": "2024-11-12T13:34:41.000000Z",
// "updated_at": "2024-11-12T13:34:41.000000Z" } ]

//Course - QuickLinks {text, url}
//[ { "id": 1,
// "course_id": 171,
// "text": "Perferendis ut qui voluptatem aliquid quibusdam cupiditate necessitatibus quia perspiciatis pariatur harum minima eligendi.",
// "url": "http://gottlieb.info/qui-reprehenderit-sit-aut-sit-et-et",
// "created_at": "2024-11-12T13:34:45.000000Z",
// "updated_at": "2024-11-12T13:34:45.000000Z" } ]

// #Assignment Page
// Assignment - Overview {title, course_code, course_name, url, due_Date, 1 buttons(view | submit), tag}
// "title": "Magni quia qui est aliquam.",
// "description": "Veritatis cupiditate iste aut et. Eaque quia at fugit optio. Et quis perferendis vero perspiciatis deleniti modi.",
// "url": "https://www.stroman.com/quos-est-est-id",
// "due_Date": "2024-12-04 20:09:10",
// "created_at": "2024-11-12T13:34:38.000000Z",
// "updated_at": "2024-11-12T13:34:38.000000Z" } ]

// #Quiz Page
// Quiz - Overview {title, course_code, course_name, url, due_Date, 1 buttons(view | submit), tag}
// "title": "Aut labore dolore quam aperiam consequatur voluptatibus.",
// "description": "Iste vel dolor repellat ut ex eius et. Maxime voluptate sit nemo dolorem molestiae.",
// "url": "https://www.ohara.biz/molestiae-deleniti-tempore-debitis-et",
// "due_date": "2024-11-26 04:58:21",
// "created_at": "2024-11-12T13:34:38.000000Z",
// "updated_at": "2024-11-12T13:34:38.000000Z" } ]

const check = (cardType) => {
    const baseCard = {
        title: props.card.title,
        subtitle: [
            {
                text: props.card.course_code,
            },
        ],
        content: [{ text: props.card.content }],
        contentType: "text",
        button: [
            {
                label: "View",
                link: "#",
            },
        ],
    };
    //{title, url, 1 button}
    switch (cardType) {
        case "course_ongoing":
        case "course_completed":
            return {
                ...baseCard,
                contentType: "progress",
                content: [
                    {
                        label: "Course Completed",
                        progress: props.card.progress,
                    },
                ],
                button: [
                    {
                        label: "View Course",
                        link: `${route("course.show", {
                            course: props.card.id,
                            tab: "slides",
                        })}`,
                    },
                ],
            };

        case "assignment_remaining":
        case "assignment_results":
        case "quiz_remaining":
        case "quiz_results":
            const isResultsTab = cardType.endsWith("_results");
            const type = cardType.startsWith("assignment")
                ? "Assignment"
                : "Quiz";

            const card = {
                ...baseCard,
                subtitle: [
                    { text: props.card.course_code },
                    { text: props.card.course_title },
                ],
                tag: {
                    label: `${
                        props.card.is_submitted ? "Submitted" : "Pending"
                    }`,
                    color: `${props.card.is_submitted ? "green" : "yellow"}`,
                },
                content: [{ text: `Due Date: ${props.card.due_date}` }],
                button: [
                    {
                        label: `${
                            props.card.is_submitted
                                ? "View Submission"
                                : "Submit " + type
                        }`,
                        link: `#`,
                    },
                ],
            };
            if (isResultsTab) {
                card.contentType = "text";
                card.content = [
                    {
                        text: `Grade: ${
                            props.card.grade
                                ? props.card.grade
                                : "Result not come out yet"
                        }`,
                        style: `${
                            props.card.grade
                                ? "font-bold text-green-700"
                                : "font-bold"
                        }`,
                    },
                    {
                        text: `Due Date: ${props.card.due_date}`,
                        style: "text-xs text-gray-500",
                    },
                ];
                if (type === "Assignment") {
                    card.button = [];
                }
            }

            return card;

        //

        case "course_slides":
            return {
                title: props.card.title,
                button: [
                    {
                        label: "Download",
                        link: `${props.card.url}`,
                    },
                ],
            };
        case "course_forum_posts":
            return {
                title: props.card.title,
                content: [{ text: props.card.content }],
                contentType: "text",
                tag: "Unsolved",
                button: [
                    {
                        label: "Join Discussion",
                        link: `#`,
                    },
                ],
            };
        /* case "assignment_remaining":
        case "assignment_results":
            return {
                title: props.card.title,
                subtitle: [
                    { text: props.card.course_code },
                    { text: props.card.course_name },
                ],
                tag: {
                    label: `${
                        props.card.is_submitted ? "Submitted" : "Pending"
                    }`,
                    color: `${props.card.is_submitted ? "green" : "yellow"}`,
                },
                contentType: "text",
                content: [{ text: `Due Date: ${props.card.due_date}` }],
                button: [
                    {
                        label: `${
                            props.card.is_submitted
                                ? "View Submission"
                                : "Submit Assignment"
                        }`,
                        link: `#`,
                    },
                ],
            };
        case "quiz_remaining":
            case "quiz_results":
                return {
                    title: props.card.title,
                    subtitle: [
                        { text: props.card.course_code },
                        { text: props.card.course_name },
                    ],
                    tag: {
                        label: `${
                            props.card.is_submitted ? "Submitted" : "Pending"
                        }`,
                        color: `${props.card.is_submitted ? "green" : "yellow"}`,
                    },
                    contentType: "text",
                    content: [{ text: `Due Date: ${props.card.due_date}` }],
                    button: [
                        {
                            label: `${
                                props.card.is_submitted
                                    ? "View Result"
                                    : "Attempt Quiz"
                            }`,
                            link: `#`,
                        },
                    ],
                };
            */

        default:
            return {};
    }
};
</script>
