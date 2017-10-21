<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') - Botwinder.info</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:title" content="Botwinder Discord Bot - @yield('title')">
    <meta property="og:description" content="Highly customizable Community Management bot, provides advanced moderation tools, role assignment, temporary channels, user verification, antispam, polls, custom commands & aliases, scheduled messages & commands, and even meeting management systems. Comes with cookies!">
    <meta property="og:type" content="website">
    <meta property="og:image" content="http://botwinder.info/img/jefi-mirror.png">
    <meta property="og:url" content="{{ Request::path() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Alegreya+SC|Alegreya|Alegreya+Sans|Source+Code+Pro' rel='stylesheet' type='text/css'>
</head>
<body>
    <header>
        <nav class="container navbar">
            <button class="navbar-toggler hidden-md-up" type="button" data-toggle="collapse" data-target="#collapsingNavbar" aria-controls="collapsingNavbar" aria-expanded="false" aria-label="Toggle navigation">
                &#9776;
            </button>
            <div id="collapsingNavbar" class="collapse navbar-toggleable-sm">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a class="nav-link {{ Request::path() == '/' ? "active" : "" }}" href="/"><img class="media hidden-sm-down" src="/img/jefi-small.png" alt="Home" /><br class="hidden-sm-down" />Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ Helper::setActive('docs') }}" href="{{ url('docs') }}"><img class="media hidden-sm-down" src="/img/book.png" alt="Docs" /><br class="hidden-sm-down" />Docs</a></li>
                    <li class="nav-item"><a class="nav-link {{ Helper::setActive('config') }}" href="{{ url('config') }}"><img class="media hidden-sm-down" src="/img/wrench.png" alt="Config" /><br class="hidden-sm-down" />Config</a></li>
                    <li class="nav-item"><a class="nav-link {{ Helper::setActive('invite') }}" href="{{ url('invite') }}"><img class="media hidden-sm-down" src="/img/rocket.png" alt="Invite" /><br class="hidden-sm-down" />Invite</a></li>
                    <li class="nav-item"><a class="nav-link {{ Helper::setActive('updates') }}" href="{{ url('updates') }}"><img class="media hidden-sm-down" src="/img/updates.png" alt="Updates" /><br class="hidden-sm-down" />Updates</a></li>
                    <li class="nav-item"><a class="nav-link {{ Helper::setActive('help') }}" href="{{ url('help') }}"><img class="media hidden-sm-down" src="/img/discord-small.png" alt="Help" /><br class="hidden-sm-down" />Help</a></li>
                    <li class="nav-item"><a class="nav-link external" href="//status.botwinder.info"><img class="media hidden-sm-down" src="/img/satellite.png" alt="Status" /><br class="hidden-sm-down" />Status</a></li>
                    <li class="nav-item"><a class="nav-link {{ Helper::setActive('team') }}" href="{{ url('team') }}"><img class="media hidden-sm-down" src="/img/heart.png" alt="The Team" /><br class="hidden-sm-down" />The&nbsp;Team</a></li>
                    {{-- <li class="nav-item"><a class="nav-link {{ Helper::setActive('contribute') }}" href="/contribute"><img class="media hidden-sm-down" src="/img/cookie.png" alt="Contribute" /><br class="hidden-sm-down" />Contribute</a></li> --}}
                </ul>
            </div>
        </nav>
    </header>
    <section id="app" class="main-body">
        @if (session('messages') && is_array(session('messages')))
            <div class="container">
                @foreach (session('messages') as $message)
                    <p class="alert alert-info">{{ $message }}</p>
                @endforeach
            </div>
        @elseif (isset($errors) && count($errors) > 0)
            <div class="middle-container grid-container alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
        @endif
        @yield('content')
        <modal v-if="errors.length > 0" @close="errors = []">
            <h2 slot="header">An error occurred</h2>
            <ul slot="body">
                <li v-for="error in errors">
                    @{{ error }}
                </li>
            </ul>
        </modal>
    </section>
    <footer>
        <section class="middle-container">
            <!--div>
                <small>
                    <a href="https://www.patreon.com/Botwinder" target="_blank">Help us cover the server costs - subscribe just $1 on Patreon!</a>
                </small>
            </div-->
            <div class="gray-links">
                <small class="x-small">
                    <div class="copyright">© {{date("Y") === '2016' ? '2016' : '2016-'.date("Y") }} Rhea & SpyTec</div>
                    <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License</a>
                </small>
            </div>
        </section>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="/js/vendor.js"></script>
    <script src="{{ elixir('js/app.js') }}"></script>
    @include('layouts.subviews.google-analytics', ['token' => 'UA-87348259-1'])
</body>
</html>
