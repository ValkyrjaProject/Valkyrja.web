@extends('layouts.master')

@section('title', 'Invite Botwinder')

@section('content')
<section class="container">
    {{--<div class="col-xs-12">
        <div class="row">
            <h1>Botwinder</h1>
            <div>
                <img src="/img/jefi-discord.jpg" alt="Botwinder" class="square rounded-circle img-thumbnail" width="150px">
            </div>
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
<section class="main-body blue">--}}
    <section class="container">
        <div class="col-xs-12">
            <div class="row">
                <h1>Botwinder Mk.III</h1>
                {{--<div>
                    <img src="/img/jefi-discord.jpg" alt="Botwinder" class="square rounded-circle img-thumbnail" width="150px">
                </div>--}}
            </div>
            <p class="row">
              You can use Botwinder Mk.III for <b>one day trial period</b>, after which the bot will automatically leave your server if you do not meet at least <b>one of the requirements</b> below.
              <br />
              <b>Requirements</b> <i>(one of)</i><ul>
                <li><a href="https://www.patreon.com/Botwinder" target="_blank">Patreon</a> Subscribers</li><ul>
                  <li>$10 - Unlimited in any way.</li>
                  <li>$3 - Antispam, Karma and Experience (as performance heavy) features are disabled at this level.</li>
                </ul>
                <li>Handpicked partners - unique communities with worthy cause, such as open source projects, Linux or other geeky places, and any Elite Dangerous server. <u>No gaming communities!</u> <i>(talk to <a href="/team">Rhea</a>)</i></li>
              </ul>
            </p>
            <div class="row">
                <a href="http://invite.botwinder.info" class="external">
                    <button class="btn btn-primary">Invite</button>
                </a>
            </div>
            <br />
            <p class="row">
              <b>Patreon info for subscribers:</b><ul>
                <li>Please make sure to contact <code>Rhea#1234</code> with your patreon details (patreon username or email)</li>
                <li>Remember that the bot is bound to servers you own, or one extra server you explicitly ask for (Talk to Rhea - PM her the <code>Server ID</code>)</li>
              </ul>
              <i>Don't forget to set-up permissions and role hierarchy!</i>
            </p>
        </div>
    </section>
</section>
@endsection
