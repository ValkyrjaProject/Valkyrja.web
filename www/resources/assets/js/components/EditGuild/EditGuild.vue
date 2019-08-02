<template>
    <div class="edit-guild-container column has-background-white has-radius-small">
        <submit-bar
            :guild="guild"
            @submit="submitForm"/>
        <div class="columns">
            <div
                sticky-container
                class="column is-3">
                <aside
                    v-sticky
                    id="editGuildNav"
                    sticky-side="top"
                    class="menu">
                    <ul class="menu-list">
                        <li
                            v-for="(tab, i) in tabs"
                            :key="i">
                            <router-link
                                :to="tab.component.url"
                                active-class="is-active">
                                <span :class="setIcon(tab.icon)"></span>
                                {{ tab.name }}
                            </router-link>
                        </li>
                    </ul>
                </aside>
            </div>
            <div
                ref="component"
                class="column content loading-parent">
                <keep-alive>
                    <router-view class="component"/>
                </keep-alive>
            </div>
        </div>
    </div>
</template>

<script>
import SubmitBar from "./SubmitBar";
import BasicConfig from "./Sections/BasicConfig/BasicConfig";
import AntispamConfig from "./Sections/Antispam/AntispamConfig";
import ModerationConfig from "./Sections/Moderation/ModerationConfig";
import LoggingConfig from "./Sections/Logging/LoggingConfig";
import SocialConfig from "./Sections/Social/SocialConfig";
import UserVerificationConfig from "./Sections/UserVerification/UserVerificationConfig";
import VueRouter from "vue-router";
import Sticky from "vue-sticky-directive";
import CustomCommandsConfig from "./Sections/CustomCommands/CustomCommandsConfig";
import RoleAssignmentConfig from "./Sections/RoleAssignment/RoleAssignmentConfig";
import {Config} from "../../models/Config";

const tabs = [
    {
        name: "Basic Configuration",
        icon: "wrench",
        component: {
            url: "/basic-config",
            name: BasicConfig
        }
    },
    {
        name: "Antispam",
        icon: "alert",
        component: {
            url: "/antispam-config",
            name: AntispamConfig
        }
    },
    {
        name: "Moderation",
        icon: "shield",
        component: {
            url: "/moderation-config",
            name: ModerationConfig
        }
    },
    {
        name: "Role Assignment",
        icon: "plus-circle-multiple-outline",
        component: {
            url: "/role-assignment",
            name: RoleAssignmentConfig
        }
    },
    {
        name: "Logging",
        icon: "playlist-plus",
        component: {
            url: "/logging",
            name: LoggingConfig
        }
    },
    {
        name: "New User / Verification",
        icon: "account-check",
        component: {
            url: "/user-verification",
            name: UserVerificationConfig
        }
    },
    {
        name: "Social (Levels & Karma)",
        icon: "comment",
        component: {
            url: "/social",
            name: SocialConfig
        }
    },
    {
        name: "Custom Commands",
        icon: "star",
        component: {
            url: "/custom-commands",
            name: CustomCommandsConfig
        }
    },
];

let routes = [{
    path: "/",
    redirect: tabs[0].component.url
}];

for (let tab of tabs) {
    if (tabs.indexOf(tab) === 0) {
        routes.push({ path: tab.component.url, component: tab.component.name });
    }
    else {
        routes.push({ path: tab.component.url, component: tab.component.name });
    }
}

const router = new VueRouter({
    mode: "hash",
    routes: routes,
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        }
        else {
            let el = document.getElementsByClassName("edit-guild-container")[0].getBoundingClientRect();
            return { x: 0, y: el.top + window.scrollY };
        }
    }
});

export default {
    name: "EditGuild",
    directives: {Sticky},
    router,
    components: {
        SubmitBar,
        BasicConfig,
        AntispamConfig,
        ModerationConfig,
        LoggingConfig,
        SocialConfig,
        UserVerificationConfig,
        CustomCommandsConfig,
    },
    props: {
        guildId: {
            type: String,
            default: null
        }
    },
    data: function () {
        return {
            tabs: tabs,
            loadingElement: null,
        };
    },
    computed: {
        store() {
            return this.$store.state;
        },
        guild() {
            return this.store.guild;
        },
    },
    async mounted() {
        this.loadingElement = this.$loading.open({
            container: this.$refs.component
        });
        await this.$store.dispatch("retrieveConfig", this.guildId);
        this.loadingElement.close();
    },
    methods: {
        setIcon(icon) {
            return "icon mdi mdi-" + icon;
        },
        submitForm() {
            let config = this.store.config;
            if (!this.loadingElement._isDestroyed || !(config instanceof Config)) {
                return;
            }
            console.log(config.getChanges());
            console.log(JSON.stringify(config.getChanges()));
        }
    },
};
</script>

<style lang="sass">
    .loading-parent
        position: relative
</style>
