<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'DCW éditions')</title>

    <link rel="stylesheet" href="/css/auth.css">
</head>
<body>

  <div class="container" id="auth">
    @yield('content')
  </div>

  <!-- Scripts -->
  <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
  </script>

</body>
</html>
