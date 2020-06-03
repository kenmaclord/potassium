<div id="traductions-content">
	<div class="content flex">
		<h1>Gestion des Traductions</h1>

		<zone-filter class="flex-1"></zone-filter>

		<div class="control">
			<label class="label mr-4">Langue de traduction</label>
			<div class="select">
				<select v-model="currentLocalizedLang">
					<option v-for="lang in availableLangues" :value="lang.code" v-text="lang.nom"></option>
				</select>
			</div>
		</div>
	</div>



	<add-section-with-liste
		button-text="Ajouter une traduction"
		route-create="/admin/traductions"
		titre="Clé de la nouvelle entrée"
		liste-titre="Zone de traduction"
		liste-url="/admin/zones"
		input-name="key"
		select-name="zone_id">
	</add-section-with-liste>

	<div class="zones mt-6" v-for="zone in byZone" v-show="contains(zone.slug)">
		<zone-bloc :zone="zone" />
	</div>
 </div>
