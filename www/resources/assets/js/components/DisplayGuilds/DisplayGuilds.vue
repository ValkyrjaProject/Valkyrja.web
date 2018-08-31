<template>
    <transition 
        name="fade" 
        mode="out-in">
        <router-view/>
    </transition>
</template>

<script>
import VueRouter from "vue-router";
import EditGuild from "../EditGuild/EditGuild";
import Guilds from "./Guilds";

// TODO: Change invite from text to Botwinder button
const router = new VueRouter({
    mode: "history",
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { x: 0, y: 0 };
        }
    },
    routes: [
        {
            name: "guilds",
            path: "/config",
            component: Guilds
        },
        {
            name: "guild",
            path: "/config/:guildId",
            component: EditGuild,
            props: true
        },
    ]
});

export default {
    name: "DisplayGuilds",
    components: {Guilds},
    router,
};
</script>

<style scoped>

</style>
