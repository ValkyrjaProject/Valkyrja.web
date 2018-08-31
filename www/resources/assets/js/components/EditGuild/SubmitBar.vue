<template>
    <nav class="level">
        <div class="level-left">
            <div class="level-item">
                <figure class="image is-32x32 is-circular">
                    <img :src="guild.icon">
                </figure>
            </div>
            <div class="level-item">
                <h1 class="title is-spaced">Editing {{ name }}</h1>
            </div>
        </div>
        <div class="level-right">
            <button class="level-item button is-link">Submit</button>
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