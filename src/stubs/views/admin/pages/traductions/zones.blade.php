<div id="zones">
	<div class="content">
		<h1>Gestion des Zones</h1>
	</div>

	<add-section
		button-text="Ajouter une zone"
		route-create="/admin/traductions/zones"
		:fields="[
			{titre: 'Nom de la zone', name: 'nom', type: 'text'}
		]"
		nullable="[]">
	</add-section>

	<div class="zones" v-sortable="options">
		<zone
			:data-zone="zone"
			v-for="zone in zones"
			:key="zone.id">
		</zone>
	</div>

	<modal context="zones"></modal>
</div>
