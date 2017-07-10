@extends('layouts.master')

@section('title', 'Error occurred')

@section('content')
    <div class="middle-container">
        <div class="float-middle section-big">
            <h1>An error occurred!</h1>
            <p>
                @if (isset($message))
                    {{ $message }}
                @else
                    Something went wrong. Try again and clear cache if nothing else works
                @endif
            </p>
        </div>
    </div>
@endsection
