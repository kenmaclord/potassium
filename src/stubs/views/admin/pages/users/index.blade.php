@extends('admin.layout', ['page'=>"users"])

@section('content')
  <div id="users">
    <div class="content">
      <h1>Gestion des utilisateurs</h1>
    </div>

	<add-section
		button-text="Ajouter un utilisateur"
		route-create="/admin/utilisateurs"
		:fields="[
			{titre: 'Prénom', name: 'first_name', type: 'text'},
			{titre: 'Nom', name: 'last_name', type: 'text'}
		]"
		nullable="[]">
	</add-section>

	<div class="users" v-sortable="options">
    	<user :data='user' v-for="user in users" :key="user.id"></user>
    </div>

	<modal></modal>
  </div>
@endsection
