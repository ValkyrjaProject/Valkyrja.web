<template>
    <div class="panel-block">
        <div class="field has-addons control">
            <p class="control has-icons-left is-expanded">
                <input 
                    :value="searchQuery" 
                    class="input is-small" 
                    type="text"
                    placeholder="Search"
                    @input="$emit('input', $event.target.value)"
                >
                <span class="icon is-small is-left">
                    <i 
                        class="mdi mdi-magnify" 
                        aria-hidden="true"/>
                </span>
            </p>
            <p class="control">
                <a 
                    class="button is-info is-small" 
                    @click="$emit('clear')">
                    <i 
                        class="mdi mdi-close" 
                        aria-hidden="true"/>
                </a>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: "PanelListSearch",
    props: {
        searchQuery: {
            type: String
        }
    }
};
</script>

<style scoped>

</style>