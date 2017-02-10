@extends('layouts.master')

@section('title', '404 Page Not Found')

@section('content')
<div class="middle-container">
    <div class="float-middle section-big">
        <h1>404 not found</h1>
        <p>
        	@if (isset($exception))
        		{{ $exception->getMessage() }}
        	@else
            	This page doesn't exist! Don't try anything funny!
        	@endif
        </p>
    </div>
</div>
@endsection