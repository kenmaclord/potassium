<div id="langues">
	<div class="content">
		<h1>Gestion des Langues</h1>
	</div>

	<div class="langue head">
		<div class="col head nom">Nom</div>
		<div class="col head traduction">Traduction</div>
		<div class="col head code">Code</div>
		<div class="col head visible">
			<span class="desktop">Visible par le public</span>
			<span class="phone">Public</span>
		</div>
		<div class="col head available">
			<span class="desktop">Disponible dans l'admin</span>
			<span class="phone">Admin</span>
		</div>
	</div>

	<langue v-for="langue in langues" :langue="langue" :key="langue.id"></langue>
</div>
