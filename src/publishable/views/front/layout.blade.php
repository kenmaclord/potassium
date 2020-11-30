<!DOCTYPE html>
<html lang="{{LaravelLocalization::getCurrentLocale()}}">
	<head>
		<meta charset="utf-8">
		@yield('hreflang')

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta name="description" content=""/>

		@yield('openGraphData')

		<link rel="icon" type="image/png" href="{{asset('/favicon.png')}}" />

		<!-- CSRF Token -->
		<meta id="token" name="csrf-token" content="{{ csrf_token() }}">

		<title>@yield('title')</title>

		<link rel="stylesheet" href="{{ mix('/css/front.css')}}">
	</head>

	<body>
		<div id="front" v-cloak>
			<transition appear name="fade" mode="out-in">
				<div>
					<component is="{{$component}}" :data="{{json_encode($data) ?? ''}}" inline-template>
						<div class="front-content">
							@yield('content')
						</div>
					</component>
				</div>
			</transition>
		</div>

		<!-- Scripts -->
        <script src="{{ mix('/js/manifest.js') }}"></script>
        <script src="{{ mix('/js/vendor.js') }}"></script>
		<script src="{{ mix('/js/front.js') }}"></script>
	</body>
</html>
