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
                        <b>Option</b> - Some option
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
                    <div class="form-control-feedback" v-if="hasWhitespace(props.activeItem.option)">
                        Option cannot contain whitespaces.
                    </div>
                </div>
                <div class="from-group">
                    <label class="form-control-label">
                        <b>Alternative option</b> - Some option
                        <div class="input-group">
                            <input class="form-control"
                                   command-name="option_alt"
                                   :value="props.activeItem.option_alt"
                                   @input="updateActiveItemData">
                        </div>
                    </label>
                    <div class="form-control-feedback" v-if="isDuplicate(props.activeItem)">
                        Alternative option must be unique.
                    </div>
                    <div class="form-control-feedback" v-if="props.activeItem.option.length === 0">
                        Alternative option cannot be empty.
                    </div>
                    <div class="form-control-feedback" v-if="hasWhitespace(props.activeItem.option)">
                        Alternative option cannot contain whitespaces.
                    </div>
                </div>
                <div class="from-group">
                    <label class="form-control-label">
                        <b>Description</b> - Description of option.
                        <textarea class="form-control" command-name="description" :value="props.activeItem.description"
                                  @input="updateActiveItemData"></textarea>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <b>Label</b> - the label.
                        <input class="form-control" command-name="label" :value="props.activeItem.label"
                               @input="updateActiveItemData">
                    </label>
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
                    option: '',
                    option_alt: '',
                    description: ''
                };
            },
        },
        methods: {
            hasWhitespace(input) {
                return /^.*\s.*$/.test(input)
            },
            itemIsValid(command) {
                return !(command.option.length === 0
                    || this.hasWhitespace(command.option));
            }
        }
    }
</script>