@extends('layouts.master')

@section('title', 'Invite Botwinder')

@section('content')
<section class="container">
    {{--<!--div class="col-xs-12">
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
<section class="main-body blue"-->--}}
    <section class="container">
        <div class="col-xs-12">
            <div class="row">
                <h1>Botwinder Mk.III</h1>
                {{--<div>
                    <img src="/img/jefi-discord.jpg" alt="Botwinder" class="square rounded-circle img-thumbnail" width="150px">
                </div>--}}
            </div>
            <p class="row">
              Anyone can use our hosted instance of Botwinder for free, however only <b>Subscribers</b> will get performance-heavy Antispam and Social features (Profiles, Karma and Experience.)
            </p>
            <div class="row">
                <a href="http://invite.botwinder.info" class="external">
                    <button class="btn btn-primary">Invite</button>
                </a>
            </div>
            <p class="row">
              <br />
              <b><a href="https://www.patreon.com/Botwinder" target="_blank">Subscribe</a></b> to support the project and unlock the premium features!
              <ul>
                  <li>Powerful customizable <b>Antispam</b> that ties into moderation and logging.</li>
                  <li><b>Profiles</b> - see <a href="/img/profiles.png">this example!</a></li>
                  <li><b>Karma</b> - People receive cookies (you can change that) when they get thanked.</li>
                  <li><b>Experience</b> and levels. Send messages to gain experience, send images to gain more experience. Level up to unlock fancy roles and karma cookies!</li>
                </ul>
              Handpicked partners get premium features without subscription. Only unique communities with worthy cause qualify, such as open source projects, Linux or other geeky places. <u>No gaming communities!</u> <i>(Talk to <a href="/team">Rhea</a> about it.)</i>
            </p>
            <br />
            <p class="row">
              <b>Patreon info for subscribers:</b><ul>
                <li>Please make sure to contact <code>Rhea#1234</code> with your patreon details (patreon username or email)</li>
                <li>Remember that the bot is bound to the servers you own, or one extra server you explicitly ask for (talk to Rhea - PM her the <code>Server ID</code>)</li>
              </ul>
              <br /><i>Don't forget to set-up permissions and role hierarchy!</i>
            </p>
        </div>
    </section>
</section>
@endsection
