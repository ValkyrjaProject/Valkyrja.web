<template>
    <li>
        <a :class="isActive ? 'is-active' : ''">
            <span :class="setIcon(item.icon)"/>
            {{ item.name }}
        </a>
    </li>
</template>

<script>
export default {
    name: "ConfigNavbarItem",
    props: {
        item: {
            type: Object,
            required: true
        },
        isActive: {
            type: Boolean,
            required: false,
            default: false,
        }
    },
    methods: {
        setIcon(icon) {
            return "icon mdi mdi-" + icon;
        }
    }
};
</script>

<style scoped>

</style>
