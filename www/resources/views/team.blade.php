@extends('layouts.master')

@section('title', 'Team')

@section('content')
<div class="container">
    <div class="col-md-7 col-lg-5">
        <img src="/img/sunset.jpg" alt="Rhea and SpyTec" class="image-left"/>
    </div>
    <div class="col-md-5 col-lg-7">
        <div class="row team-member padding-bottom">
            <div class="profile">
                <img class="avatar" src="img/team-rhea.jpg" />
                <p class="labels">
                <span class="name">Rhea</span>
                <br />Project and Code Lead</p>
            </div>
            <p><i>
                Former game programmer, player and streamer, an active contributor to gaming and open source communities. Currently wearing her RedHat, playing with the delicate C# letters in Linux.
            </i></p>
            <span class="email"><a href="emailto:rhea@botwinder.info">rhea@botwinder.info</a></span>
            <div class="icons spaced">
                <a href="http://rhea-ayase.eu"><img src="/img/external.png" alt="Rhea's website"></a>
                <a href="https://github.com/RheaAyase"><img src="/img/github.png" alt="github.com/RheaAyase"></a>
                <a href="https://twitter.com/RheaAyase"><img src="/img/twitter.png" alt="twitter.com/RheaAyase"></a>
                <a href="https://twitch.tv/RheaAyase"><img src="/img/twitch.png" alt="twitch.tv/RheaAyase"></a>
                <a href="https://youtube.com/RheaAyase"><img src="/img/youtube.png" alt="youtube.com/RheaAyase"></a>
                <a href="https://fedoraproject.org/wiki/User:Rhea"><img src="/img/fedora.png" alt="fedoraproject.org"></a>
            </div>
        </div>
        <div class="row team-member">
            <div class="profile">
                <img class="avatar" src="img/team-spytec.jpg" />
                <p class="labels">
                <span class="name">SpyTec</span>
                <br />WebDev Lead</p>
            </div>
            <p><i>
                Crafts websites. Also a professional slacker.
            </i></p>
            <span class="email"><a href="emailto:spytec@botwinder.info">spytec@botwinder.info</a></span>
            <div class="icons spaced">
                <a href="http://www.edassets.org"><img src="/img/external.png" alt="SpyTec's EDAssets website"></a>
                <a href="https://github.com/SpyTec"><img src="/img/github.png" alt="github.com/SpyTec"></a>
                <a href="https://twitter.com/SpyTec13"><img src="/img/twitter.png" alt="twitter.com/SpyTec13"></a>
            </div>
        </div>
    </div>
</div>
<section class="main-body blue">
    <section class="container team-table">
        <div class="row">
            <h1 class="cell">Dev Team</h1>
            <h1 class="cell">Public Relations</h1>
        </div>
        <div class="row">
            <!-- freiheit -->
            <div class="team-member cell padding-bottom">
                <div class="profile">
                    <img class="avatar" src="img/team-freiheit.jpg" />
                    <p class="labels">
                    <span class="name">freiheit</span>
                    <br />Consultant</p>
                </div>
                <p><i>
                    He's just this guy, you know?
                </i></p>
                <span class="email"><a href="emailto:freiheit@botwinder.info">freiheit@botwinder.info</a></span>
                <div class="icons spaced">
                    <a href="http://eric.eisenhart.com"><img src="/img/external.png" alt="freiheit's website"></a>
                    <a href="https://github.com/freiheit"><img src="/img/github.png" alt="github.com/freiheit"></a>
                    <a href="https://twitter.com/freiheit"><img src="/img/twitter.png" alt="twitter.com/freiheit"></a>
                </div>
            </div>
            <!-- Freud -->
            <!--div class="team-member cell padding-bottom">
                <div class="profile">
                    <img class="avatar" src="img/team-freud.jpg" />
                    <p class="labels">
                    <span class="name">Freud</span>
                    <br />PR</p>
                </div>
                <p><i>
                    The abused one.. Talking to people, in the name of the Jefi.
                </i></p>
                <span class="email"><a href="emailto:freud@botwinder.info">freud@botwinder.info</a></span>
                <div class="icons spaced">
                    <a href="https://twitter.com/RSN_Freud"><img src="/img/twitter.png" alt="twitter.com/RSN_Freud"></a>
                </div>
            </div-->
        </div>
        <div class="row">
            <h1 class="cell">Support Team</h1>
            <h1 class="cell">&nbsp;</h1>
        </div>
        <div class="row">
            <!-- MasterChief -->
            <div class="team-member cell padding-bottom">
                <div class="profile">
                    <img class="avatar" src="img/team-masterchief.jpg" />
                    <p class="labels">
                    <span class="name">MasterChief_John-117</span>
                    <br />Support</p>
                </div>
                <p><i>
                    Some weirdo who decided Botwinder seemed cool and wanted to help out.
                </i></p>
                <span class="email"><a href="emailto:masterchief_john-117@botwinder.info">masterchief_john-117@botwinder.info</a></span>
            </div>
            <!-- Levi -->
            <!--div class="team-member cell padding-bottom">
                <div class="profile">
                    <img class="avatar" src="img/team-levi.jpg" />
                    <p class="labels">
                    <span class="name">Levi Brunette</span>
                    <br />Support, PR</p>
                </div>
                <p><i>
                    A junior community leader, hobbyist artist, and a trash can. Good with computers, setting things up, and fixing things when they break.
                </i></p>
                <span class="email"><a href="emailto:levi.brunette@botwinder.info">levi.brunette@botwinder.info</a></span>
                <div class="icons spaced">
                    <a href="https://steamcommunity.com/id/SuperLeboy"><img src="/img/external.png" alt="Levi's website"></a>
                    <a href="https://twitter.com/Levi_Brunette"><img src="/img/twitter.png" alt="twitter.com/Levi_Brunette"></a>
                    <a href="https://twitch.tv/LeviBrunette"><img src="/img/twitch.png" alt="twitch.tv/LeviBrunette"></a>
                    <a href="https://youtube.com/LeviBrunette"><img src="/img/youtube.png" alt="youtube.com/LeviBrunette"></a>
                </div>
            </div-->
        </div>
        <div class="row">
            <!-- TwoDog -->
            <!--div class="team-member cell">
                <div class="profile">
                    <img class="avatar" src="img/team-twodog.jpg" />
                    <p class="labels">
                    <span class="name">TwoDog</span>
                    <br />Support, PR</p>
                </div>
                <p><i>
                    Kiwi, Student, Gamer and an all around Discord Enthusiast.
                </i></p>
                <span class="email"><a href="emailto:twodog@botwinder.info">twodog@botwinder.info</a></span>
                <div class="icons spaced">
                    <a href="http://twodog.pro"><img src="/img/external.png" alt="TwoDog's website"></a>
                    <a href="https://twitter.com/TheTwoDog_"><img src="/img/twitter.png" alt="twitter.com/TheTwoDog_"></a>
                </div>
            </div-->
        </div>
    </section>
</section>
@endsection
