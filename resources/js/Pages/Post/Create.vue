<template>
    <div>
        <h1>Create Post</h1>
        <form @submit.prevent="createPost">
            <div class="form-group">
                <label for="title">Title:</label>
                <input
                    type="text"
                    class="form-control"
                    id="title"
                    v-model="post.title"
                    required
                />
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea
                    class="form-control"
                    id="content"
                    v-model="post.content"
                    required
                ></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        post: {
            type: Object,
            required: true,
        },
    },
    methods: {
        createPost() {
            // You can access the post data here
            console.log(this.post);
        },
    },
};
</script>
