<!DOCTYPE html>
<html lang="fr">
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
<body>
  <div id="admin">
    <!-- Notifications -->
    <notification
      type="{{Session::get('status')}}"
      message="{{Session::get('message')}}">
    </notification>

    @include ('admin.app.sidebar')

    <div class="content">
      @include ('admin.app.header')

      <component is="{{$page}}" data="{{$data ?? null}}" inline-template>
        <div class="page">
          @yield('content')
        </div>
      </component>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{mix('/js/admin.js')}}"></script>
</html>
