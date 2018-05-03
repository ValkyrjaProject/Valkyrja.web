<template>
    <div class="customComponent loadComponent">
        <div class="listRow">
            <div class="listContainer hidden">
            </div>
            <div class="listContainer">
                <h2>Level</h2>
                <div class="input-group">
                    <span class="input-group-addon itemLeft btn btn-secondary"
                          @click="addLevel()">+</span>
                    <select class="form-control" title="" v-model="selectedLevel">
                        <option :value="level.id" v-for="level in sortedLevels">{{ level.name }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="listRow">
            <div class="listContainer">
                <h2>Available roles</h2>
                <list-container v-model="typeAvailable"
                                :hide-form="true"
                                :include-search="true"></list-container>
            </div>
            <div class="listContainer">
                <h2>Added roles</h2>
                <list-container v-model="typeAdded"
                                :hide-form="true"
                                :include-search="true"></list-container>
            </div>
        </div>
        <slot :typeAdded="addedTypes"></slot>
    </div>
</template>

<script>
    import ListContainer from '../components/ListContainer.vue'
    import {addLevel, removeLevel} from '../vuex/actions'

    export default {
        components: {
            ListContainer
        },
        props: {
            value: {
                type: Object,
                required: false,
            },
            hideInputs: {
                type: Boolean,
                required: false,
                default: true
            },
            stateIndex: {
                type: Number,
                required: false
            }
        },
        data: function () {
            return {
                selectedLevel: "1",
                levels: [
                    "1"
                ]
            }
        },
        created() {
            for (let type of this.addedTypes) {
                if (this.levels.indexOf(type.level) === -1 && type.level > 0) {
                    this.levels.push(type.level);
                    console.log('add');
                }
            }
            this.selectedLevel = this.levels[0];
        },
        computed: {
            addedTypes() {
                return this.$store.state.itemModifier.roleLevels.itemsList;
            },
            formInputName() {
                return 'roles[]';
            },
            typeAvailable: {
                get() {
                    return this.$store.state['roles'].filter(e => {
                        return this.addedTypes.filter(t => {
                            return t[['roleid']] === e.id
                                && t[['level']] !== "0"
                        }).length === 0;
                    });
                },
                set(value) {
                    let newType = {};
                    newType['roleid'] = value.id;
                    newType['level'] = this.selectedLevel;
                    this.$store.dispatch('addLevel', {
                        formName: 'roleLevels',
                        item: newType
                    });
                }
            },
            typeAdded: {
                get() {
                    return this.$store.state['roles'].filter(e => {
                        return !(this.addedTypes.filter(t => t[['roleid']] === e.id
                                && t.level === this.selectedLevel
                                && t.level > 0
                            ).length === 0
                        )
                    });
                },
                set(item) {
                    let removeItem = this.addedTypes[this.addedTypes.findIndex(t => t[['roleid']] === item.id)];
                    this.$store.dispatch('removeLevel', {
                        formName: 'roleLevels',
                        item: removeItem
                    });
                }
            },
            sortedLevels() {
                let levels = this.levels.sort(function (a, b) {
                    return a - b
                });
                let newLevels = [];
                for (let level of levels) {
                    let newLevel = [];
                    newLevel['id'] = level;
                    newLevel['name'] = "Level " + level;
                    newLevels.push(newLevel);
                }
                console.log(newLevels);
                return newLevels;
            }
        },
        methods: {
            addLevel() {
                let start = 1;
                this.levels.every(e => {
                    if (parseInt(e) === start) {
                        start = parseInt(e) + 1;
                        return true;
                    }
                });
                start = start.toString();
                this.levels.push(start);
                this.selectedLevel = start;
            }
        }
    }
</script>