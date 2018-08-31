<template>
    <div>
        <h1 class="title">Select server</h1>
        <div class="message is-info">
            <div class="message-body">
                <div class="columns">
                    <div class="column">
                        Permissions required to be able to configure Botwinder are <code>Administrator</code> & <code>ManageServer</code>, and you need to already have Botwinder on your server before you can configure anything.
                    </div>
                    <div class="column is-one-fifth">
                        <a 
                            class="button is-link" 
                            href="/invite">Invite the bot!</a>
                    </div>
                </div>
            </div>
        </div>
        <p>
            Which server would you like to configure?
        </p>
        <transition 
            name="fade" 
            mode="out-in">
            <div 
                v-if="isLoading" 
                key="skeleton" 
                class="columns is-multiline">
                <div 
                    v-for="n in skeletonCount" 
                    class="column skeleton-column is-narrow">
                    <guild-image/>
                </div>
            </div>
            <div 
                v-else 
                key="guilds" 
                class="columns is-multiline">
                <router-link 
                    v-for="(guild, idx) in guilds" 
                    :key="idx" 
                    :to="{ name: 'guild', params: {guildId: guild.id} }" 
                    class="column guild-column is-narrow">
                    <template v-if="guild._icon !== null">
                        <guild-image 
                            :image="guild.icon" 
                            :image-text="guild.name"/>
                    </template>
                    <template v-else>
                        <guild-image :image-text="guild.name"/>
                    </template>
                </router-link>
            </div>
        </transition>
    </div>
</template>

<script>
import GuildImage from "./GuildImage";
import GuildHeader from "./GuildHeader";
export default {
    name: "Guilds",
    components: {
        GuildImage,
        GuildHeader
    },
    props: {
        skeletonCount: {
            type: Number,
            required: false,
            default: 5
        }
    },
    data: function () {
        return {
            isLoading: true
        };
    },
    computed: {
        guilds() {
            return this.$store.state.guilds;
        }
    },
    created() {
        this.$store.dispatch("retrieveGuilds").then(() => {
            for (let guild of this.guilds) {
                let img = new Image();
                this.isLoading++;
                if (!isNull(guild._icon)) {
                    this.isLoading++;
                    img.onload = () => this.isLoading--;
                    img.src = guild.icon;
                }
                this.isLoading--;
            }
        }).catch(() => this.isLoading = false);
    },
    methods: {
        imageComplete() {
            console.log("Image complete: ".this.isLoading);
            if (this.isLoading) {
                this.isLoading--;
            }
        }
    }
};
</script>

<style scoped>

</style>
