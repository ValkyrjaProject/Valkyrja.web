<template>
    <nav class="level">
        <div class="level-left">
            <div class="level-item">
                <figure class="image is-32x32 is-circular">
                    <img
                        :src="guild ? guild.icon: ''"
                        class="is-circular">
                </figure>
            </div>
            <div class="level-item">
                <h1
                    id="guild-heading"
                    class="title is-spaced">Editing {{ name }}</h1>
            </div>
        </div>
        <div class="level-right">
            <b-button
                id="submitButton"
                :loading="isLoading"
                :disabled="isDisabled"
                class="level-item"
                type="is-link"
                @click="$emit('submit')">Submit</b-button>
        </div>
    </nav>
</template>

<script>
export default {
    name: "SubmitBar",
    props: {
        guild: {
            type: Object,
            required: true,
        },
        isDisabled: {
            type: Boolean,
            required: false,
            default: false
        },
        isLoading: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    computed: {
        name() {
            if (this.guild.name !== null) {
                return this.guild.name;
            }
        },
    },
};
</script>

<style lang="scss">
    .image{
        background-color: #7a7a7a;
    }
</style>
