<template>
    <div>
        <b-navbar type="dark" variant="success" id="main-navigation">
            <b-navbar-brand href="/">
                <b-img
                    src="https://rickandmortyapi.com/api/character/avatar/104.jpeg"
                    width="25"
                    height="25"
                    rounded="circle"
                ></b-img>
                {{ APP_NAME }}
            </b-navbar-brand>

            <b-navbar-nav>
                <b-nav-item
                    href="#"
                    class="my-auto"
                    @click="$emit('changeRoute', 'generate-post')"
                >
                    <b-icon icon="file-post"></b-icon>
                    Generate Post
                </b-nav-item>
                <b-nav-item
                    href="#"
                    class="my-auto"
                    @click="$emit('changeRoute', 'list-posts')"
                >
                    <b-icon icon="card-list"></b-icon>
                    Posts
                </b-nav-item>
            </b-navbar-nav>
        </b-navbar>
    </div>
</template>
<script>
export default {
    data() {
        return {
            APP_NAME: "",
        };
    },
    mounted() {
        this.APP_NAME = process.env.MIX_APP_NAME;
    },
};
</script>
<style scoped>
#main-navigation {
    margin-bottom: 5rem;
}
#main-navigation .navbar-brand {
    margin-left: 2rem;
}
</style>
