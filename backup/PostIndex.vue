<template>
  <AppLayout title="Forum">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Forum</h2>
    </template>
    <div class="min-h-screen bg-white p-5 rounded rounded-lg mt-3">
      <h1 class="text-4xl font-bold mb-2">Introduction to Computer Science</h1>
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
            v-model="searchQuery"
          />
        </div>

        <div class="relative">
          <select
            class="appearance-none bg-white border rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-gray-200"
            v-model="selectedCourse"
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
              v-for="post in posts"
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
              :disabled="currentPage === 1"
            >
              &lt; previous
            </button>
            <button class="text-gray-600 hover:text-gray-900">next &gt;</button>
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
                v-for="comment in selectedPost.comments"
                :key="comment.id"
                class="border-b pb-6"
              >
                <div class="flex gap-4">
                  <div
                    class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0"
                  ></div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                      <span class="font-medium">{{ comment.user.name }}</span>
                      <span class="text-sm text-gray-500">{{
                        comment.created_at
                      }}</span>
                    </div>
                    <p class="text-gray-700">
                      {{ comment.content }}
                    </p>
                  </div>
                </div>
              </div>
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
                  <button hidden class="p-2 hover:bg-gray-100 rounded-lg">
                    <PaperclipIcon class="h-5 w-5 text-gray-500" />
                  </button>
                  <button hidden class="p-2 hover:bg-gray-100 rounded-lg">
                    <ImageIcon class="h-5 w-5 text-gray-500" />
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
            <h2 class="text-2xl font-bold mb-4">Create New Discussion</h2>
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
                  <option value="UE150">Computer Science</option>
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
import { ref, computed, toRef } from "vue";
import {
  SearchIcon,
  ChevronDownIcon,
  PlusIcon,
  PaperclipIcon,
  ImageIcon,
} from "lucide-vue-next";
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";

const searchQuery = ref("");
const selectedCourse = ref("*");
const commentContent = ref("");
const currentPage = ref(1);
const selectedPostId = ref(null);
const newDiscussionTitle = ref("");
const newDiscussionContent = ref("");
const isNewDiscussionModalOpen = ref(false);

const props = defineProps({
  posts: Array,
  user: Object,
});

const posts = toRef(props, "posts");

const selectedPost = computed(() =>
  posts.value.find((post) => post.id === selectedPostId.value)
);

const selectPost = (postId) => {
  selectedPostId.value = postId;
};

Echo.private("posts").listen("PostCreated", (e) => {
  posts.value.unshift(e);
});

Echo.private("comments").listen("CommentCreated", (e) => {
  console.log("New comment created:", e.comment);
  if (selectedPost.value.id === e.comment.post_id) {
    selectedPost.value.comments.unshift(e.comment);
  }
});

const createNewDiscussion = () => {
  if (newDiscussionTitle.value.trim() && newDiscussionContent.value.trim()) {
    // Create a new post object
    const newPost = {
      id: Date.now(),
      title: newDiscussionTitle.value,
      created_at: new Date().toLocaleString(),
      course_code: selectedCourse.value,
      content: newDiscussionContent.value,
      comments: [],
    };

    axios.post(route("post.store"), newPost).then(() => {});

    // Add the new post to the posts array
    posts.value.unshift(newPost);

    // Close the modal and reset form fields
    isNewDiscussionModalOpen.value = false;
    newDiscussionTitle.value = "";
    newDiscussionContent.value = "";

    // Select the newly created Post
    selectPost(newPost.id);
  }
};

const submitComment = () => {
  if (commentContent.value.trim() && selectedPost.value) {
    // Implement comment submission logic

    const comment = {
      user_id: props.user.id,
      post_id: selectedPost.value.id,
      content: commentContent.value,
    };

    axios
      .post(route("comment.store", selectedPost.value.id), comment)
      .then((response) => {
        console.log(response);
      })
      .catch((error) => {
        console.error(error); // added error handling
      });
  }
};
</script>
