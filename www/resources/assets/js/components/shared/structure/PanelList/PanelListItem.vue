<template>
    <a
        class="panel-block"
        @click="$emit('click', item)">
        <span
            v-if="itemIcon"
            class="panel-icon">
            <i
                :class="'mdi mdi-' + itemIcon"
                aria-hidden="true"></i>
        </span>
        <span v-if="item.toString()">
            {{ shorten(item) }}
        </span>
        <span v-else>
            <i>Empty name</i>
        </span>
    </a>
</template>

<script>
export default {
    name: "PanelListItem",
    props: {
        item: {
            type: Object,
            required: true,
        },
        itemIcon: {
            type: String,
            default: null,
            required: false
        }
    },
    methods: {
        shorten(value) {
            return value.toString().trim().substring(0, 25);
        }
    }
};
</script>

<style scoped>

</style>
