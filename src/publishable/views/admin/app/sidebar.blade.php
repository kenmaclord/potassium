<div class="sidebar" :class="{open: menuOpen}">

	<div class="logo">
		<h1>{{ucwords(env('APP_NAME'))}}</h1>
		<img src="" alt="">
	</div>

	<ul>
		<li><a href='/admin/'>Dashboard</a></li>

		{{-- @page --}}

		@can('manage', [Entities\User::class, 'users'])
			<li><a href='/admin/utilisateurs'>Utilisateurs</a></li>
		@endcan

		@can('manage', [Entities\User::class, 'traductions'])
			<li><a href='/admin/traductions'>Traductions</a></li>
		@endcan
	</ul>
</div>
