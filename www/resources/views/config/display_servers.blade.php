@extends('layouts.master')

@section('title', 'Config')

@section('content')
<div class="container">
	<div class="col-xs-12">
		<h1>Select server</h1>
		<p>
			Hi {{ $user->username }}!<br />
			Required permissions to be able to configure Botwinder are <code>Administrator</code> & <code>ManageServer</code>, and you need to already have it on your server, before you can configure anything. <a href="/invite">Invite the bot!</a></p>
		</p>
			Which server would you like to configure?
		</p>
		<form action="{{ url('config/edit') }}" class="form-inline" method="post">
			<select class="form-control" name="serverId">
				@foreach ($guilds as $guild)
					<option value="{{ $guild->id }}">{{ $guild->name }}</option>
				@endforeach
			</select>
			<input type="hidden" name="userId" value="{{ $user->id }}">
			{{ csrf_field() }}
			<input type="submit" class="btn btn-primary" value="Select server">
			<a href="/config/logout" class="btn btn-danger">Logout</a>
		</form>
		</p>
	</div>
</div>
@endsection
