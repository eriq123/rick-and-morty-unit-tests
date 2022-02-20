<template>
    <b-card :img-src="item.image" img-top class="my-3 h-100">
        <b-card-title class="d-flex justify-content-between">
            <span>
                {{ itemNameFormatted }}
            </span>
            <b-icon
                icon="trash"
                variant="danger"
                class="my-auto"
                @click="$emit('deletePost', item)"
            ></b-icon>
        </b-card-title>
        {{ item.description }}
    </b-card>
</template>
<script>
export default {
    props: {
        item: Object,
    },
    data() {
        return {};
    },
    computed: {
        itemNameFormatted() {
            if (this.item.title.length >= 20) {
                return this.item.title.substring(0, 17).trimEnd() + "...";
            }
            return this.item.title;
        },
    },
};
</script>
