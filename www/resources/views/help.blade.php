@extends('layouts.master')

@section('title', 'Help')

@section('content')
<section class="container">
    <div class="col-xs-12">
        <h1>Need Help?</h1>
        <p>
            Get in touch with us on <b><a href="http://support.botwinder.info" target="_blank">our Discord server</a></b>, where you can ask any questions and our <b>Support team</b> or Developers will try to answer them with a smile <b>=)</b>
        </p>
        <p>
            <b>Email contacts:</b>
            <ul>
                <li>General: <span class="email"><a href="emailto:team@botwinder.info">team@botwinder.info</a></span></li>
                <li>Support: <span class="email"><a href="emailto:support@botwinder.info">support@botwinder.info</a></span></li>
                <li>Public Relations: <span class="email"><a href="emailto:pr@botwinder.info">pr@botwinder.info</a></span></li>
            </ul>
        </p>
        <p>
            Please do not PM individual team members with the only exception being <code>Rhea#0321</code>
            <br />
            You can also find <code>Rhea</code> on the <a href="https://webchat.freenode.net/?channels=#botwinder" target="_blank">freenode irc</a>, but please note that she won't respond anywhere nearly as fast as our support team on Discord, she is on IRC only at work (European hours)
        </p>
    </div>
</section>
@endsection
