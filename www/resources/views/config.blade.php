@extends('layouts.master')

@section('title', 'Config')

@section('content')
@inject('request', 'Illuminate\Http\Request')
<div class="container">
	@if ($request->has('error') && $request->input('error') == 'access_denied')
		<div class="col-xs-12">
			<p class="alert alert-info">
				<b>Access Denied.</b><br />
				We couldn't log you in with Discord. Try again?
			</p>
		</div>
	@endif
	<div class="col-xs-12">
		<h1>Configure Valkyrja</h1>
		<p>
			<a href="{{ $authorizationUrl }}">Log in with your Discord account.</a><br />
			We need to know what servers you can configure - required permissions to configure Valkyrja are <code>Administrator</code> & <code>ManageServer</code>.
		</p>
		<p><i>By the way, you need Valkyrja on your server before you can configure anything. <a href="/invite">Invite the bot!</a></i></p>
	</div>
</div>
@endsection
