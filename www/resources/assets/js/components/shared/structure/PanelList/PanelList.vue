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
        <nav class="panel is-fixed-height has-background-white">
            <transition 
                name="fade" 
                mode="out-in">
                <div 
                    v-if="searchedList.length" 
                    :key="1">
                    <transition-group 
                        name="fade" 
                        mode="out-in">
                        <panel-list-item
                            v-for="(item, idx) in searchedList"
                            :key="idx"
                            :item="item"
                            :item-icon="itemIcon"
                            @click="$emit('input', item)"/>
                    </transition-group>
                </div>
                <div 
                    v-else 
                    :key="2">
                    <p 
                        :key="3" 
                        class="panel-tabs">
                        Not found
                    </p>
                </div>
            </transition>
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
        PanelListItem
    },
    props: {
        title: {
            type: String
        },
        value: {
            type: Array
        },
        itemIcon: {
            type: String,
            required: false
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