<template>
    <b-container>
        <b-alert
            variant="success"
            fade
            :show="postSuccess"
            style="margin-top: -4rem"
        >
            Post saved successfully!
        </b-alert>
        <b-alert variant="danger" fade :show="postWentWrong">
            {{ postErrorMessage }}
        </b-alert>
        <b-overlay :show="postLoading" class="loading-overlay">
            <b-card class="mb-2" id="generate-post">
                <b-card-title class="text-center">
                    <b-button
                        type="dark"
                        variant="outline-success"
                        @click="generatePost"
                    >
                        <b-icon icon="file-post"></b-icon>
                        Generate Post
                    </b-button>
                </b-card-title>
                <b-form @submit="savePost">
                    <b-img
                        v-bind="imageProperties"
                        :src="post.image"
                        center
                        class="m1"
                    ></b-img>
                    <b-form-group
                        id="input-group-1"
                        label="Post Title: "
                        label-for="input-1"
                    >
                        <b-form-input
                            v-model="post.title"
                            id="input-1"
                            type="text"
                            placeholder="Post Title"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                        id="input-group-1"
                        label="Description: "
                        label-for="input-1"
                    >
                        <b-form-textarea
                            v-model="post.description"
                            id="textarea"
                            placeholder="Post Description"
                            rows="3"
                            max-rows="6"
                            style="white-space: pre-wrap"
                        ></b-form-textarea>
                    </b-form-group>
                    <b-button
                        type="dark"
                        variant="outline-primary"
                        class="my-3"
                    >
                        <b-icon icon="check-circle"></b-icon>
                        Save
                    </b-button>
                </b-form>
            </b-card>
        </b-overlay>
    </b-container>
</template>
<script>
export default {
    data() {
        return {
            imageBlank: {
                blank: true,
                width: "300",
                height: "300",
                blankColor: "#777",
            },
            imageProperties: {
                blank: true,
                width: "300",
                height: "300",
                blankColor: "#777",
            },
            post: {
                title: "",
                description: "",
                image: "",
            },
            postSuccess: false,
            postWentWrong: false,
            postLoading: false,
            postErrorMessage: "Oops... Something went wrong!",
            timer: "",
        };
    },

    methods: {
        generatePost() {
            const randomID = Math.floor(Math.random() * 800) + 1;
            this.postLoading = true;
            axios
                .get("https://rickandmortyapi.com/api/character/" + randomID)
                .then((response) => {
                    this.post.title = response.data.name;
                    this.post.image = response.data.image;
                    this.imageProperties = {};
                    this.post.description = `${response.data.name} is a ${
                        response.data.gender
                            ? response.data.gender.toLowerCase()
                            : ""
                    } ${
                        response.data.species
                            ? response.data.species.toLowerCase()
                            : ""
                    }. Latest status is ${
                        response.data.status
                            ? response.data.status.toLowerCase()
                            : ""
                    }.`;
                })
                .finally(() => {
                    this.postLoading = false;
                });
        },
        savePost(event) {
            event.preventDefault();
            this.postErrorMessage = "Oops... Something went wrong!";
            if (!this.post.image) {
                this.postErrorMessage = "Post image is required.";
                this.postWentWrong = true;

                setTimeout(() => {
                    this.postWentWrong = false;
                }, 3000);
                return;
            }
            clearTimeout(this.timer);
            axios
                .post("/api/post/store", this.post)
                .then((response) => {
                    if (response.data && response.data.status === "success") {
                        this.postSuccess = true;
                    }
                })
                .catch((error) => {
                    this.postWentWrong = true;
                    console.log(error);
                })
                .finally(() => {
                    this.timer = setTimeout(() => {
                        this.postSuccess = false;
                        this.postWentWrong = false;
                    }, 3000);
                });
        },
    },
};
</script>
<style scoped>
#generate-post,
.loading-overlay {
    max-width: 768px;
    margin: auto;
}
</style>
