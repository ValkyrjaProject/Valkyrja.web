<template>
    <a
        class="panel-block"
        @click="shouldEmit($event)">
        <div class="level is-mobile is-fullwidth">
            <div
                class="level-left level-item">
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
            </div>
            <div
                class="delete level-right level-item"
                @click="$emit('remove', item)">
            </div>
        </div>
    </a>
</template>

<script>
export default {
    name: "PanelListItemRemovable",
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
        },
        shouldEmit(event) {
            if (event.target.className.indexOf("delete") === -1) {
                this.$emit("click", this.item);
            }
        }
    }
};
</script>
<style scoped>
    .is-fullwidth {
        width: 100%;
    }
    .level-left {
        max-width: 70%;
        overflow: hidden;
    }
</style>
