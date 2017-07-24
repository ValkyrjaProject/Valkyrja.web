<template>
    <div class="idSelector loadComponent">
        <div v-if="$isLoading(this.initFormName)" class="loading">
            <span>Loading config please wait!</span>
        </div>
        <div class="listContainer">
            <h2>Available {{idType}}</h2>
            <list-container v-model="typeAvailable"
                            :form-name="initFormName"
                            :hide-form="true"
                            :include-search="true"></list-container>
        </div>
        <div class="listContainer">
            <h2>Selected {{idType}}</h2>
            <list-container v-model="typeSelected"
                            :form-name="initFormName"
                            :hide-form="hideInputs"
                            :include-search="true"></list-container>
        </div>
    </div>
</template>

<script>
    import ListContainer from '../components/ListContainer.vue'
    import {editData, removeData} from '../vuex/actions'

    export default {
        components: {
            ListContainer
        },
        props: {
            value: {
                type: Object,
                required: false,
                default: function () {
                    return {}
                }
            },
            initFormName: {
                type: String,
                required: true
            },
            initIdType:  {
                type: String,
                required: true
            },
            hideInputs: {
                type: Boolean,
                required: false,
                default: false
            },
            stateIndex: {
                type: Number,
                required: false
            },
            useStore: {
                type: Boolean,
                required: false,
                default: true
            }
        },
        data: function () {
            return {
                idType: this.initIdType,
                queryAvailable: '',
                querySelected: '',
                isLoading: false
            }
        },
        created () {
            if (this.useStore) {
                this.$startLoading(this.initFormName);
                this.$store.dispatch('updateState', this.initFormName)
                    .then(() => {
                        this.$endLoading(this.initFormName);
                    });
            }
        },
        computed: {
            formInputName () {
                return this.initFormName + '[]';
            },
            types () {
                if (this.useStore) {
                    return this.$store.getters[this.idType.toLowerCase()](this.initFormName) || [];
                }
                return this.value;
            },
            typeAvailable: {
                get () {
                    return this.types['available'] || []
                },
                set (value) {
                    if (this.useStore) {
                        this.$store.dispatch('editData', {
                            key: this.initFormName,
                            data: value.id
                        });
                    }
                    else {
                        this.$emit('add', value);
                    }
                }
            },
            typeSelected: {
                get () {
                    return this.types['selected'] || []
                },
                set (value) {
                    if (this.useStore) {
                        this.$store.dispatch('removeData', {
                            key: this.initFormName,
                            data: value.id
                        });
                    }
                    else {
                        this.$emit('remove', value);
                    }
                }
            }
        }
    }
</script>