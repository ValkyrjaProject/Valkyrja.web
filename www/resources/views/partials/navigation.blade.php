<header class="navbar" id="navigation">
    <nav class="container" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item {{ Request::path() == '/' ? "is-active" : "" }}" href="/">
                <img src="{{ url('/img/jefi-small.png') }}" alt="Home"/>
                Home
            </a>
            <a role="button" class="navbar-burger" data-target="navMenu" aria-label="menu" aria-expanded="false">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="navMenu" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item {{ Helper::setActive('docs') }}" href="{{ url('docs') }}">
                    <img class="is-hidden-touch" src="{{ asset('/img/book.png') }}" alt="Docs"/>
                    Docs
                </a>
                <a class="navbar-item {{ Helper::setActive('config') }}" href="{{ url('config') }}">
                    <img class="is-hidden-touch" src="{{ asset('/img/wrench.png') }}" alt="Config"/>
                    Config
                </a>
                <a class="navbar-item {{ Helper::setActive('invite') }}" href="{{ url('invite') }}">
                    <img class="is-hidden-touch" src="{{ asset('/img/rocket.png') }}" alt="Invite"/>
                    Invite
                </a>
                <a class="navbar-item {{ Helper::setActive('updates') }}" href="{{ url('updates') }}">
                    <img class="is-hidden-touch" src="{{ asset('/img/updates.png') }}" alt="Updates"/>
                    Updates
                </a>
                <a class="navbar-item {{ Helper::setActive('help') }}" href="{{ url('help') }}">
                    <img class="is-hidden-touch" src="{{ asset('/img/discord-small.png') }}" alt="Help"/>
                    Help
                </a>
                <a class="navbar-item external" href="//status.botwinder.info">
                    <img class="is-hidden-touch" src="{{ asset('/img/satellite.png') }}" alt="Status"/>
                    Status
                </a>
                <a class="navbar-item {{ Helper::setActive('team') }}" href="{{ url('team') }}">
                    <img class="is-hidden-touch" src="{{ asset('/img/heart.png') }}" alt="The Team"/>
                    The&nbsp;Team
                </a>
            </div>

            <div class="navbar-end">
                <user-navigation></user-navigation>
            </div>
        </div>
    </nav>
</header>
