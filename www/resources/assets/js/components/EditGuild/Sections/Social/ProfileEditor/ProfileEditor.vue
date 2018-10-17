<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <panel-list
                :value="['test', 'test2']"
                class="column is-two-fifths roles"
                title="Available Roles"
            />
            <div class="column">
                Text
            </div>
        </div>
    </div>
</template>

<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";

export default {
    name: "ProfileEditor",
    components: {
        PanelList,
    },
};
</script>
