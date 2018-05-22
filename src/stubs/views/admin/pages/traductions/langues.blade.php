<div id="langues">
	<div class="content">
		<h1>Gestion des Langues</h1>
	</div>

	<div class="langue head">
		<div class="field head nom">Nom</div>
		<div class="field head traduction">Traduction</div>
		<div class="field head code">Code</div>
		<div class="field head visible">
			<span class="desktop">Visible par le public</span>
			<span class="phone">Public</span>
		</div>
		<div class="field head available">
			<span class="desktop">Disponible dans l'admin</span>
			<span class="phone">Admin</span>
		</div>
	</div>

	<langue v-for="langue in langues" :langue="langue" :key="langue.id"></langue>
</div>
