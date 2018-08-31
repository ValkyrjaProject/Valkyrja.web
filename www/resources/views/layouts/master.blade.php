<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.header')
    @section('header')
        {{--<script type="application/javascript">
            window.__INITIAL_STATE__ = []
        </script>--}}
    @show
</head>
<body>
@include('partials.navigation')
<section id="app" class="fluid-container has-background-primary">
    @if (session('messages') && is_array(session('messages')))
        <div class="container">
            @foreach (session('messages') as $message)
                <p class="alert alert-info">{{ $message }}</p>
            @endforeach
        </div>
    @elseif (isset($errors) && count($errors) > 0)
        <div class="container">
            <div class="alert alert-danger">
                <h1 class="alert-danger">Errors</h1>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <section class="section">
        @yield('content')
    </section>
</section>
<footer class="footer">
    <section class="container">
        <div class="content has-text-centered gray-links">
            <small class="x-small">
                <div class="copyright">© 2016-{{ date("Y") }} Rhea & SpyTec</div>
                <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">Creative Commons
                    Attribution-NonCommercial-NoDerivatives 4.0 International License</a>
            </small>
        </div>
    </section>
</footer>
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"
        integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"
        integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB"
        crossorigin="anonymous"></script>--}}
<script src="{{ mix('/js/app.js') }}"></script>
@include('partials.google-analytics', ['token' => 'UA-87348259-1'])
</body>
</html>
