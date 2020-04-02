import Vue          from 'vue';
import store from './userStore'
import droit from './droit.vue'

Vue.component('droits', {

	props: ['tab'],

	components: {droit},

	data() {
		return {
			droits: {},
			store
		}
	},

	created(){
		Event.listen('tabSelected', this.fetchDroits)
	},

	methods: {
		fetchDroits(){
			if(this.tab==this.store.state.currentTab){
				axios.get('/admin/utilisateurs/droits').then(({data}) => {
					this.droits = data
				})
			}
		}
	}
})
