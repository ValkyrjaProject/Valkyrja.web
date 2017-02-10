@extends('layouts.master')

@section('title', 'Meetings')

@section('content')
    <div class="container">
        <div class="col-xs-12">
            <h1>Select a meeting</h1>
            <form action="{{ url(url()->current().'/meeting') }}" class="form-inline" method="get">
                <select class="form-control" name="date">
                    @foreach ($meetings as $meeting)
                        <option value="{{ $meeting }}">{{ $meeting }}</option>
                    @endforeach
                </select>
                <input type="submit" class="btn btn-primary" value="Select meeting">
            </form>
        </div>
    </div>
@endsection
