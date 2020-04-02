@extends('admin.layout', ['page'=>"user"])

@section('content')
  <div id="profile">
	<div class="content">
		@include('admin.pages.users.headerShow')

		<tabs :store="userStore">
			<tab name="profile" title="Profile" :selected="true">
				<component is="profile" tab="profile" inline-template>
					@include('potassium::admin.pages.users.profile')
				</component>
			</tab>

			<tab name="droits" title="Droits">
				<component is="droits" tab="droits" inline-template>
					@include('potassium::admin.pages.users.droits')
				</component>
			</tab>
		</tabs>
	</div>
  </div>
@endsection
