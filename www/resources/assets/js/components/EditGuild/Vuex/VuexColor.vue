<template>
    <compact-picker
        v-model="color"
        :palette="defaultColors"/>
</template>

<script>
import {Compact} from "vue-color";

export default {
    name: "VuexColor",
    components: {
        "compact-picker": Compact
    },
    props: {
        storeName: {
            type: String,
            required: true
        },
    },
    data() {
        return {
            defaultColors: [
                "#4D4D4D", "#999999", "#FFFFFF", "#F44E3B", "#FE9200", "#FCDC00",
                "#DBDF00", "#A4DD00", "#68CCCA", "#73D8FF", "#AEA1FF", "#FDA1FF",
                "#333333", "#808080", "#CCCCCC", "#D33115", "#E27300", "#FCC400",
                "#B0BC00", "#68BC00", "#16A5A5", "#009CE0", "#7B64FF", "#FA28FF",
                "#000000", "#666666", "#B3B3B3", "#9F0500", "#C45100", "#FB9E00",
                "#808900", "#194D33", "#0C797D", "#0062B1", "#653294", "#AB149E",
                "#00FF00", "#00FFFF", "#0000FF", "#FF0000", "#FFFF00"
            ]
        };
    },
    computed: {
        color: {
            get() {
                let hex = this.$store.getters.configInput(this.storeName);
                if (hex && hex.value !== null) {
                    hex = hex.value.toString(16).padStart(6, "0");
                }
                return {
                    hex: "#" + hex
                };
            },
            set(value) {
                this.$store.dispatch("changeConfig", {
                    storeName: this.storeName,
                    value: parseInt(value.hex.replace(/#/g, ""), 16)
                });
            }
        }
    }
};
</script>

<style lang="scss">
    .vc-compact {
        box-sizing: content-box;
    }
    .vc-compact-colors {
        margin: 0 !important;
        padding: 0 !important;
    }
    .vc-compact-color-item {
        margin-top: 0 !important;
    }
</style>
