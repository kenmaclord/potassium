@extends('auth.layout')

@section('title')
{{env("APP_NAME")}} // Récupération du mot de passe
@endsection

@section('content')
<div class="container" id="auth">
    <div class="column is-6 is-offset-3">
        <form class="loginForm" action="{{ url('/password/email') }}" method="POST">
            {{csrf_field()}}

            <div class="logo">
                {{-- <img src="logo.svg" alt=""> --}}
                <h1>{{ucwords(env('APP_NAME'))}}</h1>
            </div>

            <label for="email" class="label">Adresse email</label>

            <p class="control has-icons-right">
                <input class="input" autofocus name="email" type="text">
                <span class="icon is-right">
                    <i class="fa fa-at"></i>
                </span>
                @if ($errors->has('email'))
                    <span class="help is-danger">{{$errors->first('email')}}</span>
                @endif
            </p>

            <button type="submit" class="button submit is-primary is-outlined">
                <span>Envoyer une demande de réinitialisation</span>
            </button>

            @if(Session::has('status'))
                <div class="notification is-success sent">
                    {!!nl2br(Session::get('status'))!!}
                </div>
            @endif
        </form>

    </div>
</div>
@endsection
