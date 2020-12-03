@extends('auth.layout')

@section('title')
	Connexion à l'admin
@endsection

@section('content')
<div class="container" id="auth">
	<div class="column is-6 is-offset-3">
		<form class="loginForm" action="{{route('login')}}" method="POST">
			{{csrf_field()}}

			<div class="logo">
				{{-- <img src="logo.svg" alt=""> --}}
				<h1>{{ucwords(env('APP_NAME'))}}</h1>
			</div>

			<label for="email" class="label">Adresse email</label>

			<p class="control has-icons-right">
				<input class="input" name="email" type="text" autofocus value="{{request()->user ?? old('email')}}">
				<span class="icon is-right">
					<i class="fa fa-at"></i>
				</span>
			</p>

			<label for="password" class="label">Mot de passe</label>
			<p class="control has-icons-right">
				<input class="input" type="password" name="password" :class="is-danger:error('password')" type="text">
				<span class="icon is-right">
					<i class="fa fa-lock"></i>
				</span>
				@if ($errors->has('password') || $errors->has('email'))
					<span class="help is-danger">{{$errors->first('email')}}</span>
				@endif
			</p>

			<button type="submit" class="button submit is-primary is-outlined">
				<span>Se connecter</span>
			</button>

  			<a class="forgot" href={{ url('/password/reset') }}>J'ai oublié mon mot de passe</a>
		</form>
	</div>
</div>
@endsection
