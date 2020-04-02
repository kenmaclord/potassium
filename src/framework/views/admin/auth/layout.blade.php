<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', env("APP_NAME"))</title>

        <link rel="stylesheet" href="/css/auth.css">
    </head>

    <body>
        <div class="container" id="auth">
            <div class="column is-6 is-offset-3">
                <form class="authForm" action="{{ url($url) }}" method="POST">
                    {{csrf_field()}}

                    <div class="logo column is-offset-2">
                        <div style="max-width: 400px; display:flex; flex-direction: column; align-items: center;">
                            <img style="width:320px;" src="/data/app/logo.png" alt="logo">
                            <h2 style="margin-top: 5px;">Administration</h2>
                        </div>
                    </div>

                    @yield('content')
                </form>
            </div>
        </div>

  <!-- Scripts -->
  <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
  </script>

</body>
</html>
