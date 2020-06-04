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
			store,
			availableLangues: {},
			currentLocalizedLang: 'en'
		}
	},

	created(){
		Event.listen('entityAdded', this.fetchListe)
		Event.listen('availableLanguagesChanged', this.getAvailableLangues)
		Event.listen('refreshSelectItemsList', this.fetchListeWithNoCondition)

        this.store.setLang(this.currentLocalizedLang)
		this.getAvailableLangues()
	},

	watch: {
		currentLocalizedLang(value){
			this.store.setLang(value)
			this.fetchListe()
		}
	},


	mounted(){
		this.fetchListe()
	},

	methods: {
		/**
		 * Récupère les infos de zones et de traductions
		 * si l'onglet Content est ouvert
		 *
		 * @return  void
		 */
		fetchListe(){
			if(this.store.state.currentTab == this.tab){
				this.fetchListeWithNoCondition()
			}
		},


		/**
		 * Récupère les infos de zones et de traductions
		 *
		 * @return  void
		 */
		fetchListeWithNoCondition(){
			axios.get(`/admin/zones`)
			.then(({data}) => {
				this.byZone = data

				Vue.nextTick(() =>  {
					this.store.setAllZones(data)
				})
			})
		},



		/**
		 * Récupère les langues disponibles dans l'admin
		 *
		 * @return  {[type]}  [description]
		 */
		getAvailableLangues(){
			axios.get(`/admin/langues/available`)
			.then(({data}) => {
				this.availableLangues = data
			})
		},


		/**
		 * Vérifie si la zone passée en paramètre est dans la liste des zones filtrées
		 *
		 * @param   {[type]}  key
		 *
		 * @return  {[type]}       [description]
		 */
		contains(key){
			return _.includes(this.store.state.filteredZones, key)
		}
	}
})
