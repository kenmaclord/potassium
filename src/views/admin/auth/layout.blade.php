<!DOCTYPE html>
<html class="min-h-full antialiased" lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', env("APP_NAME"))</title>

        <link rel="stylesheet" href="{{mix("/css/auth.css")}}">
    </head>

    <body class="min-h-screen regular flex justify-center">
        <div id="auth" class="flex flex-col items-center pt-8" style="width: 400px">
            <div class="logo flex flex-col items-center pb-4">
                <img class="h-full" style="max-height: 100px" src="/data/app/logo.png" alt="logo">
                <h2 class="pt-1 text-xl font-semibold">Administration</h2>
            </div>

            <form class="authForm w-full p-4" action="{{ url($url) }}" method="POST">
                {{csrf_field()}}
                @yield('content')
            </form>
        </div>
    </body>
</html>
