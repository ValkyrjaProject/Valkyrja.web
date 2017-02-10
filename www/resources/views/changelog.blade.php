@extends('layouts.master')

@section('title', 'Changelog &amp; Upcoming features')
@section('content')
<section class="container">
    <div class="col-xs-12">
        <div>
            {!! $upcoming_features !!}
        </div>
    </div>
</section>
<section class="main-body blue">
    <section class="container">
        <div class="col-xs-12">
            <div>
                {!! $changelog !!}
            </div>
        </div>
    </section>
</section>
@endsection
