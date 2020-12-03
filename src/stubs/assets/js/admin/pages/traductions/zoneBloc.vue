<template>
	<div class="zone">
		<div class="content">
			<h2 class="zoneHeader">
				<div class="zoneName" v-text="keyName"></div>
			</h2>

			<div class="headers">
				<div class="key head">Clé de transcription</div>

				<div class="fr head">
					Français
					<button
						class='button'
						:class="{'is-danger': !isPublished.fr, 'is-success': isPublished.fr}"
						@click.prevent="publish(currentZone, 'fr')"
						v-text="publishingStateText(frenchLang)">
					</button>
				</div>

				<div class="localized head">
					<span v-text="localizedLang.nom"></span>
					<button
						class='button'
						:class="{'is-danger': !isPublished[localizedLang.code], 'is-success': isPublished[localizedLang.code]}"
						@click.prevent="publish(currentZone, localizedLang.code)"
						v-text="publishingStateText(localizedLang)">
					</button>
				</div>
			</div>


			<traduction
				v-for="item in traductions"
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
		props : ['keyName', 'traductions'],

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
				currentZone: this.traductions[0].zone.id
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
			Event.listen('editInPlaceSaved', this.toBePublished)
			Event.listen('langueChanged', this.toBePublished)
		},

		mounted(){
			this.toBePublished()
		},


		/*
		|--------------------------------------------------------------------------
		| Méthodes du composant
		|--------------------------------------------------------------------------
		*/
		methods:{
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
			 * Détermine si une zone est publiée ou non
			 *
			 * @return  {[type]}  [description]
			 */
			toBePublished(){
				axios.get(`/admin/traductions/zones/is_published/${this.currentZone}/${this.localizedLang.code}`).then(({data}) => {
					this.isPublished['fr'] = data.fr
					this.isPublished[this.localizedLang.code] = data.localized
				})
			},


			/**
			 * Publie une zone en entier
			 *
			 * @param   String zone
			 * @param   String lang
			 *
			 * @return  Json
			 */
			publish(zone, lang){
				axios.put(`/admin/traductions/zones/publish/${zone}/${lang}`).then(({data}) => {
					notify(data)
					this.toBePublished()
				}).catch(({response: {error: {data}}}) => {
					notify(data)
				})
			},
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
				background-color: #ccc;
				text-align: center;
				font-weight: bold;
				display: flex;
				align-items: center;
				justify-content: space-between;
				padding: 0 10px;

				&.key{
					width: 22%;
					margin-right: 1%;
				}

				&.fr{
					margin-right: 1%;
				}

				&.fr, &.localized{
					width: 38%;
				}
			}
		}
	}
</style>
