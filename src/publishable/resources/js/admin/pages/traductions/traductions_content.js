import Vue from 'vue'
import addSectionWithListe from '../../app/addSectionWithListe.vue'
import zoneBloc from './zoneBloc.vue'
import zoneFilter from './zoneFilter.vue'
import store from './TraductionsStore'

Vue.component('traductions_content',{
	props: ['tab'],

	components: {addSectionWithListe, zoneBloc, zoneFilter},

	data() {
		return {
			byZone: [],
			filteredZones: [],
			store,
			availableLangues: {},
			currentLang: 'en'
		}
	},

	created(){
		Event.listen('entityAdded', this.fecthListe)
		this.getAvailableLangues()

		Event.listen('availableLanguagesChanged', this.getAvailableLangues)
	},

	watch: {
		currentLang(value){
			this.store.setLang(value)
			this.fecthListe()
		}
	},


	mounted(){
		this.fecthListe()
	},

	methods: {
		/**
		 * Récupère les infos de chaque onglet
		 *
		 * @param   String  tab
		 * @return  void
		 */
		fecthListe(){
			if(this.store.state.currentTab==this.tab){
				axios.get(`/admin/traductions`, {'params': {'lang':this.currentLang}})
				.then(({data}) => {
					this.byZone = data
					this.filteredZones = Object.keys(data)

					Vue.nextTick(function () {
						Event.fire('filterZone')
					})
				})
			}
		},

		/**
		 * Récupère les langues disponibles dans l'admin
		 *
		 * @return  {[type]}  [description]
		 */
		getAvailableLangues(){
			axios.get(`/admin/traductions/langues/available`)
			.then(({data}) => {
				this.availableLangues = data
			})
		},


		/**
		 * Attribue les zones filtrées
		 *
		 * @param   Array  filteredZones
		 *
		 * @return  void
		 */
		filterZone(filteredZones){
			this.filteredZones = filteredZones
		},


		/**
		 * Détermine si un nom de zone fait partie des zones filtrées
		 *
		 * @param   String  key
		 *
		 * @return  Boolean
		 */
		contains(key){
			return _.includes(this.filteredZones, key)
		}
	}
})
