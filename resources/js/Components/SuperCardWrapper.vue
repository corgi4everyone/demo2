<!-- resources/js/Components/CardWrapper.vue -->
<template>
    <UltimateCard v-bind="check(cardType)" />
</template>

<script>
import UltimateCard from "@/Components/UltimateCard.vue";

export default {
    components: {
        UltimateCard,
    },
    props: {
        card: Object,
        cardType: String,
    },
    methods: {
        check(cardType) {
            const baseCard = {
                title: this.card.title,
                subtitle: [
                    {
                        text: this.card.course_code,
                    },
                ],
                content: [{ text: this.card.content }], //flag
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
                case "courses/ongoing":
                case "courses/completed":
                    return {
                        ...baseCard,
                        contentType: "progress",
                        content: [
                            {
                                label: "Course Completed",
                                progress: this.card.progress,
                            },
                        ],
                        button: [
                            {
                                label: "View Course",
                                link: `${route("course.show", {
                                    course: this.card.id,
                                    tab: "slides",
                                })}`,
                            },
                        ],
                    };

                case "assignment/remaining":
                case "assignment/results":
                case "quiz/remaining":
                case "quiz/results":
                    const isResultsTab = cardType.endsWith("_results");
                    const type = cardType.startsWith("assignment")
                        ? "Assignment"
                        : "Quiz";

                    const card = {
                        ...baseCard,
                        subtitle: [
                            { text: this.card.course_code },
                            { text: this.card.course_title },
                        ],
                        tag: {
                            label: `${
                                this.card.is_submitted ? "Submitted" : "Pending"
                            }`,
                            color: `${
                                this.card.is_submitted ? "green" : "yellow"
                            }`,
                        },
                        content: [{ text: `Due Date: ${this.card.due_date}` }],
                        button: [
                            {
                                label: `${
                                    this.card.is_submitted
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
                                    this.card.grade
                                        ? this.card.grade
                                        : "Result not come out yet"
                                }`,
                                style: `${
                                    this.card.grade
                                        ? "font-bold text-green-700"
                                        : "font-bold"
                                }`,
                            },
                            {
                                text: `Due Date: ${this.card.due_date}`,
                                style: "text-xs text-gray-500",
                            },
                        ];
                        if (type === "Assignment") {
                            card.button = [];
                        }
                    }

                    return card;

                //

                case "courses/slides":
                    return {
                        title: this.card.title,
                        button: [
                            {
                                label: "Download",
                                link: `${this.card.url}`,
                            },
                        ],
                    };
                case "courses/forum_posts":
                    return {
                        title: this.card.title,
                        content: [{ text: this.card.content }],
                        contentType: "text",
                        tag: {
                            label: "Unsolved",
                            color: "yellow",
                        },
                        button: [
                            {
                                label: "Join Discussion",
                                link: `#`,
                            },
                        ],
                    };

                default:
                    return {};
            }
        },
    },
};
</script>
