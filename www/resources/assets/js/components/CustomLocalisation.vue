<template>
    <div class="customCommands localisation">
        <div>
            Customize various command (and other feature) replies, translate them, or use random reply using <code>&lt;|&gt;</code> as a separator.
            <br>
            For example: <code>&lt;|&gt;message1&lt;|&gt;message2&lt;|&gt;</code>
            <br>
            Make sure to include all the <code>{n}</code> string parameters as seen in the default setting.
            <br>
            (If you have a command or a feature that isn't in the list but you would like to change it, let us know and we can add it!)
        </div>
        <select v-model="localisation_id" class="form-control" name="localisation_id">
            <option :value="0">Default</option>
            <option :value="1">Custom</option>
        </select>
        <div class="inputs">
            <div v-for="(value, key) in localisation.data">
                <div>
                    {{key}}
                </div>
                <textarea type="text"
                          class="form-control"
                          :disabled="!isCustomSelected"
                          :value="isCustomSelected ? value : getDefaultValue(key)"
                          :placeholder="getDefaultValue(key)"
                          :name="isCustomSelected ? 'localisation[' + key + ']' : null"
                          @change="$el => setValue(key, $el)"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import ItemModifier from "./ItemModifier";

    export default {
        name: "CustomLocalisation",
        props: {
            initLocalisationId: {
                type: Number,
                required: true,
            }
        },
        data: function() {
            return {
                localisation_id: this.initLocalisationId,
                formName: 'custom_localisation',
            }
        },
        components: {
            ItemModifier,
        },
        computed: {
            isCustomSelected() {
                return this.localisation_id === 1
            },
            localisation() {
                return this.$store.state.localisation;
            }
        },
        methods: {
            setValue(key, $el) {
                this.$store.dispatch('setLocalisationValue', {
                    key,
                    value: $el.target.value
                });
            },
            getDefaultValue(key) {
                return this.localisation.defaults[key]
            }
        },
        watch: {
            localisation_id: function (val, oldVal) {
                // If we're switching to custom, automatically expand
                if (val === 1 && oldVal !== 1) {
                    this.dataIsExpanded = true
                }
                else {
                    this.dataIsExpanded = false;
                }
            },
        }
    }
</script>

<style scoped>
    .localisation {
        min-width: 400px;
    }
    .inputs .form-control {
        width: 100%;
    }
</style>