<template>
    <div>
        <nav class="panel panel-parent">
            <p class="panel-heading">
                {{ title }}
            </p>
            <panel-list-search
                v-model="searchQuery"
                @clear="searchQuery = ''"/>
        </nav>
        <nav
            :class="{ 'is-bordered-bottom': !addButton }"
            class="panel panel-parent is-fixed-height is-bordered has-background-white">
            <transition
                mode="out-in">
                <div
                    v-if="searchedList.length"
                    :key="1">
                    <transition-group
                        mode="out-in">
                        <component
                            v-for="(item, idx) in searchedList"
                            :is="listItem"
                            :key="idx"
                            :item="item"
                            :item-icon="itemIcon"
                            :class="{'is-active': item === selectedItem}"
                            class="listItem"
                            @remove="$emit('remove', item)"
                            @click="$emit('input', item)"/>
                    </transition-group>
                </div>
                <div
                    v-else
                    :key="2">
                    <p
                        :key="3"
                        class="panel-tabs not-found">
                        Not found
                    </p>
                </div>
            </transition>
        </nav>
        <nav
            v-if="addButton"
            class="panel">
            <div class="panel-block">
                <button 
                    class="button is-info is-outlined is-fullwidth"
                    @click="$emit('add', $event)">
                    <i
                        class="mdi mdi-plus"
                        aria-hidden="true"></i>
                </button>
            </div>
        </nav>
    </div>
</template>

<script>
import PanelListSearch from "./PanelListSearch";
import PanelListItem from "./PanelListItem";

export default {
    name: "PanelList",
    components: {
        PanelListSearch,
        PanelListItem,
    },
    props: {
        title: {
            type: String,
            required: true,
        },
        value: {
            type: Array,
            required: true,
        },
        itemIcon: {
            type: String,
            required: false,
            default: null,
        },
        listItem: {
            type: String,
            required: false,
            default: "PanelListItem"
        },
        addButton: {
            type: Boolean,
            required: false,
            default: false
        },
        selectedItem: {
            type: Object||null,
            required: false,
            default: null
        }
    },
    data() {
        return {
            searchQuery: ""
        };
    },
    computed: {
        searchedList() {
            if (this.value.length < 1) return [];
            return this.findBy(this.value, this.searchQuery);
        }
    },
    methods: {
        findBy(list, value) {
            return list.filter(function (item) {
                return item.toString().toLowerCase().includes(value.toLowerCase());
            });
        },
    }
};
</script>

<style scoped lang="scss">
    .panel-parent {
        margin-bottom: 0;
    }
</style>
