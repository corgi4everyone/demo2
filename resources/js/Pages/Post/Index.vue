<template>
    <AppLayout title="Forum">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Forum
            </h2>
        </template>
        <div class="min-h-screen bg-white p-5 rounded rounded-lg mt-3">
            <h1 class="text-4xl font-bold mb-2">
                Introduction to Computer Science
            </h1>
            <div class="text-gray-600 mb-8">Forum</div>

            <!-- Search and Filter Bar -->
            <div class="flex items-center gap-4 mb-8">
                <div class="relative flex-1">
                    <SearchIcon
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5"
                    />
                    <input
                        type="text"
                        placeholder="Search posts"
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200"
                        v-model="search"
                        @input="debouncedSearch"
                    />
                </div>

                <div class="relative">
                    <select
                        class="appearance-none bg-white border rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-gray-200"
                        v-model="selectedCourse"
                        @change="filterByCourse"
                    >
                        <option value="*">All Courses</option>
                        <option value="UE150">Computer Science</option>
                        <option value="EJ692">Programming</option>
                    </select>
                    <ChevronDownIcon
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5"
                    />
                </div>
            </div>

            <div class="flex gap-8">
                <!-- Left Column: Post Overviews -->
                <div class="w-1/3">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold">Discussions</h2>
                        <button
                            @click="isNewDiscussionModalOpen = true"
                            class="flex items-center gap-2 bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors"
                        >
                            <PlusIcon class="h-5 w-5" />
                            New Discussion
                        </button>
                    </div>

                    <div class="space-y-6">
                        <div
                            v-for="post in posts.data"
                            :key="post.id"
                            class="border-b pb-6 cursor-pointer hover:bg-gray-50 p-4 rounded-lg transition-colors"
                            @click="selectPost(post.id)"
                            :class="{
                                'bg-gray-100': selectedPostId === post.id,
                            }"
                        >
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold">
                                    {{ post.title }}
                                </h3>
                                <span class="text-sm text-gray-500"
                                    >{{ post.comments?.length || 0 }} comments
                                </span>
                            </div>
                            <div class="text-sm text-gray-500">
                                Last activity: {{ post.created_at }}
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-6">
                        <button
                            class="text-gray-600 hover:text-gray-900"
                            :disabled="!posts.prev_page_url"
                            @click="changePage(posts.current_page - 1)"
                        >
                            &lt; previous
                        </button>
                        <span
                            >Page {{ posts.current_page }} of
                            {{ posts.last_page }}</span
                        >
                        <button
                            class="text-gray-600 hover:text-gray-900"
                            :disabled="!posts.next_page_url"
                            @click="changePage(posts.current_page + 1)"
                        >
                            next &gt;
                        </button>
                    </div>
                </div>

                <!-- Right Column: Post Details -->
                <div class="w-2/3 border-l pl-8">
                    <div v-if="selectedPost">
                        <h2 class="text-2xl font-bold mb-4">
                            {{ selectedPost.title }}
                        </h2>
                        <p class="text-gray-600 mb-4 border-b pb-4">
                            {{ selectedPost.content }}
                        </p>

                        <!-- Post Comments -->
                        <div class="space-y-6">
                            <div
                                v-for="comment in comments.data"
                                :key="comment.id"
                                class="border-b pb-6"
                            >
                                <div class="flex gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0"
                                    ></div>
                                    <div class="flex-1">
                                        <div
                                            class="flex items-center gap-2 mb-1"
                                        >
                                            <span class="font-medium">{{
                                                comment.user.name
                                            }}</span>
                                            <span
                                                class="text-sm text-gray-500"
                                                >{{ comment.created_at }}</span
                                            >
                                        </div>
                                        <p class="text-gray-700">
                                            {{ comment.content }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Comment Pagination -->
                        <div
                            class="flex justify-between items-center mt-6"
                            v-if="comments.data && comments.data.length > 0"
                        >
                            <button
                                class="text-gray-600 hover:text-gray-900"
                                :disabled="!comments.prev_page_url"
                                @click="
                                    changeCommentPage(comments.current_page - 1)
                                "
                            >
                                &lt; previous
                            </button>
                            <span
                                >Page {{ comments.current_page }} of
                                {{ comments.last_page }}</span
                            >
                            <button
                                class="text-gray-600 hover:text-gray-900"
                                :disabled="!comments.next_page_url"
                                @click="
                                    changeCommentPage(comments.current_page + 1)
                                "
                            >
                                next &gt;
                            </button>
                        </div>

                        <!-- Comment Box -->
                        <div class="mt-8 border rounded-lg p-4">
                            <textarea
                                v-model="commentContent"
                                placeholder="Write your comment..."
                                class="w-full min-h-[100px] p-2 border rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-gray-200"
                            ></textarea>
                            <div class="flex justify-between items-center">
                                <div class="flex gap-2">
                                    <button
                                        hidden
                                        class="p-2 hover:bg-gray-100 rounded-lg"
                                    >
                                        <PaperclipIcon
                                            class="h-5 w-5 text-gray-500"
                                        />
                                    </button>
                                    <button
                                        hidden
                                        class="p-2 hover:bg-gray-100 rounded-lg"
                                    >
                                        <ImageIcon
                                            class="h-5 w-5 text-gray-500"
                                        />
                                    </button>
                                </div>
                                <button
                                    @click="submitComment"
                                    class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition-colors"
                                >
                                    Comment
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        v-else
                        class="flex items-center justify-center h-full text-gray-500"
                    >
                        Select a post to view details
                    </div>
                </div>
            </div>

            <Teleport to="body">
                <div
                    v-if="isNewDiscussionModalOpen"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
                >
                    <div class="bg-white rounded-lg p-6 w-full max-w-md">
                        <h2 class="text-2xl font-bold mb-4">
                            Create New Discussion
                        </h2>
                        <form @submit.prevent="createNewDiscussion">
                            <div class="mb-4">
                                <label
                                    for="discussionTitle"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Title</label
                                >
                                <input
                                    id="discussionTitle"
                                    v-model="newDiscussionTitle"
                                    type="text"
                                    required
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200"
                                    placeholder="Enter discussion title"
                                />
                            </div>
                            <div class="mb-4">
                                <label
                                    for="discussionContent"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Content</label
                                >
                                <textarea
                                    id="discussionContent"
                                    v-model="newDiscussionContent"
                                    required
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 min-h-[100px]"
                                    placeholder="Enter discussion content"
                                ></textarea>
                            </div>
                            <div class="mb-4 relative">
                                <select
                                    class="appearance-none bg-white border rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-gray-200"
                                    v-model="selectedCourse"
                                >
                                    <option value="*">All Courses</option>
                                    <option value="UE150">
                                        Computer Science
                                    </option>
                                    <option value="EJ692">Programming</option>
                                </select>
                                <ChevronDownIcon
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5"
                                />
                            </div>
                            <div class="flex justify-end gap-4">
                                <button
                                    type="button"
                                    @click="isNewDiscussionModalOpen = false"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-100"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800"
                                >
                                    Create Discussion
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </Teleport>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import {
    SearchIcon,
    ChevronDownIcon,
    PlusIcon,
    PaperclipIcon,
    ImageIcon,
} from "lucide-vue-next";
import AppLayout from "@/Layouts/AppLayout.vue";
import { debounce } from "lodash";

const props = defineProps({
    posts: Object,
    user: Object,
    filters: Object,
});

const page = usePage();
const form = useForm({
    search: props.filters.search,
    course: props.filters.course,
});

const posts = ref(props.posts);
const comments = ref({});
const selectedPostId = ref(null);
const commentContent = ref("");
const newDiscussionTitle = ref("");
const newDiscussionContent = ref("");
const isNewDiscussionModalOpen = ref(false);
const search = ref(props.filters.search);
const selectedCourse = ref(props.filters.course || "*");

const selectedPost = computed(() =>
    posts.value.data.find((post) => post.id === selectedPostId.value)
);

const selectPost = async (postId) => {
    selectedPostId.value = postId;
    await fetchComments(postId);
};

const fetchComments = async (postId, page = 1) => {
    try {
        const response = await axios.get(route("comment.index", postId), {
            params: { page },
        });
        comments.value = response.data;
    } catch (error) {
        console.error("Error fetching comments:", error);
    }
};

const changePage = (page) => {
    form.get(route("post.index"), {
        preserveState: true,
        preserveScroll: true,
        only: ["posts"],
    });
};

const changeCommentPage = (page) => {
    if (selectedPost.value) {
        fetchComments(selectedPost.value.id, page);
    }
};

const debouncedSearch = debounce(() => {
    form.search = search.value;
    form.get(route("post.index"), {
        preserveState: true,
        preserveScroll: true,
        only: ["posts"],
    });
}, 300);

const filterByCourse = () => {
    form.course = selectedCourse.value;
    form.get(route("post.index"), {
        preserveState: true,
        preserveScroll: true,
        only: ["posts"],
    });
};

const createNewDiscussion = () => {
    if (newDiscussionTitle.value.trim() && newDiscussionContent.value.trim()) {
        const newPost = {
            title: newDiscussionTitle.value,
            content: newDiscussionContent.value,
            course_code: selectedCourse.value,
        };

        axios.post(route("post.store"), newPost).then(() => {
            isNewDiscussionModalOpen.value = false;
            newDiscussionTitle.value = "";
            newDiscussionContent.value = "";
            form.get(route("post.index"), {
                preserveState: true,
                preserveScroll: true,
                only: ["posts"],
            });
        });
    }
};

const submitComment = () => {
    if (commentContent.value.trim() && selectedPost.value) {
        const comment = {
            user_id: props.user.id,
            post_id: selectedPost.value.id,
            content: commentContent.value,
        };

        axios
            .post(route("comment.store", selectedPost.value.id), comment)
            .then(() => {
                commentContent.value = "";
                fetchComments(selectedPost.value.id);
            })
            .catch((error) => {
                console.error(error);
            });
    }
};

watch(
    () => page.props.posts,
    (newPosts) => {
        posts.value = newPosts;
    }
);

// Listen for new posts
Echo.private("posts").listen("PostCreated", (e) => {
    form.get(route("post.index"), {
        preserveState: true,
        preserveScroll: true,
        only: ["posts"],
    });
});

// Listen for new comments
Echo.private("comments").listen("CommentCreated", (e) => {
    if (selectedPost.value && selectedPost.value.id === e.comment.post_id) {
        fetchComments(selectedPost.value.id);
    }
});
</script>
