<template>
    <div class="navbar-item logged-in has-dropdown is-hoverable">
        <a class="navbar-link">
            <img 
                v-if="user.avatar !== null" 
                :src="user.avatar" 
                class="avatar icon is-large is-circular">
            <span 
                v-else 
                class="icon is-hidden-touch is-large mdi mdi-48px mdi-account"></span>
            {{ user.name }}
        </a>
        <div class="navbar-dropdown is-right">
            <a 
                class="navbar-item" 
                href="#">
                Overview
            </a>
        </div>
    </div>
</template>

<script>
export default {
    name: "LoggedIn",
    computed: {
        user() {
            return this.$store.state.user;
        }
    }
};
</script>

<style scoped>

</style>
