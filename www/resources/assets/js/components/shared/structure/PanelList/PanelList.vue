<template>
    <div>
        <nav class="panel panel-parent">
            <p
                v-if="title"
                class="panel-heading">
                {{ title }}
            </p>
            <panel-list-search
                v-model="searchQuery"
                @enter="searchEnter"
                @down="increaseIndex"
                @up="decreaseIndex"
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
                            :class="itemClass(item, idx)"
                            class="listItem"
                            @remove="$emit('remove', item)"
                            @click="itemClicked(item)"/>
                    </transition-group>
                </div>
                <div
                    v-else-if="searchQuery.length === 0"
                    :key="2">
                    <p
                        class="panel-tabs not-found">
                        Nothing available
                    </p>
                </div>
                <div
                    v-else
                    :key="3">
                    <p
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
import PanelListItemRemovable from "./PanelListItemRemovable";

export default {
    name: "PanelList",
    components: {
        PanelListSearch,
        PanelListItem,
        PanelListItemRemovable,
    },
    props: {
        title: {
            type: String,
            required: false,
            default: null
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
        },
    },
    data() {
        return {
            searchQuery: "",
            itemIndex: 0,
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
        searchEnter() {
            if (this.searchedList.length && this.searchQuery.length) {
                let index = this.itemIndex-1 < this.searchedList.length ? Math.max(this.itemIndex-1, 0) : 0;
                this.$emit("input", this.searchedList[index]);
                this.searchQuery = "";
                this.itemIndex = 0;
            }
        },
        increaseIndex() {
            if (this.searchedList.length > this.itemIndex && this.searchQuery.length) {
                this.itemIndex++;
            }
        },
        decreaseIndex() {
            if (this.itemIndex > 1 && this.searchQuery.length) {
                this.itemIndex--;
            }
        },
        itemClass(item, index){
            return {
                "is-active": item === this.selectedItem && this.searchQuery !== "",
                "has-background-primary": index+1 === this.itemIndex && this.searchQuery !== "",
            };
        },
        itemClicked(item) {
            this.$emit("input", item);
            this.searchQuery = "";
        }
    }
};
</script>

<style scoped lang="scss">
    .panel-parent {
        margin-bottom: 0;
    }
</style>
