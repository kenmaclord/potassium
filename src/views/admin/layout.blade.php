<!DOCTYPE html>
<html class="min-h-full antialiased" lang="fr_FR">
    <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- CSRF Token -->
            <meta id="token" name="csrf-token" content="{{ csrf_token() }}">
            <meta name="api_token" content="Bearer {{ (Auth::user()) ? Auth::user()->api_token : '' }}">

            <title>@yield('title', "Backoffice")</title>

            <link rel="stylesheet" href="{{ mix('/css/admin.css')}}">
    </head>
    <body class="min-h-screen">
        <div id="admin" class="flex flex-1">
            <!-- Notifications -->
            <notification
                type="{{Session::get('status')}}"
                message="{{Session::get('message')}}">
            </notification>

            @include ('admin.app.sidebar')

            <div class="content">
                @include ('potassium::admin.app.header')

                <component is="{{$page}}" data="{{$data ?? null}}" inline-template>
                    <div class="page">
                        @yield('content')
                    </div>
                </component>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{mix('/js/admin.js')}}"></script>
    </body>
</html>
