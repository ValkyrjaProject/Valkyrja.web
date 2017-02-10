@extends('layouts.master')

@section('title', 'Meeting - '.$filename)

@section('content')
    <div class="container">
        <div class="col-xs-12">
            {!! $markdown !!}
        </div>
    </div>
@endsection
