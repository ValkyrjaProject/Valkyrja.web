<template>
    <span>
        <template v-if="hasImage">
            <figure 
                :data-tooltip="imageText" 
                class="tooltip">
                <template v-if="image !== null">
                    <img 
                        :src="image" 
                        class="is-circular image is-96x96 is-unselectable is-guild">
                </template>
                <template v-else>
                    <div class="is-circular image is-96x96 loading is-unselectable skeleton-circle"/>
                </template>
            </figure>
        </template>
        <template v-else>
            <div class="is-circular image is-96x96 loading is-unselectable skeleton-circle-animated"/>
        </template>
    </span>
</template>

<script>
export default {
    name: "GuildImage",
    props: {
        image: {
            type: String,
            required: false,
            default: null
        },
        imageText: {
            type: String,
            required: false,
            default: null
        }
    },
    computed: {
        hasImage() {
            return this.image !== null || this.imageText !== null;
        }
    }
};
</script>

<style scoped lang="scss">
    .skeleton-circle {
        background-color: #abb1b6;
    }
    .skeleton-circle-animated {
        background-color: #abb1b6;
        &.loading {
            background: linear-gradient(135deg, #aaa 35%, #b4b4b4 50%, #aaa 65%);
            background-size: 600% 600%;
            animation: load-guild 2s linear infinite;
        }
    }

    .is-guild:not(.active) {
        animation: server-hover-out 0.6s ease;
        &:hover, &:focus {
            animation: server-hover-in 0.8s ease forwards;
        }
    }

    @keyframes load-guild {
        0% {
            background-position: 0 0
        }
        55% {
            background-position: 0 0
        }
        100% {
            background-position: 100% 100%
        }
    }

    @keyframes server-hover-in {
        0% {
            border-radius: 50%;
        }

        40% {
            border-radius: 28%;
        }

        70% {
            border-radius: 35%;
        }

        100% {
            border-radius: 33%;
        }
    }

    @keyframes server-hover-out {
        0% {
            border-radius: 33%;
        }

        45% {
            border-radius: 50%;
        }

        65% {
            border-radius: 50%;
        }

        75% {
            border-radius: 49%;
        }

        100% {
            border-radius: 50%;
        }
    }
</style>