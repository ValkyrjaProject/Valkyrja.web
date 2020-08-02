<template>
    <div>
        <list-selector :value="listValues"
                       @add="channelAdded($event)"
                       @remove="channelRemoved($event)"
                       available-label="Available channels"
                       added-label="Added channels"></list-selector>
        <slot :added="added"></slot>
    </div>
</template>

<script>
    import ListSelector from '../components/ListSelector.vue'
    import {updateItem, addItem, removeItem} from '../vuex/actions'

    export default {
        name: "auto-announce-channel-list-selector",
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
                            return t.channelid === c.id && t.auto_announce == true
                        }).length === 0);
                    }),
                    added: this.available.filter(c => {
                        return !(this.added.filter(t => {
                            return t.channelid === c.id && t.auto_announce == true
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
                        key: 'auto_announce',
                        formName: 'channels',
                        obj: channelToChange,
                    });
                }
                else {
                    let newChannel = {
                        channelid: channel.id,
                        ignored: false,
                        auto_announce: true,
                    };
                    this.$store.dispatch('addItem', {
                        item: newChannel,
                        formName: 'channels',
                    });
                }
            },
            channelRemoved(channel) {
                const channelToChange = this.added.filter(e => e.channelid === channel.id)[0];
                this.$store.dispatch('updateItem', {
                    data: false,
                    key: 'auto_announce',
                    formName: 'channels',
                    obj: channelToChange,
                });
            },
        }
    }
</script>