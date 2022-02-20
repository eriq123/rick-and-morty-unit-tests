<template>
    <div>
        <main-navigation @changeRoute="changeRoute"></main-navigation>
        <b-container>
            <component v-bind:is="currentRoute"></component>
        </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            currentRoute: "generate-post",
        };
    },
    components: {
        "main-navigation": () => import("./system/TheNavigation.vue"),
        "list-posts": () => import("./pages/ListPosts.vue"),
        "generate-post": () => import("./pages/GeneratePost.vue"),
    },
    mounted() {
        const routes = ["generate-post", "list-posts"];
        const currentURI = window.location.pathname.replaceAll("/", "");
        if (routes.includes(currentURI)) this.currentRoute = currentURI;

        this.updateUrl(this.currentRoute);
    },
    methods: {
        changeRoute(newRoute) {
            this.currentRoute = newRoute;
            this.updateUrl(newRoute);
        },
        updateUrl(uri) {
            window.history.pushState(
                {},
                "",
                window.location.origin + "/" + uri
            );
        },
    },
};
</script>
<style>
.alert {
    margin-top: -4rem;
}
</style>
