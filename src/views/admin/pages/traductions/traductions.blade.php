<div id="traductions-content">
	<div class="content">
		<h1>Gestion des Traductions</h1>

		<zone-filter :data="byZone" @filter="filterZone"></zone-filter>
	</div>

	<div class="control">
		<label class="label">Langue de traduction</label>
		<div class="select">
			<select v-model="currentLang">
				<option v-for="lang in availableLangues" :value="lang.code" v-text="lang.nom"></option>
			</select>
		</div>
	</div>


	<add-section-with-liste
		button-text="Ajouter une traduction"
		route-create="/admin/traductions"
		titre="Clé de la nouvelle entrée"
		liste-titre="Zone de traduction"
		liste-url="/admin/traductions/zones"
		input-name="key"
		select-name="zone_id">
	</add-section-with-liste>



	<div class="zones" v-for="(traductions, key) in byZone" v-show="contains(key)">
		<zone-bloc
			:key-name="key"
			:traductions="traductions">
		</zone-bloc>
	</div>


 </div>
