<!DOCTYPE html>
<html lang="<?= LaravelLocalization::getCurrentLocale(); ?>"
<head>
	<meta charset="utf-8">
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=9">
	<![endif]-->
	@yield('hreflang')

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content=""/>
	<meta property="og:title" content=""/>
	<meta property="og:description" content=""/>
	<meta property="og:image" content=""/>

	<link rel="icon" type="image/png" href="{{asset('/storage/favicon.png')}}" />

	<!--[if lte IE 9]>
		<script src="{{asset('/storage/html5shiv.min.js')}}"></script>
	<![endif]-->

	<!-- CSRF Token -->
	<meta id="token" name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title')</title>

	<link rel="stylesheet" href="{{ mix('/css/front.css')}}">

</head>
<!-- Global Site Tag (gtag.js) - Google Analytics -->
{{-- <script async src="https://www.googletagmanager.com/gtag/js?id={{env('GA_TRACKING_ID')}}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{env("GA_TRACKING_ID")}}');
</script> --}}
<body>
	<div id="front" v-cloak>
		<transition appear name="fade" mode="out-in">
			<div>
				<component is="{{$component}}" data="{{$data or ''}}" inline-template>
					<div class="content front">
						@yield('content')
					</div>
				</component>
			</div>
		</transition>
	</div>
	<!-- Scripts -->
	<script src="{{ mix('/js/front.js')}}"></script>
</body>
</html>
