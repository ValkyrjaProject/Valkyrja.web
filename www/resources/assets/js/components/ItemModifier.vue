<template>
    <div class="itemList loadComponent">
        <div class="listContainer">
            <h2>{{listName}}</h2>
            <list-container :value="itemList"
                            @input="setActiveItem($event)"
                            @click="removeItem($event)"
                            @add="newItem()"
                            :hide-form="true"
                            :include-search="true"
                            :can-add="true"
                            list-type="doubleInput"
                            :display-attribute="displayAttribute"
                            :form-name="formName"
                            class="tallerList"></list-container>
        </div>
        <div class="listContainer">
            <div v-if="activeItem != null">
                <slot :active-item="activeItem"></slot>
            </div>
            <div v-else>Nothing selected</div>
        </div>
        <span v-for="item in itemList">
            <span v-for="(itemType, itemTypeKey) in item" v-if="itemType !== null">
                <span v-if="itemType instanceof Array">
                    <span v-if="itemType.length == 0">
                        <input type="hidden" :name="inputName(itemTypeKey, item)" value="">
                    </span>
                    <span v-else>
                        <input v-for="(role, roleKey) in itemType" type="hidden"
                               :name="roleName(itemTypeKey, item)" :value="role">
                    </span>
                </span>
                <span v-else-if="typeof(itemType)  === 'boolean'">
                    <input type="hidden" :name="inputName(itemTypeKey, item)" :value="itemType || false">
                </span>
                <span v-else-if="itemType.length > 0">
                    <input type="hidden" :name="inputName(itemTypeKey, item)" :value="itemType || ''">
                </span>
                <span v-else>
                    <input type="hidden" :name="inputName(itemTypeKey, item)" :value="itemType">
                </span>
            </span>
        </span>
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
            listName: {
                required: true,
                type: String
            },
            newItemLayout: {
                required: true,
                type: Object
            },
            itemLayoutPrimaryKey: {
                required: true,
                type: String
            },
            displayAttribute: {
                type: String,
                required: false,
                default: 'commandid'
            },
        },
        components: {
            ListContainer
        },
        beforeUpdate() {
            // When we get updated data, set the active item if it's not set
            if (this.itemList.length > 0 && (this.activeItem === undefined || this.activeItem === null)) {
                this.setActiveItem(this.itemList[0]);
            }
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
            newItem() {
                let item = Object.assign({}, this.newItemLayout);
                item[this.itemLayoutPrimaryKey] += this.itemList.length;

                this.$store.dispatch('addItem', {
                    formName: this.formName,
                    item
                });
                this.setActiveItem(item);

                let duplicateItem = this.isDuplicate(item);
                if (duplicateItem) {
                    this.$store.dispatch('editItemClass', {
                        index: this.itemList.indexOf(item),
                        formName: this.formName,
                        classData: {'has-danger': true}
                    });
                    this.$store.dispatch('editItemClass', {
                        index: this.itemList.indexOf(duplicateItem),
                        formName: this.formName,
                        classData: {'has-danger': true}
                    })
                }
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