@extends('auth.layout')

@section('title')
Réinitialisation de votre mot de passe
@endsection

@section('content')
<div class="container" id="auth">
    <div class="column is-6 is-offset-3">
        <form class="loginForm" action="{{ url('/password/reset') }}" method="POST">
            {{csrf_field()}}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="logo">
                {{-- <img src="logo.svg" alt=""> --}}
                <h1>{{ucwords(env('APP_NAME'))}}</h1>
            </div>

            <label for="email" class="label">Adresse email</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="email" type="text" autofocus value="{{request()->user ?? old('email')}}">
                <span class="icon">
                    <i class="fa fa-at"></i>
                </span>
                @if ($errors->has('email'))
                    <span class="help is-danger">{{$errors->first('email')}}</span>
                @endif
            </p>

            <label for="password" class="label">Mot de passe</label>
            <p class="control has-icon has-icon-right">
                <input class="input" type="password" name="password" type="text">
                <span class="icon">
                    <i class="fa fa-lock"></i>
                </span>
                @if ($errors->has('password'))
                    <span class="help is-danger">{{$errors->first('password')}}</span>
                @endif
            </p>

            <label for="password" class="label">Confirmation du mot de passe</label>
            <p class="control has-icon has-icon-right">
                <input class="input" type="password" name="password_confirmation" type="text">
                <span class="icon">
                    <i class="fa fa-lock"></i>
                </span>
                @if ($errors->has('password'))
                    <span class="help is-danger">{{$errors->first('password')}}</span>
                @endif
            </p>

            <button type="submit" class="button submit is-primary is-outlined">
                <span>Réinitialiser le mot de passe</span>
            </button>
        </form>
    </div>
</div>
@endsection
