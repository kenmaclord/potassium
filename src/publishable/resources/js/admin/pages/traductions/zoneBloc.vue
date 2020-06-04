<template>
	<div class="zone">
		<div class="content">
			<h2 class="zoneHeader">
				<div class="zoneName" v-text="zone.nom"></div>
			</h2>

			<div class="headers">
				<div class="key head">Clé de transcription</div>

				<div class="fr head">
					Français
					<button
						class='button'
						:class="{'is-danger': !isPublished.fr, 'is-success': isPublished.fr}"
						@click.prevent="publish('fr')"
						v-text="publishingStateText(frenchLang)">
					</button>
				</div>

				<div class="localized head">
					<span v-text="localizedLang.nom"></span>
					<button
						class='button'
						:class="{'is-danger': !isPublished[localizedLang.code], 'is-success': isPublished[localizedLang.code]}"
						v-text="publishingStateText(localizedLang)"
						@click.prevent="publish(localizedLang.code)">
					</button>
				</div>
			</div>

			<traduction
				v-for="item in zone.traductions"
				:key="item.id"
				:item="item">
			</traduction>
		</div>
	</div>
</template>

<script>
	import traduction from './traduction.vue'
	import store  from './TraductionsStore'

	export default {
		/*
		|--------------------------------------------------------------------------
		| Déclaration des composants enfants utilisés
		|--------------------------------------------------------------------------
		*/
		components : {traduction},


		/*
		|--------------------------------------------------------------------------
		| Gestion des data du composant (props, data, computed et watch)
		|--------------------------------------------------------------------------
		*/
		props : ['zone'],

		data(){
			return {
				isPublished: {
					'fr' : false,
					'en' : false,
					'de' : false,
					'it' : false,
					'es' : false,
					'zh' : false,
					'pt' : false,
					'ja' : false,
					'ar' : false,
					'ru' : false,
					'pl' : false
				},
				store,
			}
		},

		computed: {
			/**
			 * Shortcut pour la langue en cours de traduction
			 *
			 * @return  {[type]}  [description]
			 */
			localizedLang(){
				return this.store.state.currentLocalizedLang
			},

			frenchLang(){
				return this.store.state.frenchLang
			},
		},


		/*
		|--------------------------------------------------------------------------
		| Méthode d'initialisation
		|--------------------------------------------------------------------------
		*/
		created(){
			Event.listen('editInPlaceSaved', this.updatePublishState)
			Event.listen('langueChanged', this.setPublishState)
		},

		mounted(){
			this.setPublishState()
		},


		/*
		|--------------------------------------------------------------------------
		| Méthodes du composant
		|--------------------------------------------------------------------------
		*/
		methods:{
			/**
			 * Publie une zone en entier
			 *
			 * @param   String zone
			 * @param   String lang
			 *
			 * @return  Json
			 */
			publish(lang){
				axios.put(`/admin/zones/publish/${this.zone.id}/${lang}`).then(({data}) => {
					notify(data)
					this.isPublished[lang] = true
				}).catch(({response: {error: {data}}}) => {
					notify(data)
				})
			},


			/**
			 * Retourne le texte du bouton pour publier la langue
			 *
			 * @return  String
			 */
			publishingStateText(lang){
				if(this.isPublished[lang.code]){
					return "Traduction publiées"
				}

				let voyelles = ['a', 'e', 'i', 'o', 'u']
				let article = "le "

				let langName = lang.nom.toLowerCase()

				if(voyelles.indexOf(langName.substr(0,1))>-1){
					article = "l'"
				}

				return `Publier ${article}${langName}`
			},


			/**
			 * Attribue l'état de publication d'une zone
			 *
			 * @return  void
			 */
			setPublishState(data){
				if (!$.empty(this.zone.published)) {
					let publishedStates = JSON.parse(this.zone.published)

					this.isPublished['fr'] = publishedStates['fr']
					this.isPublished[this.localizedLang.code] = publishedStates[this.localizedLang.code]
				}else{
					this.isPublished['fr'] = false
					this.isPublished[this.localizedLang.code] = false
				}
			},


			/**
			 * Met à jour l'état de publication d'une zone
			 *
			 * @param   Json  data
			 *
			 * @return  void
			 */
			updatePublishState(data){
				if (data.context == this.zone.slug) {
					this.isPublished[data.field] = false
				}
			}
		}
	}
</script>


<style scoped lang='scss'>
	.zone{
		.button.is-success{
			pointer-events: none;
			cursor: default;
		}

		.zoneHeader{
			display: flex;
			justify-content: space-between;
		}

		.headers{
			display: flex;
			min-height: 50px;
			align-items: stretch;

			.head{
				background-color: var(--color-gray-200);
				text-align: center;
				font-weight: bold;
				display: flex;
				align-items: center;
				justify-content: space-between;
				padding: 0 10px;

				&.key{
					width: 22%;
					min-width: 250px;
				}

				&.key, &.fr{
					margin-right: 10px;
				}

				&.fr, &.localized{
					flex: 1;
				}
			}
		}
	}
</style>
