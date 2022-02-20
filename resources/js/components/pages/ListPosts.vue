<template>
    <b-overlay :show="isListPostsLoading" v-if="items.length > 0">
        <b-row cols="4" class="mb-4">
            <b-col v-for="(item, index) in items" :key="index" class="p-3">
                <list-post-card
                    :item="item"
                    @deletePost="deletePost"
                ></list-post-card>
            </b-col>
        </b-row>
    </b-overlay>
    <b-alert variant="info" :show="isNoPostAvailable" v-else>
        No post available.
    </b-alert>
</template>
<script>
export default {
    components: {
        "list-post-card": () => import("./ListPostsCard.vue"),
    },
    data() {
        return {
            items: [],
            isListPostsLoading: true,
        };
    },
    mounted() {
        axios("/api/posts")
            .then((response) => {
                if (response.data && response.data.status === "success") {
                    this.items = response.data.posts;
                }
            })
            .finally(() => {
                this.isListPostsLoading = false;
            });
    },
    methods: {
        deletePost(item) {
            this.isListPostsLoading = true;
            axios
                .post("/api/post/delete", { id: item.id })
                .then((response) => {
                    if (response.data && response.data.status === "success") {
                        let itemIndex = this.items.indexOf(item);
                        this.items.splice(itemIndex, 1);
                    }
                })
                .finally(() => {
                    setTimeout(() => {
                        this.isListPostsLoading = false;
                    }, 200);
                });
        },
    },
    computed: {
        isNoPostAvailable() {
            return this.items.length === 0 && !this.isListPostsLoading;
        },
    },
};
</script>
