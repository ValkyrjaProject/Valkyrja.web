@extends('layouts.master')

@section('title', 'Config')

@section('content')
    <div class="container">
        <div class="col-xs-12">
            <display-guilds :skeleton-count="4"></display-guilds>
        </div>
    </div>
@endsection
