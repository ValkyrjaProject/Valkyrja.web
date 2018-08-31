@extends('layouts.master')

@section('title', 'Edit Config')

@section('content')
    <section class="container">
        <edit-guild guild-id="{{$serverId}}"></edit-guild>
    </section>
@endsection