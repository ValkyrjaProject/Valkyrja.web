<template>
    <div class="profilesEditor loadComponent">
        <item-modifier :form-name="formName"
                       list-name="Profile Editor"
                       :new-item-layout="addProfileTemplate"
                       item-layout-primary-key="option"
                       :displayAttribute="itemLayoutPrimaryKey">
            <template slot-scope="props">
                <div class="from-group"
                     :class="{'has-danger': isDuplicate(props.activeItem) || props.activeItem.option.length === 0}">
                    <label class="form-control-label">
                        <b>Option</b> - Unique parameter used to set the profile field (example: <code>-b</code>)
                        <div class="input-group">
                            <input class="form-control"
                                   command-name="option"
                                   :value="props.activeItem.option"
                                   @input="updateActiveItemData">
                        </div>
                    </label>
                    <div class="form-control-feedback" v-if="isDuplicate(props.activeItem)">
                        Option must be unique.
                    </div>
                    <div class="form-control-feedback" v-if="props.activeItem.option.length === 0">
                        Option cannot be empty.
                    </div>
                </div>
                <div class="from-group"
                     :class="{'has-danger': props.activeItem.option_alt.length === 0}">
                    <label class="form-control-label">
                        <b>Alternative option</b> - Long version of the above option (example: <code>--bike</code>)
                        <div class="input-group">
                            <input class="form-control"
                                   command-name="option_alt"
                                   :value="props.activeItem.option_alt"
                                   @input="updateActiveItemData">
                        </div>
                    </label>
                    <div class="form-control-feedback" v-if="props.activeItem.option_alt.length === 0">
                        Alternative option cannot be empty.
                    </div>
                </div>
                <div class="form-group"
                     :class="{'has-danger': props.activeItem.label.length === 0}">
                    <label>
                        <b>Label</b> - Field title visible in the profile up to 250 characters (example: <code>Mountain Bike</code>)
                        <input class="form-control" command-name="label" :value="props.activeItem.label"
                               @input="updateActiveItemData">
                    </label>
                    <div class="form-control-feedback" v-if="props.activeItem.label.length === 0">
                        Label option cannot be empty.
                    </div>
                </div>
                <div class="form-group"
                     :class="{'has-danger': props.activeItem.property_order.length === 0}">
                    <label>
                        <b>Property Order</b> - The determines the order in which the fields are displayed (example: <code>1</code>)
                        <input class="form-control" command-name="property_order" :value="props.activeItem.property_order"
                               @input="updateActiveItemData">
                    </label>
                    <div class="form-control-feedback" v-if="props.activeItem.property_order.length === 0">
                        Label option cannot be empty.
                    </div>
                </div>
            </template>
        </item-modifier>
    </div>
</template>

<script>
    import ItemModifier from './ItemModifier.vue'
    import listItems from '../mixins/listItems'

    export default {
        mixins: [listItems],
        props: {
            formName: {
                required: true
            }
        },
        data: function() {
            return {
                itemLayoutPrimaryKey: 'option'
            }
        },
        components: {
            ItemModifier,
        },
        computed: {
            command_prefix() {
                return this.$store.state.command_prefix;
            },
            addProfileTemplate() {
                return {
                    option: '-o',
                    option_alt: '--option',
                    label: 'Field Title',
                    property_order: '1'
                };
            },
        },
        methods: {
            hasWhitespace(input) {
                return /^.*\s.*$/.test(input)
            },
            itemIsValid(command) {
                return !(command.option.length === 0);
            },
        }
    }
</script>
