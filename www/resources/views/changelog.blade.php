@extends('layouts.master')

@section('title', 'Changelog &amp; Upcoming features')
@section('content')
<section class="container">
    <div class="col-xs-12">
        <div>
            {!! $changelog !!}
        </div>
    </div>
</section>
@endsection
