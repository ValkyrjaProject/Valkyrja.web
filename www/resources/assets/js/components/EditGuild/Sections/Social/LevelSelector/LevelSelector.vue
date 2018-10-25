<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <panel-list
                :value="profiles"
                :add-button="true"
                class="column is-half"
                title="Available roles"
                @input="selectedProfile = $event"
                @add="addProfile()"
            />
            <div class="column is-half">
                <div>level panel here</div>
                <panel-list
                    :value="profiles"
                    :add-button="true"
                    title=""
                    @input="selectedProfile = $event"
                    @add="addProfile()"
                />
            </div>
        </div>
    </div>
</template>

<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";

export default {
    name: "LevelSelector",
    components: {
        PanelList
    }
};
</script>

<style scoped>

</style>
