<template>
    <h2>Available {{type}}</h2>
    <draggable v-model="availItems" class="dragArea" :options="dragOptions">
        <div v-for="element in availItems">{{element.name}}</div>
    </draggable>
    <h2>Selected {{type}}</h2>
    <draggable v-model="selectedItems" class="dragArea" :options="dragOptions">
        <div v-for="element in selectedItems">{{element.name}}</div>
    </draggable>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        data: {
            availItems: [],
            selectedItems: []
        },
        methods: {
            add: function() {
                this.list.push({
                    name: 'Juan'
                });
            },
            replace: function() {
                this.list = [{
                    name: 'Edgard'
                }]
            }
        },
        components: {
            draggable,
        },
        computed: {
            myList: {
                get() {
                    return this.$store.state.myList
                },
                set(value) {
                    this.$store.commit('updateList', value)
                }
            },
            dragOptions () {
                return  {
                    group: 'items',
                    editable: true,
                    ghostClass: 'ghost'
                };
            }
        }
    }
</script>