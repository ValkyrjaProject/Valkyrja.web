@extends('layouts.master')

@section('title', 'Features')

@section('content')
    <section data-sticky-container class="columns">
        <section class="column is-3 hidden-sm-down docs-navigation-container">
            <ul id="docs-navigation">
            </ul>
        </section>
        <section class="column nav container col-sm-9 scrollspy-elements docs-content" style="position:relative;">
            <div class="row col-xs-12 content">
                <div>
                    <h1>Open Source</h1>
                    <div class="features-indent">
                        Botwinder is Open Source and you can find it in the below repositories, contribution is welcome.
                        <table class="command">
                            <tr>
                                <td><a href="https://github.com/RheaAyase/Botwinder.core">Botwinder.core</a></td>
                                <td>Core client code.</td>
                            </tr>
                            <tr>
                                <td><a href="https://github.com/RheaAyase/Botwinder.discord">Botwinder.discord</a></td>
                                <td>Most of Botwinder's features</td>
                            </tr>
                            <tr>
                                <td><a href="https://github.com/RheaAyase/Botwinder.secure">Botwinder.secure</a></td>
                                <td>Private repository containing sensitive code, such as antispam.</td>
                            </tr>
                            <tr>
                                <td><a href="https://github.com/RheaAyase/Botwinder.web">Botwinder.web</a></td>
                                <td>This website.</td>
                            </tr>
                            <tr>
                                <td><a href="https://github.com/RheaAyase/Botwinder.service">Botwinder.service</a></td>
                                <td>What you can see as <code>Skywinder</code> on Discord, a server cluster management bot.</td>
                            </tr>
                            <tr>
                                <td><a href="https://github.com/RheaAyase/Botwinder.status">Botwinder.status</a></td>
                                <td>The <code>status.botwinder.info</code> page - slightly modified <a href="https://github.com/shevabam/ezservermonitor-web">eZ Server Monitor</a></td>
                            </tr>
                        </table>
                    </div>
                    <h1>Key Features</h1>
                    <p>
                        These are some features that are not fully covered by simple commands:
                    <ul>
                        <li><b>Encrypted Database</b> containing notes about users, all known usernames and nicknames, with good search based on keyword, userid or mention.</li>
                        <li><b>Configure</b> many aspects of the bot: customize the command prefix, <b>antispam system</b> to remove discord invites, links, spam or messages that contain many mentions, and ban these spambots! (<code>!permit</code> is a thing too!) And the Botwinder will give you some cookies as well! (<a href="/config">Can be configured.</a>)</li>
                        <li>Force people to read the rules with the hidden code <b>verification system</b>, where the bot will send a user the rules, with hidden code, which they have to find and send back to get a member role assigned. The above also applies. Oh and they can get cookies for verifying, if you configure that as well.
                        <li><b>Log user events</b> like user joining or leaving the server, being promoted or demoted, and PM a new user when they join the server. You can change these messages to your liking, set whether to @mention them, or just use their name as text, etc. (<a href="/config">Can be configured.</a>)</li>
                        <li><b>Log moderation events</b>, banned and kicked users, edited and deleted messages, where you can also set up "ignored channels" where the bot will ignore deleted messages, etc... (<a href="/config">Can be configured.</a>)</li>
                        <li>You can even <b>log users switching between voice channels.</b></li>
                        <li>Set up your own <b>custom commands</b>, with a few keywords! (<a href="/config">Can be configured.</a>)</li>
                        <li>You can <b>create an alias</b> to <i>any</i> command. (<code>!alias</code>)</li>
                        <li>Did you like <b>temporary channels</b> on TeamSpeak? No problem, we've got you. (<code>!tempChannel</code>)</li>
                        <!--li>Create <b>scheduled messages</b> or timers. These can even be <b>scheduled commands</b>, so you can even schedule a daily <code>!nuke</code> of a channel! :D (<code>!timers</code>)</li-->
                        <!--li>Run a <b>poll</b>! Those can be as simple as with yes/no/abstain options, or you can add anything you desire. You can even choose to run a free poll where the user can vote on literally anything and it will be added as a new option! (<code>!poll</code>)</li-->
                        <!--li>Run the best <b>events</b> in the universe with signups, checkin, keep track of score, etc... (<code>!event</code>)</li-->
                        <!--li>Keep track of your <b>meetings</b>, generate nice minutes and logs. (<code>!meeting</code>)</li-->
                        <li>Last but not least, we put a lot of emphasis on <b>security</b>. No server has access to any data from any other server, and no sensitive data is available to public. All the data stored on our servers is encrypted. Further, you can see below we have different permission levels, and everything somewhat important or sensitive is hidden behind those permissions, including previously known usernames, times, etc etc...</li>
                    </ul>
                    </p>
                    <h1 class="features-h1">Command permissions</h1>
                    <div class="features-indent">
                        <p>
                            &nbsp; This documentation contains a list of commands, permissions who can use those, and short description. Permissions are configured via the <a href="/config">configuration</a>, and the hierarchy is as follows: <code>ServerOwner&nbsp;&gt;&nbsp;Admin&nbsp;&gt;&nbsp;Moderator&nbsp;&gt;&nbsp;SubModerator&nbsp;&gt;&nbsp;Member&nbsp;&gt;&nbsp;Everyone</code> where for example Admin can use everything that is marked as Admin, Moderator, or Everyone, but can not use commands marked as ServerOwner.
                        </p>
                        <p>
                            &nbsp; <code>ServerOwner</code> stands for either server owner, or someone with the <code>ManageServer</code> and <code>Administrator</code> permissions, and <code>Admin</code>, <code>Moderator</code>, <code>SubModerator</code> and <code>Member</code> roles have to be <a href="/config">configured</a>.
                        </p>
                        <p>
                            &nbsp; These permissions can be overriden for each command separately using the <code>!permissions</code> command and commands can also be blocked from specific channels, or allowed to be used in specific channels.
                        </p>
                    </div>

                    <h1 class="features-h1">Commands ~ Basic</h1>
                    <div class="features-indent">
                        <h2>help</h2>
                        <table class="command">
                            <tr>
                                <td>Description</td>
                                <td>Display a list of commands.</td>
                            </tr>
                            <tr>
                                <td>Parameters</td>
                                <td>Use without parameters to get the list, or use it with <code>regex</code> parameter to search for specific commands.</td>
                            </tr>
                            <tr>
                                <td>Permissions</td>
                                <td>Everyone</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--div class="features-indent">
                    <h2>patchnotes</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Display some info about latest updates.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>subscribe</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Subscribe to patchnotes and maintenance notifications (you will be PMed these)</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>unsubscribe</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Unsubscribe from the patchnotes and maintenance notifications.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div-->

                <h1 class="features-h1">Commands ~ Admin</h1>
                <div class="features-indent">
                    <h2>shoo</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Botwinder will leave your server.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>ServerOwner</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>createRole</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Create a new role with no permissions and return its <code>id</code>.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>name</code> of the role.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>getRole</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Get a name, id and colour of a role.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>name</code> or <code>id</code> of a role.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <!--div class="features-indent">
                    <h2>mentionMembersOf</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Display a list of members of a role. <i>(This will mention their names - use in closed channel, or use standard <code>membersOf</code>)</i></td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>name</code> or <code>id</code> of a role.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div-->
                <div class="features-indent">
                    <h2>promoteEveryone</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Assign a role to everyone in your server. Please ensure correct permisison hierarchy before using this command.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>ID</code> of a role. This does not accept name of the role.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>demoteEveryone</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Remove a role from everyone in your server. Please ensure correct permission hierarchy before using this command.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>ID</code> of a role. This does not accept name of the role.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <!--div class="features-indent">
                    <h2>channels</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>List of Channels on this server, and their IDs.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                --><div class="features-indent">
                    <h2>alias</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Manage command aliases.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>Use the command without parameters for more details</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>permissions</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Configure permission groups for every built-in command. Use without parameters for help.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>Use the command without parameters for more details</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>ServerOwner only!</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>cmdChannelBlacklist</h2>
                    <table class="command">
                        <tr>
                            <td>Alias</td>
                            <td><code>cmdChannelBlock</code></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>Block a command from certain channels. <i>(This is mutually exclusive with the whitelist)</i></td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>CommandID</code>, <code>add</code> or <code>remove</code>, and <code>ChannelID</code> (that long number)</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>cmdChannelWhitelist</h2>
                    <table class="command">
                        <tr>
                            <td>Alias</td>
                            <td><code>cmdChannelAllow</code></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>Allow a command only in certain channels. <i>(This is mutually exclusive with the blacklist)</i></td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>CommandID</code>, <code>add</code> or <code>remove</code>, and <code>ChannelID</code> (that long number)</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>cmdResetRestrictions</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Reset restrictions placed on a command by the above <code>cmdChannel*</code> commands.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>CommandID</code></td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>deleteRequest</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Set a command to have the issuing request message deleted automatically.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>CommandID</code> (that long number) and <code>true</code> or <code>false</code>, whether set it to delete or not.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>operations</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Display info about all queued or running operations on your server. These are for example <code>nuke</code> or <code>archive</code>.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>cancel</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Cancel queued or running operation - use in the same channel.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>Name of the command to cancel (nuke, archive, etc...)</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>
                <!--div class="features-indent">
                    <h2>archive</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>This will pull the whole channel history and save it as a text file. There is a limit of <code>50 000</code> messages for safety reasons, but you can poke Rhea, she can <a href="img/archive.png" target="_">archive without limits</a>. (..because this operation should be observed, as it is really intense on memory.)</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Default usage without parameters will result in log formatting with user IDs and full timestamps. Use as <code>archive nice</code> to use nice formatting for people.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </di--v>
                <div class="features-indent">
                    <h2>nuke</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Nukes the whole channel (delets all the messages) You can also mention a user to delete all of their messages. (Only within the last two weeks.)</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None, optional <code>@user</code> mentions or IDs</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                <!--div class="features-indent">
                    <h2>hideChannel</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Hide or un-hide the current channel by denying or allowing the Read Messages permission for everyone.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use with <code>silent</code> parameter for silent execution, or none for standard response.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div-->
                <div class="features-indent">
                    <h2>verify</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>This command will either send verification info to the user, or verify them manually if used by an Admin.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>See the <a href="/config">config</a> page for more info.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Admin</td>
                        </tr>
                    </table>
                </div>

                <h1 class="features-h1">Commands ~ Moderator</h1>
                <!--div class="features-indent">
                    <h2>timer</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Set up scheduled or recurring messages for specific channel, or even execute scheduled commands.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use the command without parameters for more details</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Moderator</td>
                    </tr>
                    </table>
                </div-->
                <div class="features-indent">
                    <h2>membersOf</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Display a list of members of a role.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>name</code> or <code>id</code> of a role.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Moderator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>clear</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Deletes specified amount of messages (within two weeks.) If you mention someone as well, it will remove only their messages.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>[@users] n</code> - optional <code>@user</code> mentions or ID's (this parameter(s) has to be first, if specified.) And mandatory <code>n</code> parameter, the count of how many messages to remove.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                        <tr>
                            <td>Example</td>
                            <td><code>!clear 3 @user</code> - removes the last three messages sent by the user.</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>op</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>_op_ yourself to be able to use <code>mute</code>, <code>kick</code> or <code>ban</code> commands. <b>(Only if <a href="/config">configured</a>!)</b></td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Moderator (& SubModerator - will apply to <code>mute</code> only)</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>kick</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Kick a user out of your server. This requires worded description why did you kick them out - they will receive this message via PM (and it will be added to the system as a warning) Example PM: <code>Hello! I regret to inform you, that you have been **kicked out of the Elite Dangerous server** for the following reason: ......... _(You can rejoin the server in a few minutes.)_</code></td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user reason</code> where <code>@user</code> = user mention or id; <code>reason</code> = worded description why did you kick them out.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Moderator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>ban</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>This command can ban a User permanently, or for specific amount of time, and it can do the same with people, who are not on the server yet. (It will ban them as soon as they join.) This requires worded description why did you ban them - they will receive this via PM (and it will be added to the system as a warning) Example PM: <code>Hello! I regret to inform you, that you have been **banned {for x hour(s) /or/ permanently} on the Elite Dangerous server** for the following reason: .........</code></td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user time reason</code> where <code>@user</code> = user mention or id; <code>time</code> = duration of the ban (e.g. <code>7d</code> or <code>12h</code> or <code>0</code> for permanent.); <code>reason</code> = worded description why did you ban them.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Moderator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>silentBan</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>The same as <code>ban</code>, but it will not send the <code>reason</code> PM. (Hence silent..)</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user time reason</code> where <code>@user</code> = user mention or id; <code>time</code> = duration of the ban (e.g. <code>7d</code> or <code>12h</code> or <code>0</code> for permanent.) <code>reason</code> = worded description why did you ban them.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Moderator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>purgeBan</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>The same as <code>ban</code>, but it will also delete their messages in last 24 hours.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user time reason</code> where <code>@user</code> = user mention or id; <code>time</code> = duration of the ban (e.g. <code>7d</code> or <code>12h</code> or <code>0</code> for permanent.) <code>reason</code> = worded description why did you ban them.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Moderator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>quickBan</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Quickly ban someone using pre-configured reason and duration, it also removes their messages. (This command has to be first <a href="/config">configured</a>.)</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user</code> user mention or id; You can mention several people at once.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Moderator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>unban</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Correctly unban a user.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user</code> user mention or id</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Moderator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>muteChannel</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Temporarily mute the current channel. (This may block the moderators as well if they don't have explicitly higher <code>SendMessages</code> permissions than <code>@everyone</code>)</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>time</code> - duration of the mute (e.g. `7d` or `12h` or `1h30m` - without spaces.)</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Moderator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>unmuteChannel</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Unmute previously muted channel.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Moderator</td>
                        </tr>
                    </table>
                </div>

                <h1 class="features-h1">Commands ~ SubModerator</h1>
                <div class="features-indent">
                    <h2>mute</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Temporarily mute mentioned members from the text chat. This command has to be configured in the <a href="/config">configuration</a>.
                            </td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user time</code> - where <code>@user</code> = user mention(s) or ID(s); <code>time</code> = = duration of the mute (e.g. `7d` or `12h` or `1h30m` - without spaces.)</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>unmute</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Unmute previously muted members.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user</code> - user mention(s) or ID(s)</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>tempChannel</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Creates a temporary voice channel. This channel will be destroyed when it becomes empty, with grace period of three minutes since it's creation. <i>(You can make it public using <code>!permissions</code> or use a <code>!tc</code> alias)</i></td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>Name of the new channel.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>permit</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Permit mentioned members to post links and spam, a single message within three minutes will not be removed. (This depends on antispam <a href="/config">configuration</a>)</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user</code> mention of a member (or multiple mentions) to permit.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <!--div class="features-indent">
                    <h2>stats</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Display some info about this server and some numbers.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator</td>
                    </tr>
                    </table>
                </div-->
                <div class="features-indent">
                    <h2>whois</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Search for a User on your server (they must be on your server)</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user</code> mention, name or ID.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>find</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Find a User in the database. This will search in all known usernames and nicknames (People can change their name, this will search their previous names as well.)</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>Use with any keywords you like.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>issueWarning</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Send a PM to a <code>@user</code>, with a warning message, and note this in the database.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user warning message</code>; where <code>@user</code> is a user mention or id and you can add the same warning to multiple people, just mention them all.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>addWarning</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Take a note about <code>@user</code>, what have they done this time... <i>(This does not PM the user anything.)</i></td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user warning message</code>; where <code>@user</code> is a user mention or id and you can add the same warning to multiple people, just mention them all.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>removeWarning</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Remove the last created warning.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user</code> mention or ID (or multiple mentions)</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>removeAllWarnings</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Remove all the warnings.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user</code> mention or ID (or multiple mentions)</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>memberRoles</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>See what Member Roles can you assign. <b>Set this up in the <a href="/config">configuration</a>.</b></td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>None.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>promote</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Assign a Member role to the user.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user role</code> where <code>@user</code> = user mention(s) or id (will accept multiple mentions at once); and <code>role</code> = the name of a role to assign.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>demote</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Remove a Member role from the user.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>@user role</code> where <code>@user</code> = user mention(s) or id (will accept multiple mentions at once); and <code>role</code> = the name of a role to remove.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>SubModerator</td>
                        </tr>
                    </table>
                </div>
                <!--div class="features-indent">
                    <h2>event</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>A system to help you run the best events.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use the command without parameters for more details</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator / Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>poll</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Open a poll, you can then vote on it using <code>vote</code> command. Limited to one poll per server.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use the command without parameters for more details</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>giveaway</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Manage a giveaway on your server with parameters start, end, or roll.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use the command without parameters for more details</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator</td>
                    </tr>
                    </table>
                </div-->

                <h1 class="features-h1">Commands ~ Everyone</h1>
                <div class="features-indent">
                    <h2>publicRoles</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Display a list of PublicRoles - Roles that anyone can <code>!join</code> or <code>!leave</code>. You can also configure groups of mutually exclusive roles (user can have only one of them) <b>Set this up in the <a href="/config">configuration</a>.</b></td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Everyone</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>join</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Join one of the PublicRoles.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>name</code> of a PublicRole that you wish to join.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Everyone</td>
                        </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>leave</h2>
                    <table class="command">
                        <tr>
                            <td>Description</td>
                            <td>Leave one of the PublicRoles.</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td><code>name</code> of a PublicRole that you wish to leave.</td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>Everyone</td>
                        </tr>
                    </table>
                </div>
                <!--div class="features-indent">
                    <h2>meeting</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Manage a meeting that will create nice logs and meeting minutes on our website. <a href="http://botwinder.info/meetings/244607894165651457/Example%20meeting">Example here.</a></td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use the command without parameters for more details</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>vote</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Vote on a poll, created and managed by the <code>poll</code> command.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use without parameters to display the poll title and options, or vote using an <code>option</code> parameter.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>g</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Participate in currently active <code>giveaway</code></td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>work</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Botwinder will keep track of your time at work (uses GMT for calculations of the month)</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use the command without parameters for more details. (You can also use this in PM.)</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>dice</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Roll a dice!</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use one of the following formats: <code>6</code> / <code>3 d20</code> / <code>15 d6 &gt;5</code> <i>(Yes, with spaces!)</i> where the <code>d</code> specifies how many sides the dice has, and the <code>&gt;</code> filters results and total count to be greater than five in this example. (You can use <code>&gt;</code>, <code>&lt;</code> or <code>=</code>)</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div-->
            </div>
            </div>
        </section>
    </section>
@endsection
