@extends('potassium::admin.auth.layout', ['url' => route('admin.password.update')])

@section('title')
    {{env("APP_NAME")}} // Récupération du mot de passe
@endsection

@section('content')
    <input type="hidden" name="token" value="{{ $token }}">

    <label for="email" class="label">Adresse email</label>
    <p class="control has-icons-right">
        <input class="input" name="email" type="text" autofocus value="{{request('user') ?? old('email')}}">
        <span class="icon is-right">
            <i class="fa fa-at"></i>
        </span>
        @if ($errors->has('email'))
            <span class="help is-danger">{{$errors->first('email')}}</span>
        @endif
    </p>

    <label for="password" class="label">Mot de passe</label>
    <p class="control has-icons-right">
        <input class="input" type="password" name="password" type="text">
        <span class="icon is-right">
            <i class="fa fa-lock"></i>
        </span>
        @if ($errors->has('password'))
            <span class="help is-danger">{{$errors->first('password')}}</span>
        @endif
    </p>

    <label for="password" class="label">Confirmation du mot de passe</label>
    <p class="control has-icons-right">
        <input class="input" type="password" name="password_confirmation" type="text">
        <span class="icon is-right">
            <i class="fa fa-lock"></i>
        </span>
        @if ($errors->has('password'))
            <span class="help is-danger">{{$errors->first('password')}}</span>
        @endif
    </p>

    <button type="submit" class="button submit is-outlined">
        <span>Réinitialiser le mot de passe</span>
    </button>
@endsection
