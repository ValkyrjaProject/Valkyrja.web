@extends('layouts.master')

@section('title', '403 Forbidden')

@section('content')
<div class="middle-container">
    <div class="float-middle section-big">
        <h1>Unauthorized access</h1>
        <p>
        	@if (isset($exception))
        		{{ $exception->getMessage() }}
        	@else
            You are not allowed to view this page.
          @endif
        </p>
    </div>
</div>
@endsection
