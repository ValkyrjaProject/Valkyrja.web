<template>
    <transition 
        name="fade" 
        mode="out-in">
        <component :is="currentComponent"/>
    </transition>
</template>

<script>
import LoggedIn from "./LoggedIn";
import LoggedOut from "./LoggedOut";
import * as lscache from "lscache";

export default {
    name: "UserComponent",
    data: function () {
        return {
            isLoading: true
        };
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
        currentComponent() {
            if (this.isLoggedIn) {
                return LoggedIn;
            }
            return LoggedOut;
        },
        isLoggedIn() {
            return this.user.name != null;
        }
    },
    created() {
        this.$store.dispatch("retrieveUser").then($configData => {
            lscache.set("user", JSON.stringify($configData), 30);

            if (this.user.avatar !== null) {
                let img = new Image();
                img.src = this.user.avatar;
            }
        }).catch(() => {
            return this.isLoading = false;
        });
    },
    mounted() {
        this.$store.dispatch("initializeUser");
    },
};
</script>

<style scoped>

</style>