<template>
    <div>
        <list-selector :value="listValues"
                       @add="channelAdded($event)"
                       @remove="channelRemoved($event)"
                       available-label="Available channels"
                       added-label="Ignored channels"></list-selector>
        <slot :added="added"></slot>
    </div>
</template>

<script>
    import ListSelector from '../components/ListSelector.vue'
    import {updateItem, addItem, removeItem} from '../vuex/actions'

    export default {
        name: "channel-list-selector",
        components: {
            ListSelector
        },
        data: function () {
            return {
                addedValues: this.value
            }
        },
        computed: {
            available() {
                return this.$store.state.channels
            },
            added() {
                return this.$store.state.itemModifier.channels.itemsList;
            },
            listValues() {
                return {
                    available: this.available.filter(c => {
                        return (this.added.filter(t => {
                            return t.channelid === c.id && t.ignored == true
                        }).length === 0);
                    }),
                    added: this.available.filter(c => {
                        return !(this.added.filter(t => {
                            return t.channelid === c.id && t.ignored == true
                        }).length === 0);
                    }),
                }
            },
        },
        methods: {
            channelAdded(channel) {
                let channels = this.added.filter(e => e.channelid === channel.id);
                if (channels.length > 0) {
                    let channelToChange = channels[0];
                    this.$store.dispatch('updateItem', {
                        data: true,
                        key: 'ignored',
                        formName: 'channels',
                        obj: channelToChange,
                    });
                }
                else {
                    let newChannel = {
                        channelid: channel.id,
                        ignored: true,
                        auto_announce: false,
                    };
                    this.$store.dispatch('addItem', {
                        item: newChannel,
                        formName: 'channels',
                    });
                }
            },
            channelRemoved(channel) {
                console.log("channel id: " + channel.id);
                const channelToChange = this.added.filter(e => e.channelid === channel.id)[0];
                console.log("channelToChange id: " + this.added.indexOf(channelToChange));
                this.$store.dispatch('updateItem', {
                    data: false,
                    key: 'ignored',
                    formName: 'channels',
                    obj: channelToChange,
                });
            },
        }
    }
</script>