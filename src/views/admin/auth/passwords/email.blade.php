@extends('potassium::admin.auth.layout', ['url' => route('admin.password.email')])

@section('title')
    {{env("APP_NAME")}} // Récupération du mot de passe
@endsection

@section('content')
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
        <div class="notification is-success sent mt-8">
            {!!nl2br(Session::get('status'))!!}
        </div>
    @endif
@endsection
