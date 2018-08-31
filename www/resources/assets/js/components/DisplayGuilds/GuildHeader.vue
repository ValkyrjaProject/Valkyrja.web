<template>
    <span>
        <template v-if="hasText">
            <h2 class="guild-header">{{ text }}</h2>
        </template>
        <template v-else>
            <div class="guild-header skeleton"/>
        </template>
    </span>
</template>

<script>
export default {
    name: "GuildHeader",
    props: {
        text: {
            type: String,
            required: false,
            default: null
        },
    },
    computed: {
        hasText() {
            return this.text !== null;
        }
    }
};
</script>

<style scoped lang="scss">
    .guild-header {
        height: 26pt;
        &.skeleton {
            width: 180px;
            background-color: #abb1b6;
        }
    }
</style>