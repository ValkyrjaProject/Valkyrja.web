<template>
    <div class="panel">
        <div class="panel-heading">
            Selected Message
        </div>
        <div class="panel-block">
            <div class="control field">
                <div class="control is-expanded">
                    <input
                        id="reaction_id"
                        placeholder="Message ID"
                        type="text"
                        class="input">
                </div>
                <label
                    for="reaction_id"
                    class="help">
                    ID of a message where to watch for reactions. (Use DevMode enabled in the settings of Discord client, right-click a message and <code>copy ID</code>.)
                </label>
            </div>
        </div>
        <div class="panel-block is-paddingless">
            <reaction-roles-emoji />
        </div>
    </div>
</template>

<script>
import ReactionRolesEmoji from "./ReactionRolesEmoji";

export default {
    name: "ReactionRolesForm",
    components: {
        ReactionRolesEmoji,
    }
};
</script>

