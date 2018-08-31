<template>
    <div>
        <p>
            Botwinder will act as configured below, if it takes any action, it will PM the naughty user letting them know about it. If you configure it to also ban for excessive spam, it will let the user know one message before banning them. Removed messages and banned users will be logged as configured in the <code>Moderation Log</code> section.
            <br>
            Antispam will not take any action against Admins or Moderators. You should also configure <code>Ignore
            Channels</code> in the Logging section - Antispam will not be active in these channels.
            <br>
            <i>Antispam will not even try to do anything if the bot does not have <code>ManageMessages</code> & <code>Ban</code> permissions.</i>
        </p>
        <p>
            Remember that you can <code>{{ command_prefix }}permit @people</code> to allow anyone mentioned to post a single link or anything else in this section, for three minutes.
        </p>
        <p>
            <b>Members ignore Antispam</b>
            <br>
            <vuex-switch store-name="antispam_ignore_members">
                Should members of roles configured on this page as <code>Member Roles</code> ignore this antispam?
            </vuex-switch>
            <br>
            <i>Hint - an awesome combo of different features together with this checkbox: You can configure
            antispam to be really harsh, use <code>Verification</code> (configured below) and have the
            Verified role also be a <code>Member</code> (configured in Moderation section)</i>
        </p>
        <p>
            <b>Automated ban</b>
            <br>
            If you do not want the bot to ban people for spamming, set this to <code>0</code> (zero)
            otherwise set a number of how many spammy messages should we tolerate before banning them.
            Spammy messages = links or anything else in this section below, while all the options below do
            have a ban option for this as well.
            <br>
            <vuex-number
                :min="0"
                store-name="antispam_tolerance"/>
        </p>
        <p>
            <b>Discord Invites</b>
            <vuex-switch store-name="antispam_invites">
                Remove messages that contain discord invites?
            </vuex-switch>
            <vuex-switch store-name="antispam_invites_ban">
                Ban people after <code>{{ antispam_tolerance }}</code> invites have been removed?
            </vuex-switch>
        </p>
        <p>
            <b>Duplicate messages</b>
            <vuex-switch store-name="antispam_duplicate">
                Remove duplicate messages? Also known as <i>literally spam</i>.
            </vuex-switch>
            <vuex-switch store-name="antispam_duplicate_crossserver">
                We can also remove these cross-server. Imagine that there is someone going through many servers
                and posting some advertisement everywhere, but only a single message per-server so it doesn't
                count as standard spam. Botwinder would notice these messages as being duplicates between
                servers.
            </vuex-switch>
            <vuex-switch store-name="antispam_duplicate_ban">
                Ban people after <code>{{ antispam_tolerance }}</code> messages have been removed?
            </vuex-switch>
        </p>
        <p>
            <b>Mass-mentions</b>
            <br>
            Remove messages that mention more than <code>n</code> people? Set to <code>0</code> (zero) to
            disable, otherwise set the <code>n</code> amount.
            <br>
            <vuex-number
                :min="0"
                store-name="antispam_mentions_max"/>
            <br>
            <vuex-switch store-name="antispam_mentions_ban">
                Ban people after <code>{{ antispam_tolerance }}</code> messages have been removed?
            </vuex-switch>
        </p>
        <p>
            <b>Mute fast-message spam</b>
            <br>
            <vuex-switch store-name="antispam_mute">
                Temporarily mute people if they send too many messages too fast? This is done by assigning them <code>Muted Role</code>, and if they continue spamming after they get muted twice, they get banned, because that's an obvious spambot. Both, the mute and the ban are logged as configured in the <code>Logging</code> section.
            </vuex-switch>
            <br>
            Requires <code>Muted Role</code> to be configured in the <code>Moderation</code> section, where you can also change the duration of the mute.
            <br><br>
            <b>Mute</b>
            <br>
            Duration of the mute.
            <br>
            <span class="field has-addons">
                <a class="control">
                    <vuex-number
                        :min="0"
                        :is-input="true"
                        store-name="antispam_mute_duration"/>
                </a>
                <a class="button is-static">
                    minutes
                </a>
            </span>
        </p>
        <p>
            <b>YouTube links</b>
            <vuex-switch store-name="antispam_links_youtube">
                Remove YouTube links?
            </vuex-switch>
            <vuex-switch store-name="antispam_links_youtube_ban">
                Ban people after <code>{{ antispam_tolerance }}</code> links have been removed?
            </vuex-switch>
        </p>
        <p>
            <b>Twitch links</b>
            <vuex-switch store-name="antispam_links_twitch">
                Remove Twitch links?
            </vuex-switch>
            <vuex-switch store-name="antispam_links_twitch_ban">
                Ban people after <code>{{ antispam_tolerance }}</code> links have been removed?
            </vuex-switch>
        </p>
        <p>
            <b>Hitbox/Smashcast links</b>
            <vuex-switch store-name="antispam_links_hitbox">
                Remove Hitbox and Smashcast links?
            </vuex-switch>
            <vuex-switch store-name="antispam_links_hitbox_ban">
                Ban people after <code>{{ antispam_tolerance }}</code> links have been removed?
            </vuex-switch>
        </p>
        <p>
            <b>Beam/Mixer links</b>
            <vuex-switch store-name="antispam_links_beam">
                Remove Beam and Mixer links?
            </vuex-switch>
            <vuex-switch store-name="antispam_links_beam_ban">
                Ban people after <code>{{ antispam_tolerance }}</code> links have been removed?
            </vuex-switch>
        </p>
        <p>
            <b>Imgur-like links</b>
            <vuex-switch store-name="antispam_links_imgur">
                Remove imgur, gfycat, giphy or tinypic links?
            </vuex-switch>
            <vuex-switch store-name="antispam_links_imgur_ban">
                Ban people after <code>{{ antispam_tolerance }}</code> links have been removed?
            </vuex-switch>
        </p>
        <p>
            <b>All standard links</b>
            <vuex-switch store-name="antispam_links_standard">
                Remove all standard links? This is a list of more-less standard <code>TLD</code>s to be removed, for example <code>.com</code>, <code>.net</code>, and many others... <i>(except the options above (youtube, imgur,..) - enable those if you want them removed as well.)</i>
            </vuex-switch>
            <vuex-switch store-name="antispam_links_standard_ban">
                Ban people after <code>{{ antispam_tolerance }}</code> links have been removed?
            </vuex-switch>
        </p>
        <p>
            <b>Extended links</b>
            <vuex-switch store-name="antispam_links_extended">
                Remove Extended links? Extended links are basically <code>anything.anything</code>
            </vuex-switch>
            <vuex-switch store-name="antispam_links_extended_ban">
                Ban people after <code>{{ antispam_tolerance }}</code> links have been removed?
            </vuex-switch>
        </p>
        <p>
            <b>Voice Channel switching</b>
            <vuex-switch store-name="antispam_voice_switching">
                Warn and ban (for one hour) people who spam-switch voice channels.
            </vuex-switch>
        </p>
    </div>
</template>

<script>
import VuexSwitch from "../../Vuex/VuexSwitch";
import VuexText from "../../Vuex/VuexText";
import VuexNumber from "../../Vuex/VuexNumber";
export default {
    name: "AntispamConfig",
    components: {
        VuexSwitch,
        VuexText,
        VuexNumber
    },
    computed: {
        command_prefix() {
            return this.config("command_prefix");
        },
        antispam_tolerance() {
            return this.config("antispam_tolerance");
        }
    },
    methods: {
        config(name) {
            return this.$store.getters.configInput(name).toString();
        }
    }
};
</script>

<style scoped>

</style>
