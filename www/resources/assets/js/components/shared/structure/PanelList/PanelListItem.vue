<template>
    <a 
        class="panel-block" 
        @click="$emit('click', item)">
        <span 
            v-if="itemIcon" 
            class="panel-icon">
            <i 
                :class="'mdi mdi-' + itemIcon" 
                aria-hidden="true"/>
        </span>
        {{ shorten(item) }}
    </a>
</template>

<script>
export default {
    name: "PanelListItem",
    props: {
        item: {
            type: Object
        },
        itemIcon: {
            type: String,
            required: false
        }
    },
    methods: {
        shorten(value) {
            return value.toString().trim().substring(0, 25);
        }
    }
};
</script>

<style scoped>

</style>