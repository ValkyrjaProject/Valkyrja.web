@extends('layouts.master')

@section('title', 'Invite Botwinder')

@section('content')
<section class="container">
    <div class="col-xs-12">
        <div class="row">
            <h1>Botwinder</h1>
            {{--<div>
                <img src="/img/jefi-discord.jpg" alt="Botwinder" class="square rounded-circle img-thumbnail" width="150px">
            </div>--}}
        </div>
        <p class="row">
          Large scale bot where you may experience an occasional lag. We are constantly working on improving the infrastructure to cope with the load.
          <br />
          Both bots are identical, and there are no special features in either one.
        </p><br />
        <div class="row">
            <a href="http://invite.botwinder.info" class="external">
                <button class="btn btn-primary">Invite</button>
            </a>
        </div>
    </div>
</section>
<section class="main-body blue">
    <section class="container">
        <div class="col-xs-12">
            <div class="row">
                <h1>Botwinder Mk.II</h1>
                {{--<div>
                    <img src="/img/jefi-discord.jpg" alt="Botwinder" class="square rounded-circle img-thumbnail" width="150px">
                </div>--}}
            </div>
            <p class="row">
              Small scale bot for partners only. If you invite the Botwinder Mk.II to your server while you do not meet at least <b>one</b> of the requirements below, it will automatically leave within a few minutes.
              <br />
              <b>Requirements:</b><ul>
                <li><a href="https://www.patreon.com/Botwinder" target="_blank">Patreon</a> Contributors at 3$ or more</li>
                <li><a href="https://discordapp.com/partners" target="_blank">Discord Partner</a> with VIP location</li>
                <li>Handpicked partners with worthy cause <i>(talk to our <a href="/team">PR team</a>)</i></li>
                <li>Communities of at least 2000 members</li>
              </ul>
            </p>
            <div class="row">
                <a href="http://mk2.botwinder.info" class="external">
                    <button class="btn btn-primary">Invite</button>
                </a>
            </div>
            <p class="row">
              Please make sure to contact <code>Rhea#0321</code> with your patreon details before you transition to Mk.II (Large communities or Discord Partners do not have to confirm anything.)
              <br />
              After you get the green light, you can invite the Mk.II bot. The Mk.I will leave on his own (or you can also kick it out)
              <br />
              Remember that the bot is bound to servers you own, or one extra server you explicitly ask for (Talk to Rhea - PM her the <code>Server ID</code>)
              <br />
              <i>Don't forget to set-up permissions and role hierarchy!</i>
            </p>
        </div>
    </section>
</section>
@endsection
