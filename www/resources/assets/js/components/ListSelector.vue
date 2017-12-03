<template>
    <div class="customComponent">
        <div class="listContainer">
            <h2>{{availableLabel}}</h2>
            <list-container v-model="typeAvailable"
                            :hide-form="true"
                            :include-search="true"></list-container>
        </div>
        <div class="listContainer">
            <h2>{{addedLabel}}</h2>
            <list-container v-model="typeAdded"
                            :hide-form="true"
                            :include-search="true"></list-container>
        </div>
        <slot :selected="typeAdded"></slot>
    </div>
</template>

<script>
    import ListContainer from '../components/ListContainer.vue'

    export default {
        components: {
            ListContainer
        },
        props: {
            /**
             * available and selected
             */
            value: {
                type: Object,
                required: true,
            },
            /**
             * Label for available not yet added values
             */
            availableLabel: {
                type: String,
                required: false,
                default: "Available",
            },
            /**
             * Label for added values
             */
            addedLabel: {
                type: String,
                required: false,
                default: "Added",
            },
        },
        // data: function () {
        // },
        computed: {
            typeAvailable: {
                get() {
                    return this.value['available'] || []
                },
                set(value) {
                    this.$emit('add', value);
                }
            },
            typeAdded: {
                get() {
                    return this.value['added'] || []
                },
                set(value) {
                    this.$emit('remove', value);
                }
            }
        }
    }
</script>