<template>
    <div class="customCommands">
        <div class="itemList loadComponent">
            <div class="listContainer">
                <h2>Messages</h2>
                <list-container :value="itemList"
                        @input="setActiveItem($event)"
                        @click="removeItem($event)"
                        @add="newItem()"
                        :hide-form="true"
                        :include-search="true"
                        list-type="doubleInput"
                        :can-add="true"
                        :display-attribute="displayAttribute"
                        :form-name="formName"
                        class="tallerList"></list-container>
            </div>
            <div class="listContainer">
                <div class="from-group"
                        :class="{'has-danger': false}">
                    <label class="form-control-label">
                        <b>Id</b> - Message ID
                        <input class="form-control" command-name="messageid" value=""
                                @input="updateActiveItemData">
                    </label>
                </div>
                <div class="listContainer">
                    <h2>Available Roles</h2>
                    <list-container :value="itemList"
                            @click="addEmojiRole($event)"
                            :hide-form="true"
                            :include-search="true"
                            :display-attribute="displayAttribute"
                            :form-name="formName"
                            class="tallerList"></list-container>
                </div>
                <div class="listContainer">
                    <h2>Added roles</h2>
                    <list-container :value="itemList"
                            @input="setActiveRole($event)"
                            @click="removeEmojiRole($event)"
                            :hide-form="true"
                            :include-search="true"
                            list-type="doubleInput"
                            :display-attribute="displayAttribute"
                            :form-name="formName"
                            class="tallerList"></list-container>
                </div>
                <div class="listContainer">
                    <div v-if="activeItem != null">
                        <div class="from-group"
                                :class="{'has-danger': false}">
                            <label class="form-control-label">
                                <b>Emoji</b> - Can be normal emoji or <code>server_emoji</code>.
                                    <input class="form-control" command-name="emoji" value=""
                                            @input="updateActiveItemData">
                            </label>
                        </div>
                    </div>
                    <div v-else>Nothing selected</div>
                </div>
            </div>
            <span v-for="item in itemList">
                <span v-for="(itemType, itemTypeKey) in item" v-if="itemType !== null">
                    <span v-if="itemType instanceof Array">
                        <span v-if="itemType.length === 0">
                            <input type="hidden" :name="inputName(itemTypeKey, item)" value="">
                        </span>
                        <span v-else>
                            <input v-for="(role, roleKey) in itemType" type="hidden"
                                    :name="roleName(itemTypeKey, item)" :value="role">
                        </span>
                    </span>
                    <span v-else-if="typeof(itemType)  === 'boolean'">
                        <input type="hidden" :name="inputName(itemTypeKey, item)" :value="itemType ? '1' : '0'">
                    </span>
                    <span v-else-if="itemType.toString().length > 0">
                        <input type="hidden" :name="inputName(itemTypeKey, item)" :value="itemType.toString() || ''">
                    </span>
                </span>
            </span>
        </div>
    </div>
</template>

<script>
    import ListContainer from './ListContainer.vue'
    import listItems from '../mixins/listItems.vue'
    import {
        addItem,
        updateActiveItem,
        editItemClass,
        removeItem
    } from '../vuex/actions'

    export default {
        mixins: [listItems],
        props: {
            formName: {
                required: true
            },
        },
        components: {
            ListContainer
        },
        data() {
            return {
                displayAttribute: "name"
            }
        },
        beforeUpdate() {
            // When we get updated data, set the active item if it's not set
            if (this.itemList.length > 0 && (this.activeItem === undefined || this.activeItem === null)) {
                this.setActiveItem(this.itemList[0]);
            }
        },
        computed: {
            command_prefix() {
                return this.$store.state.command_prefix;
            },
        },
        methods: {
            setActiveItem(item) {
                if (this.activeItem !== null && this.activeItemIndex >= 0) {
                    this.$store.dispatch('editItemClass', {
                        index: this.activeItemIndex,
                        formName: this.formName,
                        classData: {'active': false}
                    });
                }
                this.$store.dispatch('updateActiveItem', {
                    formName: this.formName,
                    item
                });
                if (item !== null && item !== undefined) {
                    this.$store.dispatch('editItemClass', {
                        index: this.itemList.indexOf(item),
                        formName: this.formName,
                        classData: {'active': true}
                    });
                }
            },
            setActiveRole() {

            },
            addEmojiRole() {

            },
            removeEmojiRole() {

            },
            newItem() {
                let item = {
                    messageid: this.itemList.length.toString(),
                    emoji: "",
                    roleid: [],
                };

                this.$store.dispatch('addItem', {
                    formName: this.formName,
                    item
                });
                this.setActiveItem(item);
            },
            removeItem(item) {
                this.$store.dispatch('removeItem', {
                    formName: this.formName,
                    item
                });
                if (item === this.activeItem) {
                    if (this.itemList.length > 0) {
                        this.setActiveItem(this.itemList[0]);
                    }
                    else {
                        this.setActiveItem();
                    }
                }
            },
            inputName(attribute, item) {
                return this.formName + '[' + this.itemList.indexOf(item) + ']' + '[' + attribute + ']'
            },
            roleName(attribute, item) {
                return this.inputName(attribute, item) + '[]';
            }
        }
    }
</script>
