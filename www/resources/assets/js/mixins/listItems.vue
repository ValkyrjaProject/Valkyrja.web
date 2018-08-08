<script>
    import {
        updateActiveItemData,
        editItemRoles,
        removeItemRoles,
        editItemClass
    } from '../vuex/actions';

    export default {
        computed: {
            activeItem() {
                return this.$store.state.itemModifier[this.formName].activeItem
            },
            activeItemIndex() {
                return this.itemList.indexOf(this.activeItem);
            },
            itemList() {
                let items = this.$store.state.itemModifier[this.formName];
                if (items.hasOwnProperty('itemsList')) {
                    items = items['itemsList'] || [];
                }
                else {
                    items = [];
                }
                return items;
            },
            roles() {
                return this.$store.getters['item_modifier']({
                    formName: this.formName,
                    roleName: this.roleName,
                    index: this.activeItemIndex
                });
            }
        },
        methods: {
            addRole(role) {
                this.$store.dispatch('editItemRoles', {
                    key: this.activeItemIndex,
                    formName: this.formName,
                    roleName: this.roleName,
                    data: role.id
                });
            },
            removeRole(role) {
                this.$store.dispatch('removeItemRoles', {
                    key: this.activeItemIndex,
                    formName: this.formName,
                    roleName: this.roleName,
                    data: role.id
                });
            },
            isDuplicate(check) {
                for (let item of this.itemList) {
                    if (item[this.itemLayoutPrimaryKey] === check[this.itemLayoutPrimaryKey] && this.itemList.indexOf(item) !== this.itemList.indexOf(check)) {
                        return item;
                    }
                }
                return false;
            },
            updateActiveItemData(e) {
                this.$store.dispatch('updateActiveItemData', {
                    key: e.target.getAttribute('command-name'),
                    formName: this.formName,
                    data: e.target.value
                });
                this.$store.dispatch('editItemClass', {
                    index: this.activeItemIndex,
                    formName: this.formName,
                    classData: {'has-danger': !this.itemIsValid(this.activeItem)}
                });

                for (let item of this.itemList) {
                    let duplicateCommand = this.isDuplicate(item);
                    if (duplicateCommand) {
                        this.$store.dispatch('editItemClass',
                            {
                                index: this.itemList.indexOf(item),
                                formName: this.formName,
                                classData: {'has-danger': true}
                            });
                        this.$store.dispatch('editItemClass',
                            {
                                index: this.itemList.indexOf(duplicateCommand),
                                formName: this.formName,
                                classData: {'has-danger': true}
                            });
                    }
                    else {
                        let isValid = this.itemIsValid(item);
                        if (item.classData === undefined || ( item.classData !== undefined && item.classData['has-danger'] !== !isValid )) {
                            this.$store.dispatch('editItemClass',
                                {
                                    index: this.itemList.indexOf(item),
                                    formName: this.formName,
                                    classData: {'has-danger': !isValid}
                                });
                        }
                    }
                }
            },
            //itemIsValid(item) {}
        }
    }
</script>