@extends('errors.layout')

@section('title', 'Page Not Found')

@section('message')
    {{trans('application.not-found')}}

    <div class="link">
        <a href="/">{{trans('application.back-home')}}</a>
    </div>
@endsection
