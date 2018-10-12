<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <panel-list
                v-model="availableChannels"
                class="column channels"
                title="Available Channels"
            />
            <panel-list
                v-model="ignoredChannels"
                class="column channels"
                title="Ignored Channels"
            />
        </div>
    </div>
</template>

<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";

export default {
    name: "IgnoredChannels",
    components: {
        PanelList,
    },
    computed: {
        state() {
            return this.$store.state.ignoredChannels;
        },
        getters() {
            return this.$store.getters;
        },
        availableChannels: {
            get() {
                return this.getters["ignoredChannels/availableChannels"];
            },
            set(channel) {
                this.$store.dispatch("ignoredChannels/addChannel", channel);
            },
        },
        ignoredChannels: {
            get() {
                return this.getters["ignoredChannels/ignoredChannels"];
            },
            set(channel) {
                this.$store.dispatch("ignoredChannels/removeChannel", channel);
            },
        },
    },
};
</script>

<style scoped>
    .channels.column {
        min-height: 310px;
    }
    .channels.column >>> .panel:last-child {
        min-height: inherit !important;
    }
</style>
