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
                        :form-name="formName"></list-container>
            </div>
            <div class="listContainer">
                <div v-if="activeItem != null">
                    <div class="from-group"
                            :class="{'has-danger': false}">
                        <label class="form-control-label">
                            <b>Id</b> - Message ID
                            <input class="form-control" command-name="messageid" :value="activeItem.messageid"
                                    @input="updateActiveItemData">
                        </label>
                    </div>
                    <div class="listContainer">
                        <h2>Available Roles</h2>
                        <list-container :value="availableRoles"
                                @input="addEmojiRole($event)"
                                :hide-form="true"
                                :include-search="true"
                                :form-name="formName"></list-container>
                    </div>
                    <div class="listContainer">
                        <h2>Added roles</h2>
                        <list-container :value="addedRoles"
                                @input="setActiveRole($event)"
                                @click="removeEmojiRole($event)"
                                :hide-form="true"
                                :include-search="true"
                                list-type="doubleInput"
                                :form-name="formName"></list-container>
                    </div>
                    <div class="listContainer">
                        <div v-if="activeRole != null">
                            <div class="from-group"
                                    :class="{'has-danger': false}">
                                <label class="form-control-label">
                                    <b>Emoji</b> - Can be normal emoji or <code>server_emoji</code>.
                                        <input class="form-control" command-name="emoji" v-model="activeRole.emoji">
                                </label>
                            </div>
                        </div>
                        <div v-else>No role selected</div>
                    </div>
                </div>
                <div v-else>No message selected</div>
            </div>
            <span v-for="message in itemList">
                <span v-for="role in message.roles">
                    <input type="hidden" :name="inputName('messageid', role)" :value="message.messageid">
                    <input type="hidden" :name="inputName('roleid', role)" :value="role.id">
                    <input type="hidden" :name="inputName('emoji', role)" :value="role.emoji">
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
                itemLayoutPrimaryKey: "messageid",
                displayAttribute: "messageid",
                activeRole: null,
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
            availableRoles() {
                return this.$store.state['roles'].filter(role => {
                    return this.activeItem.roles.filter(item => {
                        return item.id === role.id;
                    }).length === 0;
                });
            },
            addedRoles() {
                return this.$store.state['roles'].filter(role => {
                    return this.activeItem.roles.filter(item => {
                        if (this.activeRole && role.id === this.activeRole.id)
                            role.classData = {'active': true};
                        else
                            role.classData = {'active': false};
                        return item.id === role.id;
                    }).length !== 0;
                });
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
            setActiveRole(item) {
                this.activeRole = this.$store.state.itemModifier[this.formName].activeItem.roles.find(role => {
                    return role.id === item.id
                });
            },
            addEmojiRole(role) {
                let item = {
                    id: role.id,
                    emoji: "",
                };
                this.$store.dispatch("addEmojiRole", {
                    formName: this.formName,
                    item: item,
                });
                this.activeRole = item;
            },
            removeEmojiRole(role) {
                this.$store.dispatch("removeEmojiRole", {
                    formName: this.formName,
                    item: role.id,
                });
                let activeItem = this.$store.state.itemModifier[this.formName].activeItem;
                if (activeItem && activeItem.roles.length) {
                    this.activeRole = activeItem.roles[0];
                }
                else {
                    this.activeRole = null;
                }
            },
            newItem() {
                let item = {
                    messageid: "",
                    roles: [],
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
            inputName(attribute, role) {
                if (this.$store.state.itemModifier[this.formName].activeItem) {
                    return this.formName + '[' + this.$store.state.itemModifier[this.formName].activeItem.roles.indexOf(role) + ']' + '[' + attribute + ']'
                }
            },
            roleName(attribute, item) {
                return this.inputName(attribute, item) + '[]';
            },
            itemIsValid(item) {
                return true;
            }
        }
    }
</script>
