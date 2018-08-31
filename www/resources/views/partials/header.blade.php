<title>@yield('title') - Botwinder.info</title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1"/>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta property="og:title" content="Botwinder Discord Bot - @yield('title')">
<meta property="og:description"
      content="Highly customizable Community Management bot, provides advanced moderation tools, advanced role assignment, temporary channels, user verification, antispam, polls, custom commands & aliases, scheduled messages & commands, and even meeting management systems. Comes with cookies!">
<meta property="og:type" content="website">
<meta property="og:image" content="http://botwinder.info/img/jefi-mirror.png">
<meta property="og:url" content="{{ Request::path() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css"
      integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">--}}
<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
<link href='https://fonts.googleapis.com/css?family=Alegreya+SC|Alegreya|Alegreya+Sans|Source+Code+Pro'
      rel='stylesheet' type='text/css'>