@extends('layouts.master')

@section('title', 'Features')

@section('content')
<section data-sticky-container class="container">
    <section class="col-sm-3 hidden-sm-down" style="position: relative;">
        <div class="scrollspy">
            <nav class="nav nav-stacked" id="toc" data-toggle="toc"></nav>
        </div>
    </section>
    <section class="nav container col-sm-9 scrollspy-elements" style="position:relative;">
        <div class="row col-xs-12">
            <div>
                <h1>Open Source</h1>
                <div class="features-indent">
                    Valkyrja is Open Source Software under highly permissive MIT license, contribution is most welcome.
                    </br>
                    We also offer a Modmail bot available for self-hosting, and hosted in our infrastructure for our <a href="https://github.com/sponsors/RheaAyase">GitHub</a> or <a href="https://www.patreon.com/ValkyrjaProject">Patreon</a> Subscribers and Partners.
                    </br>
                    <a href="https://github.com/ValkyrjaProject">github.com/ValkyrjaProject</a>
                </div>
                <h1>Contribution</h1>
                <p>
                    Any contribution is most welcome. This could be from code, through artwork, proofreading, to testing and reporting bugs. Or even suggesting new features or improvements!
                    <!--Last but not least, financial contribution is also welcome - while our hosted instance of Valkyrja is free for everyone, it requires a $10 subscription to access power-hungry and non-essential features (Antispam, Profiles, Karma and Experience) on <a href="https://github.com/sponsors/RheaAyase">GitHub</a> or <a href="https://www.patreon.com/ValkyrjaProject" target="_blank">Patreon</a> - a monthly donation towards the cost of maintaining the servers.-->
                </p>
                <h1>Disclaimer</h1>
                <p>
                    We recommend that the server owners link to, or copy and modify, this disclaimer about how they use the user data for moderation: <a href="http://radka.dev/disclaimer">http://radka.dev/disclaimer</a>
                </p>
                <h1>Key Features</h1>
                <p>
                    These are some features that are not fully covered by simple commands:
                    <ul>
                        <li><b>Encrypted Database</b> containing notes about users, all known usernames and nicknames, with good search based on keyword, userid or mention.</li>
                        <li>Powerful <b>permission</b> system using which you can tweak every command to your liking. Change who can execut commands, in which channels, create aliases, or even set commands to self-destruct in the chat.</li>
                        <li><b>Customizable Localisation</b> - you can change messages that Valkyrja sends in response to commands or events. You can even use random responses.</li>
                        <li><b>Custom commands</b> that can send messages or very complex <b>embeds</b> in the chat, or via PM to the user, or people mentioned. With optional permission to ping roles as well. The above mentioned permission system and all the tweaks apply to these as well. Using this combination you can create a custom command with which only select people can mention certain roles!</li>
                        <li>Force people to read the rules with the hidden code <b>verification system</b>, where the bot will send a user the rules, with hidden code, which they have to find and send back to get a member role assigned. If that's not your cup of beverage, you're welcome to many other forms of verification.</li>
                        <li>Collect <b>statistics</b> about how many people joined, got kicked out by antispam, or passed verification.</li>
                        <li>All the typical administration and moderation tools are available and highly customizable.</li>
                        <li>Did you like <b>temporary channels</b> on TeamSpeak? No problem, we've got you. (<code>!tmp</code>)</li>
                        <li>Last but not least, we put a lot of emphasis on <b>security</b>. No server has access to any data from any other server, and no sensitive data is available to public. All the data stored on our servers is encrypted while only one person in the world has access to this server. Authors are also part of this trust - both the bot developer and the web developer are Red Hat engineers with decent amount of experience working in their respective fields.</li>
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
                <div class="features-indent">
                    <h2>man</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Print a detailed manual page (embed) for a specific command.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>CommandId - Name of the command.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>patchnotes</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Display some info about latest updates to the project.</td>
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
                <!--div class="features-indent">
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
                <!--div class="features-indent">
                    <h2>shoo</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Valkyrja will leave your server.</td>
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
                </div-->
                <div class="features-indent">
                    <h2>cheatsheet</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Send an embed cheatsheet with various moderation commands and pin it.</td>
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
                    <h2>embed</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Build an embed.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use without arguments for help.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>addEmoji</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Add an emoji reaction to a message.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>&lt;messageId&gt; &lt;emojis&gt;</code> - ID of the message (in the current channel); and Emojis that will be added as a reaction.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>stats</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Display join/verification stats.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>&gt;from&lt; [to]</code> dates (mandatory <code>from/since</code> optional <code>to</code>)</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
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
                    <h2>createRoles</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Create roles with specified names.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>List of whitespace delimited <code>names</code>, use quotes to use spaces.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>createPublicRoles</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Create public roles with specified names.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>The first argument will be used as a name for the new role <code>group</code>, followed by a list of whitespace delimited <code>names</code>, use quotes to use spaces.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>createColourRoles</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Create 9 roles with various colours, you can find emoji representations of these colours in Valhalla - the Valkyrja support server. Use case - <a href="img/colourReactions.png">reaction assigned colour roles</a> </td>
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
                    <h2>createTempRole</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Create a role with specified name, which will be destroyed after specified time.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>name time</code> name of the role and the when to delete it, in number of days or hours from now (e.g. <code>7d</code> or <code>12h</code> or <code>1d12h</code>)</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>createTempPublicRole</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Create a <b>public</b> role with specified name, which will be destroyed after specified time.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>name time</code> name of the role and the when to delete it, in number of days or hours from now (e.g. <code>7d</code> or <code>12h</code> or <code>1d12h</code>)</td>
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
                    <h2>countWithoutRoles</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Count how many users do not have any role.</td>
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
                    <h2>kickWithoutRoles</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Kick all the users who do not have any role. Know what you're doing!</td>
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
                    <h2>prune</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Kicks out all the inactive members.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Use the <code>manual</code> page command to see the details.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>ServerOwner</td>
                    </tr>
                    </table>
                </div>
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
                    <h2>listPermissions</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>ServerOwner only!</td>
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
                        <td><code>CommandID</code> and <code>true</code> or <code>false</code>, whether set it to delete or not.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>deleteReply</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Set a command to have the response message automatically deleted in a few seconds. NOTE that only a few commands actually support this feature!</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>CommandID</code> and <code>true</code> or <code>false</code>, whether set it to delete or not.</td>
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
                </div-->
                <div class="features-indent">
                    <h2>nuke</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Nukes the whole channel (delets all the messages) You can also mention a user to delete all of their messages. (Only within the last two weeks.)</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Optional <code>@user</code> mentions or ID's to delete only messages from specific users.</td>
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
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>mentionRole / announce</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Mention a role with a message.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>name</code> of a role, followed by your message.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>unverify</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Remove verified status from someone.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>User mentions or IDs</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Admin</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>removeStreamPermission / announce</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Removes the <code>Go Live</code> permission from all the roles. This is a command to mittigate release of a new enabled-by-default Discord feature.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None.</td>
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
                        <td>Moderator (&amp;SubModerator - will apply to <code>mute</code> only)</td>
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
                    <h2>silentban</h2>
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
                    <h2>purgeban</h2>
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
                    <h2>quickban</h2>
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
                    <h2>addQuote</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Add a new quote! Use with a username or mention as the first parameter, and the text as second. (Or you can just use a message ID.)</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>messageID</code> or <code>username text</code></td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>removeQuote</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Remove the last created quote, or specify ID to be removed.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None or <code>ID</code> of a quote</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>slow</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Enable or disable slowmode in the current channel.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>A number specifying message interval in seconds (or use time quantifiers s, m, h or d - e.g. <code>1m30s</code>)</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator</td>
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
                        <td><code>&lt;n&gt; [@users]</code> - optional <code>@user</code> mentions or ID's (this parameter(s) has to be last, if specified.) And mandatory <code>n</code> parameter, the count of how many messages to remove.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>clearRegex</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Delete only messages that match a regular expression within the last <code>n</code> messages.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>&lt;n&gt; &lt;regex&gt; [@users]</code> where you should not use any whitespace in the regular expression, use <code>\s</code> instead. (Note - ignores case.)</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator</td>
                    </tr>
                    <tr>
                        <td>Example</td>
                        <td><code>!clear 10 meme @user</code> - removes messages that match regular expression "meme" that were sent by the @user within the last 10 messagews.</td>
                    </tr>
                    </table>
                </div>
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
                        <td><code>limit name</code> (or just <code>name</code> for unlimited) - Limit how many people can enter, and name of the channel.</td>
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
                    <h2>warnings</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Display your own warnings. (Allow everyone to use this command with the <code>permissions</code> command.)</td>
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
                    <h2>listWarnedUsers</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Display a list of users with more than specific amount of warnings.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>n</code> - Threshold above which a user will be added to the output.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>listIDs</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Search and display all User IDs on this server that match a username expression.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>An expression to use for username search.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>SubModerator</td>
                    </tr>
                    </table>
                </div>
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
                    <h2>lockExp</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Locks, or unlocks, someones experience and therefore also activity role assignment.</td>
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
                        <td>See what Member Roles can you assign. <b>Set this up in the <a href="/config">configuration</a>.</td>
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
                        <td>Everyone or Admin</td>
                    </tr>
                    </table>
                </div>
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
                    <h2>roleCounts</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Display the number of people with every publicRole out of specified group.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Name of the role group.</td>
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
                <div class="features-indent">
                    <h2>lvl</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Displays your current level and how many messages (or images) would it take to reach the next.</td>
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
                    <h2>cookies</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>How many cookies do you have?</td>
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
                    <h2>nom</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Consumes one of your cookies (effectively decreasing your cookie amount by one)</td>
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
                    <h2>give</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Give a cookie to your friend (this will effectively decrease the amount of cookies you have by one, and increase theirs.)</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td><code>@user</code> mention </td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>quote</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Get a random quote, or a quote with specific id, oooor search for a quote by a specific user!</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None, or a <code>username</code> or mention, or an <code>id</code> of a specific quote.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>findQuote</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Search for a quote with a message content expression.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Expression to search for</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>memo</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Display your saved memo, or the memo of the mentioned user. (Use-cases: user profiles, hardware, etc... Create an <code>!alias</code> for your use case!)</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None, or a <code>username</code></td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>setMemo</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Overwrites previously saved message. This is per-user feature and unique between servers.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None to wipe, otherwise the message to store.</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>profile</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Display your profile. If used with a username or @mention, it will display someone else' profile.</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>None, or a <code>username</code></td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>sendProfile</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Send your profile to pre-configured <code>#introductions</code> channel.</td>
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
                    <h2>setProfile</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Set your profile. (<a href="/config">Can be configured.</a>)</td>
                    </tr>
                    <tr>
                        <td>Parameters</td>
                        <td>Configured, see <code>!setProfile --help</code></td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>Everyone</td>
                    </tr>
                    </table>
                </div>
                <div class="features-indent">
                    <h2>getProfile</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Get the source used to set your profile.</td>
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
                <!--div class="features-indent">
                    <h2>meeting</h2>
                    <table class="command">
                    <tr>
                        <td>Description</td>
                        <td>Manage a meeting that will create nice logs and meeting minutes on our website. <a href="http://valkyrja.app/meetings/244607894165651457/Example%20meeting">Example here.</a></td>
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
                        <td>Valkyrja will keep track of your time at work (uses GMT for calculations of the month)</td>
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
